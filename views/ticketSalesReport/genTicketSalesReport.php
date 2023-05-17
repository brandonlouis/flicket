<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaOwner') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/session/manageSession_contr.php";

    $sc = new ManageSessionContr();
    $sessions = $sc->retrieveAllSessions();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">
 
    <title>Generate Ticket Sales Report | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Generate Ticket Sales Report</h1>
            </div>
            <form method="POST" action="../../controllers/ticketSales/genTicketSales_contr.php" class="row">
                <div class="mb-3">
                    <input type="hidden" name="timeLevel" value="session">
                    <label for="sessionID">Session:</label>
                    <select class="form-select" name="sessionID" aria-label="Session for report:">             
                        <?php foreach($sessions as $s){ ?>
                            <option value="<?php echo $s['id'] ?>">
                                <?php echo "sessionID: " . $s['id'] . " (movieID: " . $s['movieId'] . ", Time: " . $s['startTime'] . "-" . $s['startTime'] . ")";?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:25%">Generate Session Report</button>
            </form>

            <form method="POST" action="../../controllers/ticketSales/genTicketSales_contr.php" class="row">
                <div class="mb-3">
                    <input type="hidden" name="timeLevel" value="day">
                    <label for="dayDate">Day:</label>
                    <input type="date" class="form-control" id="dayDate" name="dayDate" placeholder="Day">  
                </div>
                <button type="submit" class="btn btn-primary" style="width:25%">Generate Daily Report</button>
            </form>

            <form method="POST" action="../../controllers/ticketSales/genTicketSales_contr.php" class="row">
                <div class="mb-3">
                    <input type="hidden" name="timeLevel" value="week">
                    <label for="weekDate">Week:</label>
                    <input type="date" class="form-control" id="weekDate" name="weekDate" placeholder="Starting Day of Week">  
                </div>
                <button type="submit" class="btn btn-primary" style="width:25%">Generate Weekly Report</button>
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