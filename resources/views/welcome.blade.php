<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Tugas Akhir</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="apple-touch-icon" href="https://sia.uici.ac.id/images/uici/logo-uici-baru.png">
    <link rel="shortcut icon" type="image/x-icon" href="https://sia.uici.ac.id/images/uici/logo-uici-baru.png">
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1518770660439-4636190af475') no-repeat center center fixed;
            background-size: cover;
            z-index: -1;
        }

        .login-choice {
            max-width: 900px;
            margin: 80px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .login-choice img {
            width: 100px;
            margin-bottom: 20px;
        }

        .login-choice h4 {
            font-weight: bold;
            margin-bottom: 10px;
            color: #2d3436;
        }

        .login-choice p {
            font-size: 16px;
            color: #636e72;
            margin-bottom: 30px;
        }

        .login-options {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .login-btn {
            flex: 1;
            min-width: 150px;
            padding: 15px;
            font-size: 18px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-btn i {
            font-size: 22px;
            margin-right: 8px;
        }

        /* error Message Styling */
        .error-container {
            padding: 15px;
            background-color: #ffebee;
            /* Warna merah muda */
            border: 1px solid #e57373;
            /* Garis merah */
            border-radius: 8px;
            color: #c62828;
            /* Warna teks merah */
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .error-message i {
            color: #c62828;
            font-size: 20px;
        }

        .error-message p {
            margin: 0;
            line-height: 1.4;
        }
    </style>
</head>

<body>

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
                    <input id="email" name="email" type="email" required value="{{ old('email') }}">
                    <label for="email">Email</label>
                </div>

                <div class="input-field">
                    <input id="password" name="password" type="password" required>
                    <label for="password">Password</label>
                </div>

                <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 10px;">
                    <a href="#" class="modal-close btn grey">Batal</a>
                    <a href="{{ route('password.request') }}" class="btn red">Lupa Password</a>
                    <button type="submit" class="btn green">Masuk</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modals = document.querySelectorAll('.modal');
            M.Modal.init(modals);

            @if ($errors->any())
                const modal = document.getElementById('login-modal');
                const modalInstance = M.Modal.getInstance(modal);
                if (modalInstance) {
                    modalInstance.open();
                }

                const oldRole = "{{ old('role') }}";
                if (oldRole) {
                    const loginRoleInput = document.getElementById('login-role');
                    if (loginRoleInput) {
                        loginRoleInput.value = oldRole;
                    }
                    document.getElementById('login-title').textContent = "Login " + oldRole.charAt(0)
                        .toUpperCase() + oldRole.slice(1);
                }
            @endif
        });

        let selectedRole = '';

        function openLogin(role) {
            selectedRole = role;
            document.getElementById('login-role').value = role;
            document.getElementById('login-title').textContent = "Login " + role.charAt(0).toUpperCase() + role.slice(1);
            M.Modal.getInstance(document.getElementById('login-modal')).open();
        }

        function validateLoginRole() {
            const role = document.getElementById('login-role').value;
            if (!role) {
                M.toast({
                    html: 'Silakan pilih jenis login terlebih dahulu.',
                    classes: 'red darken-2 white-text'
                });
                return false;
            }
            return true;
        }
    </script>

</body>

</html>
