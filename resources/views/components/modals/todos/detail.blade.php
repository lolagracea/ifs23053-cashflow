
<div class="modal @if($showDetailModal) show @endif" 
     style="display: @if($showDetailModal) block @else none @endif;"
     tabindex="-1"
     role="dialog"
     aria-labelledby="detailModalLabel" 
     aria-hidden="{{ $showDetailModal ? 'false' : 'true' }}">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            @if ($selectedCashflow)
                <div class="modal-header text-white border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title fw-bold" id="detailModalLabel">
                        <i class="bi bi-file-text-fill me-2"></i>
                        Detail Transaksi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" wire:click="closeDetailModal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-4 text-center">
                        <h2 class="fw-bold mb-1">{{ $selectedCashflow->title }}</h2>
                        <p class="text-muted mb-2"><i class="bi bi-calendar3 me-2"></i>{{ $selectedCashflow->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-6 border-end">
                                    <p class="mb-1 text-muted small">Jenis Transaksi</p>
                                    @if($selectedCashflow->type == 'income')
                                        <span class="badge fs-6 rounded-pill" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); padding: 6px 12px;">
                                            <i class="bi bi-arrow-up-circle me-1"></i>Pemasukan
                                        </span>
                                    @else
                                        <span class="badge fs-6 rounded-pill" style="background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%); padding: 6px 12px;">
                                            <i class="bi bi-arrow-down-circle me-1"></i>Pengeluaran
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                    <p class="mb-1 text-muted small">Nominal</p>
                                    <h4 class="fw-bold m-0">Rp {{ number_format($selectedCashflow->amount, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($selectedCashflow->description)
                        <div class="mb-4">
                            <p class="mb-2 fw-semibold">Deskripsi</p>
                            <div class="p-3 bg-light rounded trix-content border">{!! $selectedCashflow->description !!}</div>
                        </div>
                    @endif

                    @if ($selectedCashflow->receipt)
                        <div class="mb-3">
                            <p class="mb-2 fw-semibold">Bukti Transaksi</p>
                            <a href="{{ Storage::url($selectedCashflow->receipt) }}" target="_blank">
                                <img src="{{ Storage::url($selectedCashflow->receipt) }}" alt="Bukti Transaksi" class="img-fluid rounded shadow-sm" style="max-height: 400px; display: block; margin: auto;">
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
<div class="modal-backdrop fade show" style="display: @if($showDetailModal) block @else none @endif;"></div>
