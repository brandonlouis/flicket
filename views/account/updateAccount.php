<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'userAdmin') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/account_contr.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/profile_contr.php";

    $amc = new AccountContr();
    $accountDetails = $amc->retrieveOneAccount($_GET['id']);

    $pc = new ProfileContr();
    $profiles = $pc->retrieveAllProfiles();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Update Account | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <h1>Account Details</h1>
            <form method="POST" action="../../includes/accMgmt_inc.php?id=<?php echo $accountDetails['id']; ?>" class="w-50">
                <div class="input-group mt-4">
                    <span class="input-group-text">
                        <i class="bi bi-person-lines-fill"></i>
                    </span>
                    <select class="form-select" id="userType" name="userType" aria-label="Default select">
                        <?php foreach ($profiles as $profile) { ?>
                            <option value="<?php echo $profile['userType']; ?>" <?php if($accountDetails['userType'] == $profile['userType']) { ?> selected <?php } ?>><?php echo $profile['userType']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name" pattern="[a-zA-Z\s]*" value="<?php echo $accountDetails['fullName']; ?>" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $accountDetails['email']; ?>" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-phone"></i>
                    </span>
                    <input type="tel" class="form-control" id="phoneNo" name="phoneNo" placeholder="Phone" pattern="(6|8|9)\d{7}" value="<?php echo $accountDetails['phoneNo']; ?>" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" class="form-control" id="password1" name="password1" placeholder="New Password (Leave blank if no changes)">
                </div>
                <div class="input-group mb-2 mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Confirm New Password (Leave blank if no changes)">
                </div>
                <div class="d-flex">
                    <button type="submit" name="updateAccount" class="btn btn-danger my-4 me-3">Update account</button>
                    <a href="manageAccounts.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/footer.php';
    ?>
</body>

</html>