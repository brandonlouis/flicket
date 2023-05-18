<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaOwner') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>View Utility Report | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <?php if($_SESSION['timeLevel'] == 'Session'){ ?>
                    <h1>Cinema Utilization Report for <?php echo $_SESSION['timeLevel']; ?>: <?php echo $_SESSION['sessionID']; ?></h1>
                <?php } ?>
                <?php if($_SESSION['timeLevel'] == 'Day') { ?>
                    <h1>Cinema Utilization Report for <?php echo $_SESSION['timeLevel']; ?>: <?php echo $_SESSION['dayDate']; ?></h1>
                <?php } ?>
                <?php if($_SESSION['timeLevel'] == 'Week'){ ?>
                    <h1>Cinema Utilization Report for <?php echo $_SESSION['timeLevel']; ?>: <?php echo $_SESSION['startDate'];?> to <?php echo $_SESSION['endDate'];?></h1>
                <?php } ?>
            </div>
            <table class="table table-hover text-white mt-4">
                <thead>
                    <tr>
                        <th>Session ID</th>
                        <th>Capacity</th>
                        <th>Seats Occupied</th>
                        <th>Utilization Rate</th>
                    <tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($_SESSION['cinemaUtil'] as $cinemaUtil) { ?>
                    <tr>
                        <td><?php echo $cinemaUtil['id']; ?></td>
                        <td><?php echo $cinemaUtil['capacity']; ?></td>
                        <td><?php echo $cinemaUtil['COUNT(*)']; ?></td>
                        <td><?php $utilRate = $cinemaUtil['COUNT(*)'] / $cinemaUtil['capacity'] * 100;
                            echo round($utilRate,2) . "%"; ?></td>
                    </tr>
                    <?php } ?>
                    <?php if($_SESSION['timeLevel'] == 'Day' || $_SESSION['timeLevel'] == 'Week'){ ?>
                        <tr>
                            <td>Total</td>
                            <td>
                            <?php 
                            $totalCapacity = 0;
                            foreach($_SESSION['cinemaUtil'] as $cinemaUtil) {
                                $totalCapacity = $totalCapacity + $cinemaUtil['capacity'];
                             }
                            echo $totalCapacity;
                            ?>
                            </td>

                            <td>
                            <?php 
                            $totalSeatsOccupied = 0;
                            foreach($_SESSION['cinemaUtil'] as $cinemaUtil) {
                                $totalSeatsOccupied = $totalSeatsOccupied + $cinemaUtil['COUNT(*)'];
                             }
                            echo $totalSeatsOccupied;
                            ?>
                            </td>

                            <td>
                            <?php 
                            $totalCapacity = 0;
                            $totalSeatsOccupied = 0;
                            foreach($_SESSION['cinemaUtil'] as $cinemaUtil) {
                                $totalCapacity = $totalCapacity + $cinemaUtil['capacity'];
                                $totalSeatsOccupied = $totalSeatsOccupied + $cinemaUtil['COUNT(*)'];
                             }
                            if ($totalCapacity == 0) { 
                                echo "0";
                            }
                            else { 
                                $totalUtilRate = $totalSeatsOccupied / $totalCapacity * 100;
                                echo round($totalUtilRate,2) . "%";
                            }
                            ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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