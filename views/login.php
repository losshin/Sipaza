<?php
require "../database/controller.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>SiPaZa</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/login.css" />

</head>

<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="../assets/img/undraw/undraw_Hello_qnas.svg" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form action="../database/controller.php" method="post">
                        <h2 class="text-right fw-bold mb-3">Selamat Datang di SiPaZa</h2>
                        <!-- Username input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control form-control-lg"
                                placeholder="Enter a valid username" required />
                        </div>
                        
                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg"
                                placeholder="Enter password" required />
                        </div>
                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg"
                                name="action" value="login" style="padding-left: 2.5rem; padding-right: 2.5rem;">
                                Login
                            </button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account?
                                <a href="register.php" class="link-danger">Register</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>