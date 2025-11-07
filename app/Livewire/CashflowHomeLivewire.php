<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Cashflow;

class CashflowHomeLivewire extends Component
{
    use WithPagination, WithFileUploads;

    public $auth;
    public $search = '';
    public $filterType = 'all'; // Properti baru untuk filter: 'all', 'income', 'expense'
    public $showModal = false;

    // form fields
    public $title;
    public $type = 'expense';
    public $amount;
    public $description;
    public $receipt;
    public $editingId = null;
    public $currentReceipt = null;
    public $chartData;

    protected $listeners = ['confirmDelete', 'delete-confirmed' => 'deleteCashflow', 'saveAndClose', 'discardAndClose', 'trixUpdated' => 'onTrixUpdated']; 

    public function mount()
    {
        $this->auth = Auth::user();
        $this->prepareChartData();
    }


    public function render()
    {
        $query = Cashflow::where('user_id', $this->auth->id)
            ->where('title', 'like', '%'.$this->search.'%');

        // Terapkan filter berdasarkan tipe
        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        $cashflows = $query->orderBy('created_at', 'desc')
                           ->paginate(20);

        $totalIncome = Cashflow::where('user_id', $this->auth->id)
            ->where('type', 'income')->sum('amount');
        $totalExpense = Cashflow::where('user_id', $this->auth->id)
            ->where('type', 'expense')->sum('amount');

        $this->prepareChartData();

        return view('livewire.cashflow-home-livewire', [
            'cashflows' => $cashflows,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
        ]);
    }

    public function prepareChartData()
    {
        $data = Cashflow::where('user_id', $this->auth->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                // Use single quotes inside SQL literals for PostgreSQL
                DB::raw('SUM(CASE WHEN type = \'income\' THEN amount ELSE 0 END) as total_income'),
                DB::raw('SUM(CASE WHEN type = \'expense\' THEN amount ELSE 0 END) as total_expense')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Normalize data to arrays: [timestamp_ms, value]
        $incomeData = $data->map(function ($item) {
            $timestamp = strtotime($item->date);
            return [($timestamp * 1000), (float) $item->total_income];
        })->values()->toArray();

        $expenseData = $data->map(function ($item) {
            $timestamp = strtotime($item->date);
            return [($timestamp * 1000), (float) $item->total_expense];
        })->values()->toArray();

        $this->chartData['income'] = $incomeData;
        $this->chartData['expense'] = $expenseData;

        $this->dispatch('chart-data', ['income' => $this->chartData['income'], 'expense' => $this->chartData['expense']]);
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        // Cek apakah ada perubahan yang belum disimpan saat mode edit
        if ($this->editingId && $this->isDirty()) {
            $this->dispatch('swal:confirm-close', [
                'title' => 'Simpan perubahan?',
                'text' => 'Anda memiliki perubahan yang belum disimpan. Apa yang ingin Anda lakukan?',
                'confirmButtonText' => 'Simpan',
                'denyButtonText' => 'Jangan Simpan',
            ]);
            return;
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'receipt' => $this->editingId ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ]);

        try {
            if ($this->editingId) {
                $this->update();
            } else {
                $this->create();
            }

            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => $this->editingId ? 'Berhasil Update!' : 'Berhasil Simpan!',
                'text' => $this->editingId ? 'Data berhasil diperbarui.' : 'Data berhasil ditambahkan.'
            ]);
            
