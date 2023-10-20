<?php
    session_start();
    if (isset($_SESSION['email'])) { // Check if logged in
        header('Location: ../index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">

 
    <title>Register | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body>
    <div class="loginRegister vw-100 vh-100 d-flex justify-content-center align-items-center">
        <div class="loginRegisterContainer d-flex rounded-4">
            <div class="d-flex justify-content-center align-items-center" style="width:40%">
                <a href="../index.php" class="btn btn-dark position-absolute m-3" style="left:10%; top:7.5%">&#11148;&nbsp;&nbsp;Return to Website</a>
                <form method="POST" action="../controllers/register_contr.php">
                    <div class="d-flex flex-column align-items-center" style="width: 380px">
                        <img src="../img/flicket.png" width="230">
                        <h3 class="text-center mt-5">Let's Get Started!</h3>
                        <p style="font-size: 14px; color:lightgray">Create an account and enjoy various benefits</p>
            
                        <?php if (isset($_COOKIE['flash_message'])) : ?>
                        <div class="alert alert-<?php echo $_COOKIE['flash_message_type']; ?> alert-dismissible fade show my-0 w-100" role="alert">
                            <?php echo $_COOKIE['flash_message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php setcookie('flash_message', '', time() - 3600, '/'); ?>
                        <?php setcookie('flash_message_type', '', time() - 3600, '/'); ?>
                        <?php endif; ?>
            
                        <div class="input-group mt-4">
                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name" pattern="[a-zA-Z\s]*" required>
                        </div>
                        <div class="input-group mt-3" title="Email Address">
                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-group mt-3" title="Phone Number">
                            <span class="input-group-text">
                                <i class="bi bi-phone"></i>
                            </span>
                            <input type="tel" class="form-control" id="phoneNo" name="phoneNo" placeholder="Phone" pattern="(6|8|9)\d{7}" required>
                        </div>
                        <div class="input-group mt-3" title="Password">
                            <span class="input-group-text">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" class="form-control" id="password1" name="password1" placeholder="Password" required>
                        </div>
                        <div class="input-group mb-2 mt-3" title="Confirm Password">
                            <span class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm Password" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 my-4">Register an account</button>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <p style="font-size: 13px">Already have an account? <b><a href="login.php">Login</a></b></p>
                    </div>
                </form>
            </div>
            <div class="rightBanner rounded-end-4 d-flex flex-column justify-content-center align-items-center" style="width:60%">
                <img src="../img/loginRegisterBanner.png" height="70%" alt="loginRegisterBanner">
                <p class="mt-4 fs-5 text-center w-75"><b>Curtains up on convenience - Your one-stop destination for movie tickets and showtime satisfaction</b></p>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>