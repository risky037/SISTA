<!DOCTYPE html>
<html lang="id">

<head>
    @include('layouts.partials.seo')
    <title>Sistem Informasi Tugas Akhir | {{ config('app.name', 'SISTA') }}</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="apple-touch-icon" href="https://sia.uici.ac.id/images/uici/logo-uici-baru.png">
    <link rel="shortcut icon" type="image/x-icon" href="https://sia.uici.ac.id/images/uici/logo-uici-baru.png">
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    @stack('styles')
</head>

<body>
    <div id="linear-preloader" class="progress blue lighten-2"
        style="margin: 0; position: fixed; top: 0; left: 0; width: 100%; z-index: 9999; display: none;">
        <div class="indeterminate"></div>
    </div>
    @php
        use App\Models\User;

        $admin = User::where('role', 'admin')->whereNotNull('no_hp')->first();
        $waNumber = $admin
            ? (preg_match('/^0/', $admin->no_hp)
                ? preg_replace('/^0/', '62', $admin->no_hp)
                : $admin->no_hp)
            : null;
    @endphp
    <div class="overlay"></div>

    <!-- Pilihan Login -->
    <div id="login-choice" class="login-choice z-depth-3">
        <img src="https://sia.uici.ac.id/images/uici/logo-uici-baru.png" alt="Logo">
        <h4>Sistem Informasi Tugas Akhir</h4>
        <p>Silakan pilih jenis login untuk masuk ke dashboard Anda:</p>
        <div class="login-options">
            <a class="btn green darken-2 login-btn waves-effect waves-light" onclick="openLogin('admin')">
                <i class="material-icons">admin_panel_settings</i> Admin
            </a>
            <a class="btn blue darken-2 login-btn waves-effect waves-light" onclick="openLogin('mahasiswa')">
                <i class="material-icons">school</i> Mahasiswa
            </a>
            <a class="btn orange darken-2 login-btn waves-effect waves-light" onclick="openLogin('dosen')">
                <i class="material-icons">groups</i> Dosen
            </a>
        </div>
    </div>

    <!-- Modal Login -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <h5 id="login-title">Login</h5>
            <form id="login-form" method="POST" action="{{ route('login') }}" onsubmit="return validateLoginRole()">
                @if ($errors->any())
                    <div class="error-container" style="margin-bottom: 20px;">
                        @foreach ($errors->all() as $error)
                            <div class="error-message">
                                <i class="material-icons left tiny">error_outline</i>
                                <p>{{ $error }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @csrf
                <input type="hidden" name="role" id="login-role" value="">

                <div class="input-field">
                    <input id="email" name="email" type="text" required value="{{ old('email') }}">
                    <label for="email" id="identity-label"></label>
                </div>

                <div class="input-field">
                    <input id="password" name="password" type="password" required>
                    <label for="password">Password</label>
                </div>

                <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 10px;">
                    <a href="#" class="modal-close btn grey">Batal</a>
                    <a href="#" class="btn red" onclick="handleForgotPassword(event)">Lupa Password</a>
                    <button type="submit" class="btn green">Masuk</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script defer src="{{ asset('js/welcome.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const modals = document.querySelectorAll(".modal");
            M.Modal.init(modals);
            @if ($errors->any())
                const modal = document.getElementById("login-modal");
                const modalInstance = M.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.open()
                }
                const oldRole = "{{ old('role') }}";
                if (oldRole) {
                    const loginRoleInput = document.getElementById("login-role");
                    if (loginRoleInput) {
                        loginRoleInput.value = oldRole
                    }
                    document.getElementById("login-title").textContent = "Login " + capitalize(oldRole);
                    const identityLabel = document.getElementById("identity-label");
                    switch (oldRole) {
                        case "admin":
                            identityLabel.textContent = "Email";
                            break;
                        case "mahasiswa":
                            identityLabel.textContent = "NIM";
                            break;
                        case "dosen":
                            identityLabel.textContent = "Email atau NIDN";
                            break;
                        default:
                            identityLabel.textContent = "Email"
                    }
                }
            @endif
            const identityInput = document.getElementById("email");
            identityInput.addEventListener("focus", function() {
                const role = document.getElementById("login-role").value;
                switch (role) {
                    case "admin":
                        this.placeholder = "Masukkan Email";
                        break;
                    case "mahasiswa":
                        this.placeholder = "Masukkan NIM";
                        break;
                    case "dosen":
                        this.placeholder = "Masukkan Email atau NIDN";
                        break;
                    default:
                        this.placeholder = "Masukkan Email"
                }
            });
            identityInput.addEventListener("blur", function() {
                this.placeholder = ""
            })
        })

        function handleForgotPassword() {
            event.preventDefault();
            Swal.fire({
                title: "Lupa Password?",
                text: "Silakan hubungi admin melalui WhatsApp untuk reset password.",
                icon: "info",
                showCancelButton: !0,
                confirmButtonText: "Hubungi Admin",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    const waNumber = "{{ $waNumber ?? '' }}";
                    if (waNumber) {
                        const role = document.getElementById("login-role").value || "pengguna";
                        const message = encodeURIComponent(
                            `Halo Admin, saya seorang ${role}. Saya lupa password akun saya. Mohon bantuannya untuk reset.`
                            );
                        const waUrl = `https://wa.me/${waNumber}?text=${message}`;
                        window.open(waUrl, "_blank")
                    } else {
                        Swal.fire("Nomor Tidak Ditemukan", "Nomor WhatsApp admin belum tersedia.", "error")
                    }
                }
            })
        }
    </script>

</body>

</html>
