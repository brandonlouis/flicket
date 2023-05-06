<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/movie_contr.php";

    $mc = new MovieContr();
    $movieDetails = $mc->retrieveOneMovie($_GET['movieId']);
    $languages = $mc->retrieveAllLanguages();
    $genres = $mc->retrieveAllGenres();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>View Movie Session | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

        <div class="container">
            <div class="row">
                <div class="col">
                <dl class="row">
                    <dt class="col-sm-3">Title</dt>
                    <dd class="col-sm-9 mb-5"><?php echo $movieDetails['title']; ?></dd>

                    <dt class="col-sm-3">Synopsis</dt>
                    <dd class="col-sm-9 mb-5">
                        <p><?php echo $movieDetails['synopsis']; ?></p>
                    </dd>

                    <dt class="col-sm-3">Runtime (Minutes)</dt>
                    <dd class="col-sm-9 mb-5"><?php echo $movieDetails['runtimeMin']; ?></dd>

                    <dt class="col-sm-3">Start Date</dt>
                    <dd class="col-sm-9 mb-5"><?php echo $movieDetails['startDate']; ?></dd>

                    <dt class="col-sm-3">End Date</dt>
                    <dd class="col-sm-9 mb-5"><?php echo $movieDetails['endDate']; ?></dd>

                    <dt class="col-sm-3">Language</dt>
                    <dd class="col-sm-9 mb-5"><?php echo $movieDetails['language']; ?></dd>

                    <dt class="col-sm-3">Genres</dt>
                    <dd class="col-sm-9 mb-5">
                        <?php echo $movieDetails['genres']; ?>
                    </dd>

                    <dt class="col-sm-3">Trailer URL</dt>
                    <dd class="col-sm-9">
                        <a href="<?php echo $movieDetails['trailerURL']; ?>">
                            <?php echo $movieDetails['trailerURL']; ?>
                        </a>
                    </dd>
                    <dt class="col-sm-3">Trailer Video</dt>
                    <dd class="col-sm-9">
                        <iframe width="560" height="315"
                        src="<?php echo $movieDetails['trailerURL']; ?>">
                        </iframe>
                    </dd>
                </div>
                <div class="col">
                    <div class=" d-flex justify-content-center">
                        <?php
                        $posterImg = '<img id="posterImg" style="width:45%" src="data:image/png;base64,' . $movieDetails['poster'] . '" alt="Movie Poster" />';
                        echo $posterImg;?>
                    </div>
                
                </div>
            </div>
        </div>
            

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