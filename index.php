<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/movie/manageMovie_contr.php";

    $mc = new ManageMovieContr();
    $movies = $mc->retrieveAllAvailableMovies();
    $random_number = rand(0,count($movies)-1);
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">

 
    <title>Home | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex align-items-center" style="max-height:700px;overflow:hidden;">
                <div class="" style="width:40%">
                    <p style="color:white;font-size:15px;width: fit-content;padding: 2px 10px;background-color: #d74545;border-radius: 15px;"><?php echo $movies[$random_number]['genres']; ?></p>
                    <h1><?php echo $movies[$random_number]['title']; ?></h1>
                    <p><?php echo $movies[$random_number]['synopsis']; ?></p>
                    <div class="mt-5">
                        <a href="#" type="button" class="btn btn-danger">Book Now</a>
                        <a href="#" type="button" class="ms-4 btn btn-outline-light">See Details</a>
                    </div>
                </div>
                <div class="d-flex justify-content-end" style="width:60%">
                    <img src="data:image/png;base64,<?php echo $movies[$random_number]['poster']; ?>" style="height:700px;width:auto;" alt="<?php echo $movies[$random_number]['title'] ?>">
                    <img src="data:image/png;base64,<?php echo $movies[$random_number]['poster']; ?>" style="height: 1200px;width:auto;position:absolute;z-index:-1;opacity:0.2;clip-path:inset(0 0 50% 0);left:25rem;right:0;margin-left:auto;margin-right:auto;top:12rem;" alt="<?php echo $movies[$random_number]['title'] ?>">
                </div>
            </div>

            <?php 
                $mv = array();
                $movie_count = count($movies);
                $num_movies = min(4, $movie_count);
                for ($i = 0; $i < $num_movies; $i++) {
                    do {
                        $random_number = rand(0, $movie_count-1);
                        $random_movie = $movies[$random_number];
                    } while (in_array($random_movie, $mv));
                    $mv[] = $random_movie;
                }  
            ?>
            <h2 style="margin-top: 100px;">Now Showing</h2>
            <hr>
            <div class="mt-5 align-items-center" style="display:grid; grid-template-columns: repeat(4, 1fr); justify-items:center;">
                <?php foreach ($mv as $movie) { ?>
                    <a href="#" class="text-decoration-none border-0 mb-5" style="width: 17rem;">
                        <img src="data:image/png;base64,<?php echo $movie['poster']; ?>" class="card-img-top mb-3" style="height:400px; object-fit:cover;" alt="<?php echo $movie['title'] ?>">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-white mb-2"><?php echo $movie['title'] ?></h5>
                            <div class="d-flex justify-content-between">
                                <p class="card-text text-white" style="font-size:12px;width: fit-content;padding: 2px 10px;background-color: #d74545;border-radius: 15px;"><?php echo $movie['genres'] ?></p>
                                <p class="card-text text-white-50" style="font-size:12px;"><?php echo $movie['runtimeMin'] ?> minutes</p>
                            </div>
                        </div>
                    </a>
                <?php } ?>
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