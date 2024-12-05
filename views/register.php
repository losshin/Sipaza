<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPaZa</title>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/plugins.min.css" />
    <link rel="stylesheet" href="../assets/css/register.css" />
</head>

<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <p class="text-center h2 fw-bold mb-4 mx-md-4">Register</p>
                    <form action="../database/controller.php" method="post">

                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required />
                        </div>

                        <div data-mdb-input-init class="form-outline mb-2">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required />
                        </div>

                        <div data-mdb-input-init class="form-outline mb-3">
                            <label class="form-label" for="confirmPassword">Repeat your password</label>
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" placeholder="Repeat your username" required />
                        </div>                    

                        <button type="submit" class="btn btn-primary btn-lg justify-content-right mb-lg-2" name="action" value="addUser">Register</button>

                        <p class="small fw-bold">Have an account?
                            <a href="login.php" class="link-danger">Login</a>
                        </p>
                    </form>
                </div>
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="../assets//img/undraw/undraw_creative_team_r90h.svg"
                        class="img-fluid" alt="Sample image">
                </div>
            </div>
        </div>
    </section>
</body>

</html>