            $this->closeModal();
            $this->prepareChartData(); // Refresh chart data
        } catch (\Exception $e) {
            $this->dispatch('swal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    private function create()
    {
        try {
            $path = $this->receipt->store('receipts', 'public');
    
            Cashflow::create([
                'user_id' => $this->auth->id,
                'title' => $this->title,
                'type' => $this->type,
                'amount' => $this->amount,
                'description' => $this->description,
                'receipt' => $path,
            ]);
    
            $this->dispatch('swal', [
                'icon' => 'success', 
                'title' => 'Kerja Bagus!', 
                'text' => 'Data berhasil ditambahkan.'
            ]);
            $this->prepareChartData(); // Refresh chart data
        } catch (\Exception $e) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Gagal!', 'text' => 'Terjadi kesalahan saat menambahkan data.']);
        }
    }

    public function edit($id)
    {
        $cashflow = Cashflow::find($id);
        if (!$cashflow || $cashflow->user_id != $this->auth->id) {
            $this->dispatch('swal:toast', ['icon' => 'error', 'title' => 'Data tidak ditemukan.']);
            return;
        }

        $this->reset(['title', 'type', 'amount', 'description', 'receipt']);
        
        $this->editingId = $id;
        $this->title = $cashflow->title;
        $this->type = $cashflow->type;
        $this->amount = $cashflow->amount;
        $this->description = $cashflow->description;
        $this->currentReceipt = $cashflow->receipt;

        $this->openModal();
        
    // Dispatch a Livewire event to update the Trix editor content after modal is shown
    // Use $this->dispatch(...) because this Livewire version exposes a dispatch() helper
    // which the frontend listens for via Livewire.on(...)
    $this->dispatch('set-trix-content', ['content' => $this->description]);
    }

    // Called from JS when Trix editor content changes
    public function onTrixUpdated($content)
    {
        $this->description = $content;
    }

    private function update()
    {
        $cashflow = Cashflow::find($this->editingId);
        if (!$cashflow || $cashflow->user_id != $this->auth->id) { // Cek kepemilikan
            $this->dispatch('swal:toast', ['icon' => 'error', 'title' => 'Data tidak ditemukan.']);
            $this->closeModal();
            return;
        }

        try {
            $data = [
                'title' => $this->title,
                'type' => $this->type,
                'amount' => $this->amount,
                'description' => $this->description,
            ];
    
            if ($this->receipt) {
                if ($cashflow->receipt) {
                    Storage::disk('public')->delete($cashflow->receipt);
                }
                $data['receipt'] = $this->receipt->store('receipts', 'public');
            }
    
            $cashflow->update($data);
    
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Tersimpan!',
                'text' => 'Perubahan berhasil disimpan.'
            ]);
            $this->prepareChartData(); // Refresh chart data
        } catch (\Exception $e) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Gagal!', 'text' => 'Terjadi kesalahan saat memperbarui data.']);
        }
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Yakin hapus data?',
            'text' => "Data yang dihapus tidak dapat dikembalikan!",
            'id' => $id,
            'confirmButtonText' => 'Ya, hapus!',
            'method' => 'deleteCashflow'
        ]);
    }

    // Hapus Data
    public function deleteCashflow($id)
    {
        $cashflow = Cashflow::find($id);
        if (!$cashflow || $cashflow->user_id != $this->auth->id) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Gagal!', 'text' => 'Data tidak ditemukan atau Anda tidak berhak menghapusnya.']);
            return;
        }

        try {
            if ($cashflow->receipt && Storage::disk('public')->exists($cashflow->receipt)) {
                Storage::disk('public')->delete($cashflow->receipt);
            }
            $cashflow->delete();
            
            $this->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Terhapus!',
                'text' => 'Data berhasil dihapus.',
            ]);
            $this->prepareChartData(); // Refresh chart data
        } catch (\Exception $e) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Gagal!', 'text' => 'Terjadi kesalahan saat menghapus data.']);
        }
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->title = '';
        $this->type = 'expense';
        $this->amount = '';
        $this->description = '';
        $this->receipt = null;
        $this->currentReceipt = null;

        $this->dispatch('reset-trix');

        $this->dispatch('reset-trix');
    }

    private function isDirty()
    {
        if ($this->editingId) {
            $cashflow = Cashflow::find($this->editingId);
            return $this->title != $cashflow->title ||
                   $this->type != $cashflow->type ||
                   $this->amount != $cashflow->amount ||
                   $this->description != $cashflow->description ||
                   !is_null($this->receipt);
        }
        return false;
    }

    public function saveAndClose()
    {
        $this->save();
        if (!$this->hasErrors()) {
            $this->closeModal();
        }
    }

    public function discardAndClose()
    {
        $this->showModal = false;
        $this->resetForm();
    }
}
