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
    </style>

    {{-- Header Card --}}
    <div class="card border-0 shadow-lg mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between text-white">
                <div>
                    <h3 class="mb-1 fw-bold">Hai, {{ $auth->name }}! 👋</h3>
                    <p class="mb-0 opacity-75">Selamat datang kembali di dashboard Anda</p>
                </div>
                <a href="{{ route('auth.logout') }}" class="btn btn-light fw-semibold px-4">
                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                </a>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="d-flex align-items-center text-white">
                        <div class="flex-grow-1">
                            <p class="mb-2 opacity-75 small">Total Pemasukan</p>
                            <h2 class="mb-0 fw-bold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h2>
                        </div>
                        <div class="ms-3">
                            <i class="bi bi-arrow-up-circle-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);">
                    <div class="d-flex align-items-center text-white">
                        <div class="flex-grow-1">
                            <p class="mb-2 opacity-75 small">Total Pengeluaran</p>
                            <h2 class="mb-0 fw-bold">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h2>
                        </div>
                        <div class="ms-3">
                            <i class="bi bi-arrow-down-circle-fill" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; overflow: hidden;">
                <div class="card-body p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex align-items-center text-white">
                        <div class="flex-grow-1">
                            <p class="mb-2 opacity-75 small">Sisa Uang</p>
                            <h2 class="mb-0 fw-bold">Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}</h2>
                        </div>
                        <div class="ms-3">
                            <i class="bi bi-wallet2" style="font-size: 3rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Card --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
        <div class="card-body p-4">
            <h5 class="card-title fw-bold mb-3">Statistik 30 Hari Terakhir</h5>
            <div id="chart" wire:ignore></div>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-body p-4">
            {{-- Search and Add Button --}}
            <div class="mb-4 d-flex flex-column flex-md-row gap-3">
                <div class="input-group flex-grow-1">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0" placeholder="Cari transaksi..." wire:model.live="search">
                </div>
                <button class="btn btn-primary fw-semibold px-4" wire:click="openModal" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; white-space: nowrap;">
                    <i class="bi bi-plus-circle me-2"></i>Tambah
                </button>
            </div>

            {{-- Filter Buttons --}}
            <div class="mb-4 d-flex justify-content-center">
                <div class="btn-group shadow-sm" role="group" aria-label="Filter Transaksi">
                    <button type="button" class="btn {{ $filterType == 'all' ? 'btn-primary' : 'btn-outline-primary' }} fw-semibold px-4" wire:click="$set('filterType', 'all')">
                        <i class="bi bi-list-ul me-2"></i>Semua
                    </button>
                    <button type="button" class="btn {{ $filterType == 'income' ? 'btn-success' : 'btn-outline-success' }} fw-semibold px-4" wire:click="$set('filterType', 'income')">
                        <i class="bi bi-arrow-up-circle me-2"></i>Pemasukan
                    </button>
                    <button type="button" class="btn {{ $filterType == 'expense' ? 'btn-danger' : 'btn-outline-danger' }} fw-semibold px-4" wire:click="$set('filterType', 'expense')">
                        <i class="bi bi-arrow-down-circle me-2"></i>Pengeluaran
                    </button>
                </div>
            </div>

            {{-- Data Table --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">No</th>
                            <th class="fw-semibold">Judul</th>
                            <th class="fw-semibold">Jenis</th>
                            <th class="fw-semibold">Nominal</th>
                            <th class="fw-semibold">Tanggal</th>
                            <th class="fw-semibold">Bukti</th>
                            <th class="fw-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cashflows as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $item->title }}</td>
                            <td>
                                @if($item->type == 'income')
                                    <span class="badge rounded-pill" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); padding: 6px 12px;">
                                        <i class="bi bi-arrow-up-circle me-1"></i>Pemasukan
                                    </span>
                                @else
                                    <span class="badge rounded-pill" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); padding: 6px 12px;">
                                        <i class="bi bi-arrow-down-circle me-1"></i>Pengeluaran
                                    </span>
                                @endif
                            </td>
                            <td class="fw-semibold">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                            <td class="text-muted">{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                @if($item->receipt)
                                    <a href="{{ Storage::url($item->receipt) }}" target="_blank">
                                        <img src="{{ Storage::url($item->receipt) }}" 
                                             alt="Receipt" 
                                             class="rounded shadow-sm"
                                             style="height: 50px; width: 50px; object-fit: cover;">
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" wire:click="edit({{ $item->id }})">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Ubah</span>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1" wire:click="confirmDelete({{ $item->id }})">
                                        <i class="bi bi-trash3-fill"></i>
                                        <span>Hapus</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $cashflows->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div class="modal @if($showModal) show @endif" 
         style="display: @if($showModal) block @else none @endif;"
         tabindex="-1"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">
                        <i class="bi {{ $editingId ? 'bi-pencil-square' : 'bi-plus-circle' }} me-2"></i>
                        {{ $editingId ? 'Edit Transaksi' : 'Tambah Transaksi' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body px-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Judul</label>
                            <input type="text" class="form-control" wire:model="title" placeholder="Contoh: Gaji Bulanan" required>
                            @error('title') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jenis</label>
                            <select class="form-select" wire:model="type" required>
                                <option value="income">💰 Pemasukan</option>
                                <option value="expense">💸 Pengeluaran</option>
                            </select>
                            @error('type') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nominal</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="number" class="form-control" wire:model="amount" placeholder="0" required>
                            </div>
                            @error('amount') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Deskripsi</label>
                            {{-- Solusi: Tambahkan wire:ignore agar Livewire tidak me-render ulang Trix --}}
                            <div wire:ignore>
                                <input id="description" type="hidden" name="description" value="{{ $description }}">
                                <trix-editor 
                                    input="description"
                                    class="form-control trix-content"
                                    placeholder="Tambahkan catatan (opsional)"
                                ></trix-editor>
                            </div>
                            @error('description') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bukti Transaksi</label>
                            <input type="file" class="form-control" wire:model="receipt" accept="image/*">
                            <div wire:loading wire:target="receipt" class="text-primary small mt-2">
                                <i class="bi bi-arrow-repeat spinner-border spinner-border-sm me-1"></i>
                                Uploading...
                            </div>
                            @error('receipt') <span class="text-danger small mt-1 d-block">{{ $message }}</span> @enderror

                            @if ($receipt)
                                <img src="{{ $receipt->temporaryUrl() }}" 
                                     class="img-thumbnail mt-3 rounded shadow-sm" 
                                     style="max-height: 200px">
                            @elseif ($currentReceipt)
                                <img src="{{ Storage::url($currentReceipt) }}" 
                                     class="img-thumbnail mt-3 rounded shadow-sm" 
                                     style="max-height: 200px">
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light fw-semibold px-4" wire:click="closeModal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-semibold px-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="bi {{ $editingId ? 'bi-check-circle' : 'bi-save' }} me-2"></i>
                            {{ $editingId ? 'Update' : 'Simpan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" style="display: @if($showModal) block @else none @endif;"></div>

    {{-- Scripts --}}
    @push('scripts')
    <script>
        document.addEventListener("livewire:initialized", () => {
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

            // Generate demo data if no data exists
            if (!initialIncome.length && !initialExpense.length) {
                const demoData = generateDemoData();
                initialIncome = demoData.income;
                initialExpense = demoData.expense;
            }

            // 2. Sebelum render chart baru, hancurkan yang lama
            if (window.cashflowChart) {
                window.cashflowChart.destroy();
                window.cashflowChart = null;
            }

            const options = {
                series: [
                    { name: 'Pemasukan', data: initialIncome },
                    { name: 'Pengeluaran', data: initialExpense }
                ],
                chart: {
                    height: 350,
                    type: 'area',
                    foreColor: "#999",
                    stacked: true,
                    dropShadow: {
                        enabled: true,
                        enabledSeries: [0],
                        top: -2,
                        left: 2,
                        blur: 5,
                        opacity: 0.06
                    },
                    toolbar: { show: true }
                },
                colors: ['#00E396', '#0090FF'],
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                dataLabels: {
                    enabled: false
                },
                markers: {
                    size: 0,
                    strokeColor: "#fff",
                    strokeWidth: 3,
                    strokeOpacity: 1,
                    fillOpacity: 1,
                    hover: { size: 6 }
                },
                xaxis: {
                    type: 'datetime',
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    min: 0,
                    forceNiceScale: true,
                    labels: {
                        formatter: function(value) {
                            return "Rp " + value.toLocaleString('id-ID');
                        },
                        offsetX: -10
                    }
                },
                grid: {
                    padding: { left: 5, right: 5 }
                },
                tooltip: {
                    x: { format: 'dd MMM yyyy' }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left'
                },
                fill: {
                    type: 'solid',
                    fillOpacity: 0.7
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

            // --- Trix Editor Listeners ---
            const trixEditor = document.querySelector("trix-editor");

            if (trixEditor) {
                // When server asks to reset content
                Livewire.on('reset-trix', () => {
                    if (trixEditor.editor) {
                        trixEditor.editor.loadHTML('');
                    }
                });

                // Support Livewire-style events (array/object) as well as browser CustomEvent from dispatchBrowserEvent
                Livewire.on('set-trix-content', (event) => {
                    const content = (event && (event.content || (event[0] && event[0].content))) || '';
                    if (trixEditor && trixEditor.editor) {
                        trixEditor.editor.loadHTML(content);
                    }
                });

                // Emit changes from Trix back to Livewire
                trixEditor.addEventListener('trix-change', (e) => {
                    try {
                        // @this.set lebih langsung daripada Livewire.emit untuk update properti
                        @this.set('description', e.target.value);
                    } catch (err) {
                        console.error('Error updating Trix content:', err);
                    }
                });
            }

        });
    </script>
    @endpush

    <style>
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
    </style>
</div>