<div>
    <form wire:submit.prevent="login">
        <div class="card mx-auto shadow-lg border-0" style="max-width: 420px; margin-top: 5vh;">
            <div class="card-body p-5">
                <div>
                    <div class="text-center mb-4">
                        <img src="/logo.png" alt="Logo" class="mb-3" style="max-width: 80px;">
                        <h2 class="fw-bold mb-2">Selamat Datang</h2>
                        <p class="text-muted small">Silakan masuk ke akun Anda</p>
                    </div>
                    
                    {{-- Alamat Email --}}
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold mb-2">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" class="form-control border-start-0 ps-0" placeholder="nama@email.com" wire:model="email">
                        </div>
                        @error('email')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    {{-- Kata Sandi --}}
                    <div class="form-group mb-3">
                        <label class="form-label fw-semibold mb-2">Kata Sandi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control border-start-0 ps-0" placeholder="Masukkan kata sandi" wire:model="password">
                        </div>
                        @error('password')
                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Kirim --}}
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            Masuk
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">Belum memiliki akun? <a href="{{ route('auth.register') }}" class="text-decoration-none fw-semibold">Daftar Sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <style>
        .input-group-text {
            background-color: #f8f9fa;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: transform 0.2s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .card {
            border-radius: 15px;
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>