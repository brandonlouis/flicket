<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/movie/manageMovie_contr.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/session/manageSession_contr.php";

    $mmc = new ManageMovieContr();
    $movieDetails = $mmc->retrieveOneMovie($_GET['movieId']);

    $sc = new ManageSessionContr();
    $sessions = $sc->retrieveAllSessions($_GET['movieId']);
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Book Movie | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../controllers/bookmovie/createMovieBooking_contr.php?movieId=<?php echo $movieDetails['id']; ?>" enctype="multipart/form-data" class="w-50">
                <h1>Book: <?php echo $movieDetails['title']?></h1>
                <p>Synopsis: <?php echo $movieDetails['synopsis']?></p>
                <p>Runtime: <?php echo $movieDetails['runtimeMin']?> mins</p>
                <div class="input-group mt-4" title="Full Name">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name" required>
                </div>
                <div class="input-group mt-4" title="Email">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="text" class="form-control" id="email" name="email" placeholder="E-mail" value="<?php echo $_SESSION['email']?>" required>
                </div>
                <div class="input-group mt-3" title="Session">
                    <span class="input-group-text">
                        <i class="bi bi-film"></i>
                    </span>
                    <select class="form-select" id="sessionId" name="sessionId" aria-label="Default select">
                        <?php foreach ($sessions as $session) { 
                            if ($session['movieId'] == $movieDetails['id']) { ?>
                                <option value="<?php echo $session['id']; ?>" ><?php echo $session['startTime']; ?> - <?php echo $session['endTime'];?></option>
                        <?php } else {
                                continue;
                            }
                        } ?>
                    </select>
                </div>
                <div class="input-group mt-4" title="Email">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" min="1" value="1" required>
                </div>

                <div class="d-flex">
                    <button type="submit" name="createMovieBooking" class="btn btn-danger my-4 me-3">Book movie</button>
                    <a href="../movies.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
            </form>
            <div style="width:45%" class="d-flex justify-content-end">
                <?php echo '<img id="posterImg" style="width:auto;height:700px;;max-width:-webkit-fill-available" src="data:image/png;base64,' . $movieDetails['poster'] . '" alt="Movie Poster" />'; ?>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/footer.php';
    ?>


<script>
</script>
</body>

</html>