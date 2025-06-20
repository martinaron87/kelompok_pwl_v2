<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.min.css">
    <!-- akhir bootstrap -->

    <!-- own css -->
    <link rel="stylesheet" href="styles.css">

    <title>Service Gadget</title>
</head>

<body class="pt-4">
    <!-- navbar -->
    <nav class="navbar fixed-top bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="img/menu_logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                Service Gadget
            </a>

            <form class="d-flex justify-content-end">
                <a href="auth/form_login.php" class="btn btn-outline-success me-2" type="button">Masuk</>
                <a href="auth/form_daftar.php" class="btn btn-sm btn-outline-secondary" type="button">Buat Akun</>
            </form>
        </div>
    </nav>
    <!-- akhir navbar -->

    <!-- jumbotron -->
    <div class="container-fluid mt-5">
        <div class="container justify-content-center text-center">
            <h1 class="display-3">
                Selamat datang,
                <small class="text-body-secondary">silahkan masuk ke menu utama untuk mengelola data service
                    gadget</small>
            </h1>
        </div>

        <div class="container justify-content-center mt-4">
            <img src="img/menu_logo.png" class="img-thumbnail mx-auto d-block" alt="Service Gadget Logo">
        </div>

        <div class="container justify-content-center text-center mt-4">
            <h1 class="display-6">
                Gadget House
            </h1>

            <p class="lead">
                Jl. Raya Tengah No. 80, RT.6/RW.1, Gedong, Kec. Pasar Rebo, Jakarta Timur, DKI Jakarta 13760
            </p>
        </div>
    </div>
    <!-- akhir jumbotron -->

    <!-- footer -->
    <footer class="lead text-center mt-4" style="background-color: #efefef;">
        <p class="py-3">Build With <i class="bi bi-heart-fill text-danger"></i> 2025 Kelompok 1</p>
    </footer>
    <!-- akhir footer -->
</body>

</html>