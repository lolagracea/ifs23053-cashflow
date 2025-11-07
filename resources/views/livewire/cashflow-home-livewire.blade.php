<div>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Poppins');

        #chart {
            font-family: 'Poppins', sans-serif;
            width: 100%;
            margin: 0 auto;
            opacity: 0.9;
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            height: 400px;
        }

        .apexcharts-toolbar {
            opacity: 1 !important;
            border: 0 !important;
        }

        .apexcharts-menu {
            background: #fff !important;
            border: 1px solid #eee !important;
            border-radius: 4px !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        }

        .apexcharts-menu-item:hover {
            background: #f8f9fa !important;
        }

        .apexcharts-tooltip {
            background: #fff !important;
            border: none !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15) !important;
            border-radius: 4px !important;
            padding: 8px !important;
        }

        .apexcharts-tooltip-title {
            background: #f8f9fa !important;
            border: none !important;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 600 !important;
        }

        .apexcharts-xaxistooltip {
            background: #fff !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
            color: #333 !important;
            font-family: 'Poppins', sans-serif !important;
        }

        #timeline-chart .apexcharts-toolbar {
            opacity: 1;
            border: 0;
        }

        .apexcharts-tooltip {
            color: #333;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        .apexcharts-tooltip .apexcharts-tooltip-series-group {
            background: #f8f9fa !important;
            padding: 8px;
        }

        .apexcharts-toolbar {
            z-index: 10;
        }

        .apexcharts-canvas {
            border-radius: 8px;
            background: #fff;
        }
        
        .btn-primary {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .table tbody tr {
            transition: background-color 0.2s;
        }
        
        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }
        
        .modal-content {
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .badge {
            font-weight: 500;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
            border-color: #667eea;
        }

        /* Styling untuk konten Trix */
        .trix-content {
            line-height: 1.6;
        }
        
        .trix-content h1 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        
        .trix-content p {
            margin-bottom: 0.75rem;
        }
        
        .trix-content ul, .trix-content ol {
            padding-left: 1.5rem;
            margin-bottom: 0.75rem;
        }
        
        .trix-content strong {
            font-weight: 600;
        }
        
        .trix-content a {
            color: #667eea;
            text-decoration: underline;
        }

        /* Button hover effects */
        .btn-group .btn {
            transition: all 0.2s ease;
        }

        .btn-group .btn:hover {
            transform: translateY(-1px);
        }

        /* Statistics card hover effect */
        .stats-card {
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        /* Table row animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table tbody tr {
            animation: fadeIn 0.3s ease;
        }
    </style>

    {{-- Header Card --}}
    <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between text-white flex-wrap gap-3">
                <div>
                    <h3 class="mb-1 fw-bold">Hai, {{ $auth->name }}! 👋</h3>
                    <p class="mb-0 opacity-75">Selamat datang kembali di dashboard Anda</p>
                </div>
                <a href="{{ route('auth.logout') }}" class="btn btn-light fw-semibold px-4 shadow-sm">
                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                </a>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 stats-card" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="d-flex align-items-center text-white">
                        <div class="flex-grow-1">
                            <p class="mb-2 opacity-75 small text-uppercase fw-semibold">Total Pemasukan</p>
                            <h2 class="mb-0 fw-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h2>
                            <p class="mb-0 mt-2 small opacity-75">
                                <i class="bi bi-graph-up-arrow me-1"></i>Semua waktu
                            </p>
                        </div>
                        <div class="ms-3">
                            <i class="bi bi-arrow-up-circle-fill" style="font-size: 3.5rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 stats-card" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);">
                    <div class="d-flex align-items-center text-white">
                        <div class="flex-grow-1">
                            <p class="mb-2 opacity-75 small text-uppercase fw-semibold">Total Pengeluaran</p>
                            <h2 class="mb-0 fw-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h2>
                            <p class="mb-0 mt-2 small opacity-75">
                                <i class="bi bi-graph-down-arrow me-1"></i>Semua waktu
                            </p>
                        </div>
                        <div class="ms-3">
                            <i class="bi bi-arrow-down-circle-fill" style="font-size: 3.5rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 stats-card" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex align-items-center text-white">
                        <div class="flex-grow-1">
                            <p class="mb-2 opacity-75 small text-uppercase fw-semibold">Sisa Uang</p>
                            <h2 class="mb-0 fw-bold">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</h2>
                            <p class="mb-0 mt-2 small opacity-75">
                                <i class="bi bi-cash-stack me-1"></i>Saldo tersedia
                            </p>
                        </div>
                        <div class="ms-3">
                            <i class="bi bi-wallet2" style="font-size: 3.5rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Card --}}
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title fw-bold mb-0">
                            <i class="bi bi-graph-up text-primary me-2"></i>Statistik 30 Hari Terakhir
                        </h5>
                        <span class="badge bg-light text-dark px-3 py-2">
                            <i class="bi bi-calendar-range me-1"></i>30 Hari
                        </span>
                    </div>
                    <div id="chart" wire:ignore></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px;">
                <div class="card-body p-4 d-flex flex-column">
                    <h5 class="card-title fw-bold mb-3">
                        <i class="bi bi-pie-chart-fill text-primary me-2"></i>Ringkasan Total
                    </h5>
                    <div id="pie-chart" wire:ignore class="flex-grow-1 d-flex align-items-center justify-content-center"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-journal-text text-primary me-2"></i>Daftar Transaksi
                </h5>
            </div>

            {{-- Search and Add Button --}}
            <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                {{-- Search Input --}}
                <div class="input-group shadow-sm" style="max-width: 500px; flex: 1 1 300px;">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari transaksi..." wire:model.live="search">
                </div>
                {{-- Add Button --}}
                <button class="btn btn-primary btn-lg fw-semibold px-4 shadow-sm" wire:click="openModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; white-space: nowrap;">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Transaksi
                </button>
            </div>

            {{-- Filter Buttons --}}
            <div class="mb-4 d-flex justify-content-start">
                <div class="btn-group shadow-sm" role="group" aria-label="Filter Transaksi" style="border-radius: 10px; overflow: hidden;">
                    <button type="button" class="btn {{ $filterType == 'all' ? 'btn-primary' : 'btn-outline-primary' }} fw-semibold px-4 py-2" wire:click="$set('filterType', 'all')" style="{{ $filterType == 'all' ? 'background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;' : '' }}">
                        <i class="bi bi-list-ul me-2"></i>Semua
                    </button>
                    <button type="button" class="btn {{ $filterType == 'income' ? 'btn-success' : 'btn-outline-success' }} fw-semibold px-4 py-2" wire:click="$set('filterType', 'income')">
                        <i class="bi bi-arrow-up-circle me-2"></i>Pemasukan
                    </button>
                    <button type="button" class="btn {{ $filterType == 'expense' ? 'btn-danger' : 'btn-outline-danger' }} fw-semibold px-4 py-2" wire:click="$set('filterType', 'expense')">
                        <i class="bi bi-arrow-down-circle me-2"></i>Pengeluaran
                    </button>
                </div>
            </div>

            {{-- Data Table --}}
            <div class="table-responsive" style="border-radius: 10px; overflow: hidden;">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <tr>
                            <th class="fw-semibold py-3 text-center" style="width: 60px;">No</th>
                            <th class="fw-semibold py-3">Judul</th>
                            <th class="fw-semibold py-3 text-center" style="width: 150px;">Jenis</th>
                            <th class="fw-semibold py-3" style="width: 180px;">Nominal</th>
                            <th class="fw-semibold py-3 text-center" style="width: 280px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cashflows as $index => $item)
                        <tr style="border-bottom: 1px solid #f1f3f5;">
                            <td class="text-center">
                                <span class="badge bg-light text-dark fw-semibold">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; background: {{ $item->type == 'income' ? 'linear-gradient(135deg, #11998e 0%, #38ef7d 100%)' : 'linear-gradient(135deg, #ee0979 0%, #ff6a00 100%)' }};">
                                            <i class="bi {{ $item->type == 'income' ? 'bi-arrow-up' : 'bi-arrow-down' }} text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ $item->title }}</p>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>{{ $item->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($item->type == 'income')
                                    <span class="badge rounded-pill" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); padding: 8px 14px; font-size: 12px;">
                                        <i class="bi bi-arrow-up-circle me-1"></i>Pemasukan
                                    </span>
                                @else
                                    <span class="badge rounded-pill" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); padding: 8px 14px; font-size: 12px;">
                                        <i class="bi bi-arrow-down-circle me-1"></i>Pengeluaran
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold" style="color: {{ $item->type == 'income' ? '#11998e' : '#ee0979' }}; font-size: 15px;">
                                    Rp {{ number_format($item->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm" role="group">
                                    <button class="btn btn-sm btn-outline-info d-flex align-items-center gap-1 px-3" wire:click="showDetail({{ $item->id }})" title="Lihat Detail">
                                        <i class="bi bi-eye-fill"></i>
                                        <span>Detail</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 px-3" wire:click="edit({{ $item->id }})" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Ubah</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 px-3" wire:click="confirmDelete({{ $item->id }})" title="Hapus">
                                        <i class="bi bi-trash3-fill"></i>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <p class="mt-3 mb-0 fw-semibold">Belum ada transaksi</p>
                                    <small>Klik tombol "Tambah Transaksi" untuk membuat transaksi baru</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $cashflows->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div id="cashflowFormModal" class="modal @if($showModal) show @endif" 
         style="display: @if($showModal) block @else none @endif;"
         tabindex="-1"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold text-white">
                        <i class="bi {{ $editingId ? 'bi-pencil-square' : 'bi-plus-circle' }} me-2"></i>
                        {{ $editingId ? 'Edit Transaksi' : 'Tambah Transaksi' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeModal"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body px-4 py-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-bookmark-fill text-primary me-2"></i>Judul
                                </label>
                                <input type="text" class="form-control" wire:model="title" placeholder="Contoh: Gaji Bulanan" required>
                                @error('title') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-tag-fill text-primary me-2"></i>Jenis
                                </label>
                                <select class="form-select" wire:model="type" required>
                                    <option value="income">💰 Pemasukan</option>
                                    <option value="expense">💸 Pengeluaran</option>
                                </select>
                                @error('type') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-cash-stack text-primary me-2"></i>Nominal
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light fw-semibold">Rp</span>
                                    <input type="number" class="form-control" wire:model="amount" placeholder="0" required>
                                </div>
                                @error('amount') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">
                                    <i class="bi bi-file-text-fill text-primary me-2"></i>Deskripsi
                                </label>
                                <div wire:ignore>
                                    <input id="description" type="hidden" name="description">
                                    <trix-editor 
                                        input="description"
                                        class="form-control trix-content"
                                        placeholder="Tambahkan catatan (opsional)"
                                        style="min-height: 150px;"
                                    ></trix-editor>
                                </div>
                                @error('description') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-image-fill text-primary me-2"></i>Bukti Transaksi
                                </label>
                                <input type="file" class="form-control" wire:model="receipt" accept="image/*">
                                <div wire:loading wire:target="receipt" class="text-primary small mt-2">
                                    <div class="spinner-border spinner-border-sm me-2" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    Mengupload gambar...
                                </div>
                                @error('receipt') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror

                                @if ($receipt)
                                    <div class="mt-3 text-center">
                                        <img src="{{ $receipt->temporaryUrl() }}" 
                                             class="img-thumbnail rounded shadow-sm" 
                                             style="max-height: 250px; object-fit: contain;">
                                    </div>
                                @elseif ($currentReceipt)
                                    <div class="mt-3 text-center">
                                        <img src="{{ Storage::url($currentReceipt) }}" 
                                             class="img-thumbnail rounded shadow-sm" 
                                             style="max-height: 250px; object-fit: contain;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4">
                        <button type="button" class="btn btn-light fw-semibold px-4 shadow-sm" wire:click="closeModal">
                            <i class="bi bi-x-circle me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="bi {{ $editingId ? 'bi-check-circle' : 'bi-save' }} me-2"></i>
                            {{ $editingId ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" style="display: @if($showModal) block @else none @endif;"></div>

    {{-- Modal Detail --}}
    @include('components.modals.todos.detail')

    {{-- Scripts --}}
    @push('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
            const cashflowFormModalEl = document.getElementById('cashflowFormModal');
            const trixEditor = document.querySelector("trix-editor");

            // --- Trix Editor Listeners ---
            if (trixEditor) {
                // Set Trix content when the modal is fully shown
                cashflowFormModalEl.addEventListener('shown.bs.modal', () => {
                    // Ambil deskripsi dari properti Livewire dan set ke editor
                    const description = @this.get('description');
                    if (trixEditor.editor) {
                        trixEditor.editor.loadHTML(description || '');
                    }
                });

                // When server asks to reset content (usually after closing modal)
                Livewire.on('reset-trix', () => {
                    if (trixEditor.editor) {
                        trixEditor.editor.loadHTML('');
                    }
                });

                // Emit changes from Trix back to Livewire
                trixEditor.addEventListener('trix-change', (e) => {
                    @this.set('description', e.target.value, false); // false agar tidak memicu request
                });

                // Saat modal ditutup, pastikan Trix juga di-reset
                cashflowFormModalEl.addEventListener('hidden.bs.modal', () => {
                    if (trixEditor.editor) {
                        trixEditor.editor.loadHTML('');
                    }
                    // Beri tahu Livewire bahwa modal sudah tertutup jika penutupan dilakukan via UI (tombol close/backdrop)
                    if (@this.get('showModal')) {
                        @this.call('closeModal');
                    }
                });
            }

            // --- ApexCharts Initialization ---
            const chartEl = document.getElementById('chart');
            // 3. Pastikan elemen ada sebelum render
            if (!chartEl) return; 

            // Function to generate demo data
            function generateDemoData() {
                const now = new Date();
                const income = [];
                const expense = [];
                for (let i = 30; i >= 0; i--) {
                    const date = new Date(now);
                    date.setDate(date.getDate() - i);
                    const incomeVal = Math.floor(Math.random() * (70000 - 30000) + 30000);
                    const expenseVal = Math.floor(Math.random() * (60000 - 20000) + 20000);
                    income.push([date.getTime(), incomeVal]);
                    expense.push([date.getTime(), expenseVal]);
                }
                return { income, expense };
            }

            // Ambil data awal yang dirender oleh server
            let initialIncome = @json($chartData['income'] ?? []);
            let initialExpense = @json($chartData['expense'] ?? []);


            //  Sebelum render chart baru, hancurkan yang lama
            if (window.cashflowChart) {
                window.cashflowChart.destroy();
                window.cashflowChart = null;
            }

            const options = {
                series: [{
                    name: 'Pemasukan',
                    data: initialIncome
                }, {
                    name: 'Pengeluaran',
                    data: initialExpense
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    toolbar: { show: true },
                    foreColor: "#999"
                },
                colors: ['#11998e', '#ee0979'], // Warna disesuaikan dengan kartu statistik
                stroke: {
                    width: [4, 4], // Lebar garis untuk Pemasukan dan Pengeluaran
                    curve: 'straight',
                    dashArray: [0, 5] // 0 untuk garis solid (Pemasukan), 5 untuk garis putus-putus (Pengeluaran)
                },
                dataLabels: {
                    enabled: false
                },
                markers: {
                    size: 0,
                    hover: {
                        sizeOffset: 6
                    }
                },
                xaxis: {
                    type: 'datetime',
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                grid: {
                    borderColor: '#f1f1f1',
                },
                tooltip: {
                    x: { format: 'dd MMM yyyy' },
                    y: {
                        formatter: function(val) {
                            return "Rp "

                            + val.toLocaleString('id-ID');
                        },
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    markers: {
                        width: 12,
                        height: 12,
                        strokeWidth: 0,
                        radius: 12,
                    },
                    itemMargin: {
                        horizontal: 10,
                        vertical: 0
                    },
                }
            };

            window.cashflowChart = new ApexCharts(chartEl, options);
            window.cashflowChart.render();

            // Listen for server-side dispatched chart data and update chart
            Livewire.on('chart-data', (event) => {
                const payload = event && (event[0] || event) || {};
                const income = payload.income || [];
                const expense = payload.expense || [];

                if (window.cashflowChart) {
                    window.cashflowChart.updateSeries([
                        { name: 'Pemasukan', data: income },
                        { name: 'Pengeluaran', data: expense }
                    ]);
                }
            });

            // --- Pie Chart Initialization ---
            const pieChartEl = document.getElementById('pie-chart');
            if (pieChartEl) {
                let initialTotalIncome = @json($totalIncome);
                let initialTotalExpense = @json($totalExpense);

                const pieOptions = {
                    series: [initialTotalIncome, initialTotalExpense],
                    chart: {
                        type: 'donut',
                        height: '100%',
                    },
                    labels: ['Pemasukan', 'Pengeluaran'],
                    colors: ['#11998e', '#ee0979'],
                    legend: {
                        position: 'bottom'
                    },
                    dataLabels: {
                        enabled: false // Menonaktifkan label pada irisan donut
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: '100%'
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                window.cashflowPieChart = new ApexCharts(pieChartEl, pieOptions);
                window.cashflowPieChart.render();

                Livewire.on('totals-updated', (event) => {
                    const payload = event && (event[0] || event) || {};
                    const income = payload.income || 0;
                    const expense = payload.expense || 0;

                    if (window.cashflowPieChart) {
                        window.cashflowPieChart.updateSeries([income, expense]);
                    }
                });
            }

            // --- SweetAlert2 Listeners ---
            Livewire.on("swal", (event) => {
                Swal.fire({
                    icon: event[0].icon,
                    title: event[0].title,
                    text: event[0].text,
                });
            });

            Livewire.on("swal:toast", (event) => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: event[0].icon,
                    title: event[0].title
                });
            });

            Livewire.on("swal:confirm", (event) => {
                Swal.fire({
                    title: event[0].title,
                    text: event[0].text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: event[0].confirmButtonText || 'Ya, lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call(event[0].method, event[0].id);
                    }
                });
            });

            Livewire.on("swal:confirm-close", (event) => {
                Swal.fire({
                    title: event[0].title,
                    text: event[0].text,
                    icon: 'question',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: event[0].confirmButtonText,
                    denyButtonText: event[0].denyButtonText,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.call('saveAndClose');
                    } else if (result.isDenied) {
                        @this.call('discardAndClose');
                    }
                });
            });

        });
    </script>
    @endpush
</div>