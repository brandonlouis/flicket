<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/cinemahall/manageCinemaHall_contr.php";

    $mch = new ManageCinemaHallContr();
    $cinemaHallDetails = $mch->retrieveOneCinemaHall($_GET['cinemaHallId']);
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Update Cinema Hall | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../controllers/cinemahall/updateCinemaHall_contr.php?movieId=<?php echo $cinemaHallDetails['id']; ?>" class="w-50">
                <h1>Cinema Hall Details</h1>
                <div class="input-group mt-4" title="Cinema Name">
                    <span class="input-group-text">
                        <i class="bi bi-house"></i>
                    </span>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo $cinemaHallDetails['name']; ?>" required>
                </div>
                <div class="input-group mt-3" title="Hall Number">
                    <span class="input-group-text">
                        <i class="bi bi-projector"></i>
                    </span>
                    <select class="form-select" id="hallNumber" name="hallNumber">
                        <option value ="<?php echo $cinemaHallDetails['name']; ?>" disabled selected hidden>Hall <?php echo $cinemaHallDetails['hallNumber']; ?></option>
                        <option value ="1">Hall 1</option>
                        <option value ="2">Hall 2</option>
                        <option value ="3">Hall 3</option>
                        <option value ="4">Hall 4</option>
                        <option value ="5">Hall 5</option>
                    </select>
                </div>
                <div class="input-group mt-3" title="Address">
                    <span class="input-group-text">
                        <i class="bi bi-building"></i>
                    </span>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Address" id="address" name="address" style="height: 100px" required><?php echo $cinemaHallDetails['address']; ?></textarea>
                        <label class="text-secondary" for="address">Address</label>
                    </div>
                </div>
                <div class="input-group mt-4" title="Capacity">
                    <span class="input-group-text">
                        <i class="bi bi-people"></i>
                    </span>
                    <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Capacity" value="<?php echo $cinemaHallDetails['capacity']; ?>" required>
                </div>
                <div class="d-flex">
                    <button type="submit" name="updateCinemaHall" class="btn btn-danger my-4 me-3">Update cinema hall</button>
                    <a href="manageCinemaHalls.php" class="btn btn-outline-info my-4">Cancel</a>
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