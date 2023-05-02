<?php
    session_start();

    include "../classes/dbh_classes.php";
    include "../controllers/movie_contr.php";

    $mc = new MovieContr();
    $mc->retrieveMovies();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">

 
    <title>Movies | flicket</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include("../templates/header.php");
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <span>
                <h1>Movies</h1>
                <p style="margin:0">Discover new movies, book your seats, and enjoy the show</p>
            </span>
            <form method="POST" action="../../includes/movieMgmt_inc.php" class="d-flex">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchText" name="searchText" placeholder="Search...">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Filter by</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item" type="submit" name="filter" value="None"></button></li>
                        <li><button class="dropdown-item" type="submit" name="filter" value="id">Movie ID</button></li>
                        <li><button class="dropdown-item" type="submit" name="filter" value="title">Title</button></li>
                        <li><button class="dropdown-item" type="submit" name="filter" value="synopsis">Synopsis</button></li>
                        <li><button class="dropdown-item" type="submit" name="filter" value="runtimeMin">Runtime (Minutes)</button></li>
                        <li><button class="dropdown-item" type="submit" name="filter" value="startDate">Start Date</button></li>
                        <li><button class="dropdown-item" type="submit" name="filter" value="endDate">End Date</button></li>
                        <li><button class="dropdown-item" type="submit" name="filter" value="language">Language</button></li>
                        <li><button class="dropdown-item" type="submit" name="filter" value="genres">Genre</button></li>
                    </ul>
                </div>
            </form>
        </div>    
        <div class="content" style="display:grid; grid-template-columns: repeat(4, 1fr); justify-items:center;">
            <?php foreach ($_SESSION['movies'] as $movie) { ?>
                <a href="#" class="text-decoration-none border-0" style="width: 17rem;">
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


    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <?php
        include("../templates/footer.php");
    ?>
</body>

</html>