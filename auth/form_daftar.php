<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Service Gadget</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../bootstrap-icons/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .form-daftar {
            max-width: 420px;
            margin: auto;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .password-mismatch {
            color: red;
            font-size: 0.875em;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <form class="form-daftar" action="proses_daftar.php" method="post" onsubmit="return validateForm()">
            <div class="text-center mb-4">
                <img src="../img/menu_logo.png" alt="Logo" width="70">
                <h2 class="mt-3">Buat Akun Admin</h2>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="id" class="form-control" id="id" placeholder="ID Karyawan" 
                       pattern="(ID)\d{3}" title="Format ID: ID001 untuk Admin" required>
                <label for="id">ID Admin (Format: ID001)</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" name="username" class="form-control" id="username" placeholder="Username" required>
                <label for="username">Username</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="nama@email.com" required>
                <label for="email">Email</label>
            </div>

            <div class="form-floating mb-3">
                <select name="posisi" class="form-select" id="posisi" required>
                    <option value="">Pilih Posisi</option>
                    <option value="admin">Admin</option>
                </select>
                <label for="posisi">Posisi</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Konfirmasi Password" required>
                <label for="confirm_password">Konfirmasi Password</label>
                <div id="password-mismatch" class="password-mismatch">Password tidak cocok!</div>
            </div>

            <button class="w-100 btn btn-lg btn-success" type="submit">
                <i class="bi bi-person-plus-fill me-2"></i>Daftar Sekarang
            </button>

            <p class="mt-3 text-center">
                Sudah punya akun? <a href="form_login.php">Login di sini</a>
            </p>

            <p class="mt-3 me-2 text-center">Kembali Ke Halaman Awal<a href="../index.php" class="ms-2">Halaman Awal</a></p>
        </form>
    </div>

    <script>
        function validateForm() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;
            const mismatchDiv = document.getElementById('password-mismatch');
            
            if (password !== confirmPassword) {
                mismatchDiv.style.display = 'block';
                return false;
            }
            return true;
        }

        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const mismatchDiv = document.getElementById('password-mismatch');
            
            if (password !== confirmPassword) {
                mismatchDiv.style.display = 'block';
            } else {
                mismatchDiv.style.display = 'none';
            }
        });

        document.getElementById('posisi').addEventListener('change', function() {
            const idInput = document.getElementById('id');
            if (this.value === 'admin') {
                idInput.pattern = "ID\\d{3}";
                idInput.title = "Format ID Admin: ID001, ID002, dst";
            } else if (this.value === 'teknisi') {
                idInput.pattern = "TK\\d{3}";
                idInput.title = "Format ID Teknisi: TK001, TK002, dst";
            }
        });
    </script>
</body>
</html>
