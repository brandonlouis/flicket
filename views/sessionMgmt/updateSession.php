<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/session_contr.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/movie_contr.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/seat_contr.php"; // TEMPORARY TO CHANGE TO CINEMAHALL CONTR

    $sc = new SessionContr();
    $mc = new MovieContr();
    $sec = new SeatContr(); // TEMPORARY TO CHANGE TO CINEMAHALL CONTR
    $sessionDetails = $sc->retrieveOneSession($_GET['sessionId']);
    $movies = $mc->retrieveAllMovies();
    $halls = $sec->retrieveAllHalls(); // TEMPORARY TO CHANGE TO CINEMAHALL CONTR
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Update Session | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../controllers/session_contr.php?sessionId=<?php echo $sessionDetails['id'] ?>" class="w-50">
                <h1>Session Details</h1>
                <div class="input-group mt-3" title="Movie Title">
                    <span class="input-group-text">
                        <i class="bi bi-film"></i>
                    </span>
                    <select class="form-select" id="movieId" name="movieId" aria-label="Default select">
                        <?php foreach ($movies as $movie) { ?>
                            <option value="<?php echo $movie['id']; ?>" <?php if($movie['id'] == $sessionDetails['movieId']) { ?> selected <?php } ?>><?php echo $movie['title']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group mt-3"  title="Venue">
                    <span class="input-group-text">
                        <i class="bi bi-geo-alt"></i>
                    </span>
                    <select class="form-select" id="hallId" name="hallId" aria-label="Default select">
                        <?php foreach ($halls as $hall) { ?>
                            <option value="<?php echo $hall['id'] ?>" <?php if($hall['id'] == $sessionDetails['hallId']) { ?> selected <?php } ?>><?php echo $hall['name'] . ', Hall ' . $hall['hallNumber']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <div class="form-floating">
                        <input type="date" class="form-control" id="date" name="date" placeholder="Date" min="<?php echo $movie['startDate']; ?>" max="<?php echo $movie['endDate']; ?>" value="<?php echo $sessionDetails['date']; ?>" required>
                        <label class="text-secondary" for="date">Date</label>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-clock"></i>
                    </span>
                    <div class="form-floating">
                        <input type="time" class="form-control" id="startTime" name="startTime" placeholder="Start Time" value="<?php echo $sessionDetails['startTime']; ?>" step="900" required>
                        <label class="text-secondary" for="startTime">Start Time</label>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-clock-fill"></i>
                    </span>
                    <div class="form-floating">
                        <input type="time" class="form-control" id="endTime" name="endTime" placeholder="End Time" value="<?php echo $sessionDetails['endTime']; ?>" step="900" required>
                        <label class="text-secondary" for="endTime">End Time</label>
                    </div>
                </div>

                <div class="d-flex">
                    <button type="submit" name="updateSession" class="btn btn-danger my-4 me-3">Update session</button>
                    <a href="manageSessions.php" class="btn btn-outline-info my-4">Cancel</a>
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