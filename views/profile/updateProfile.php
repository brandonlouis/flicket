<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'userAdmin') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include "../../classes/dbh_classes.php";
    include "../../controllers/profile_contr.php";

    $pc = new ProfileContr();
    $pc->retrieveAProfile($_GET['userType']);
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Update Profile | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include("../../templates/header.php");
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <h1>Profile Details</h1>
            <form method="POST" action="../../includes/profileMgmt_inc.php?userType=<?php echo $_SESSION['profileDetails']['userType']; ?>" class="w-50">
            <div class="input-group mt-4">
                    <span class="input-group-text">
                        <i class="bi bi-person-lines-fill"></i>
                    </span>
                    <input type="text" class="form-control" id="userType" name="userType" placeholder="User Type" value="<?php echo $_SESSION['profileDetails']['userType']; ?>" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-card-text"></i>
                    </span>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $_SESSION['profileDetails']['description']; ?>" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-person-lock"></i>
                    </span>
                    <select class="form-select" id="accessType" name="accessType" aria-label="Default select">
                        <option value="internal" <?php if($_SESSION['profileDetails']['accessType'] == 'internal') { ?> selected <?php } ?>>internal</option>
                        <option value="external" <?php if($_SESSION['profileDetails']['accessType'] == 'external') { ?> selected <?php } ?>>external</option>
                    </select>
                </div>
                <div class="d-flex">
                    <button type="submit" name="updateProfile" class="btn btn-danger my-4 me-3">Update profile</button>
                    <a href="manageProfiles.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <?php
        include("../../templates/footer.php");
    ?>
</body>

</html>