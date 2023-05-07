<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
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

 
    <title>Search Movies | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Manage Movies</h1>

                <div class="d-flex">
                    <form method="POST" action="../../controllers/movie_contr.php" class="d-flex">
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
                                <li><button class="dropdown-item" type="submit" name="filter" value="status">Status</button></li>
                            </ul>
                        </div>
                    </form>
                    <a href="createMovie.php" type="submit" class="btn btn-success bi bi-plus-lg fs-3 ms-4" title="Create Movie"></a>
                </div>
            </div>
            <table class="table table-hover text-white mt-4">
                <thead>
                    <tr>
                        <th>Movie ID</th>
                        <th>Title</th>
                        <th>Synopsis</th>
                        <th>Runtime (Minutes)</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Language</th>
                        <th>Genre</th>
                        <th>Status</th>
                        <th></th>
                    <tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($_SESSION['movies'] as $movie) { ?>
                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#view<?php echo $movie['id']; ?>">
                        <td><?php echo $movie['id']; ?></td>
                        <td title="<?php echo $movie['title']; ?>"><?php echo $movie['title']; ?></td>
                        <td title="<?php echo $movie['synopsis']; ?>"><?php echo $movie['synopsis']; ?></td>
                        <td><?php echo $movie['runtimeMin']; ?></td>
                        <td><?php echo $movie['startDate']; ?></td>
                        <td><?php echo $movie['endDate']; ?></td>
                        <td><?php echo $movie['language']; ?></td>
                        <td title="<?php echo $movie['genres']; ?>"><?php echo $movie['genres']; ?></td>
                        <td class="<?php echo $movie['status'] == 'available' ? 'text-success' : 'text-danger'; ?>"><?php echo $movie['status']; ?></td>

                        <td class="d-flex justify-content-evenly">
                            <a href="updateMovie.php?movieId=<?php echo $movie['id']; ?>" type="submit" class="btn btn-outline-info bi bi-pencil fs-5" title="Edit Movie"></a>
                            <?php
                                if ($movie['status'] == 'available') {
                                    echo '<button type="button" href="#" class="btn btn-danger bi bi-pause-fill fs-5" title="Suspend Movie" data-bs-toggle="modal" data-bs-target="#suspend' . $movie['id'] . '"></button>';
                                } else {
                                    echo '<a href="../../controllers/movie_contr.php?activateId=' . $movie["id"] . '" class="btn btn-success bi bi-play-fill fs-5" title="Activate Movie"></a>';
                                }
                            ?>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="suspend<?php echo $movie['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Suspend Movie</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Suspend the following movie?
                                <br/><br/>
                                <span>Movie ID </span>: <?php echo $movie['id']; ?><br/>
                                <span>Title </span> &nbsp;: <?php echo $movie['title']; ?><br/>
                            </div>
                            <div class="modal-footer">
                                <a href="../../controllers/movie_contr.php?suspendId=<?php echo $movie['id']; ?>" type="button" class="btn btn-danger">Yes</a>
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">No</button>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="view<?php echo $movie['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-100 w-75">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">View Movie Session</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                        <dl class="row">
                                        <dt class="col-sm-3">Movie ID</dt>
                                            <dd class="col-sm-9 mb-5"><?php echo $movie['id']; ?></dd>
                                            
                                            <dt class="col-sm-3">Title</dt>
                                            <dd class="col-sm-9 mb-5"><?php echo $movie['title']; ?></dd>

                                            <dt class="col-sm-3">Synopsis</dt>
                                            <dd class="col-sm-9 mb-5">
                                                <p><?php echo $movie['synopsis']; ?></p>
                                            </dd>

                                            <dt class="col-sm-3">Runtime (Minutes)</dt>
                                            <dd class="col-sm-9 mb-5"><?php echo $movie['runtimeMin']; ?></dd>

                                            <dt class="col-sm-3">Start Date</dt>
                                            <dd class="col-sm-9 mb-5"><?php echo $movie['startDate']; ?></dd>

                                            <dt class="col-sm-3">End Date</dt>
                                            <dd class="col-sm-9 mb-5"><?php echo $movie['endDate']; ?></dd>

                                            <dt class="col-sm-3">Language</dt>
                                            <dd class="col-sm-9 mb-5"><?php echo $movie['language']; ?></dd>

                                            <dt class="col-sm-3">Genres</dt>
                                            <dd class="col-sm-9 mb-5">
                                                <?php echo $movie['genres']; ?>
                                            </dd>

                                            <dt class="col-sm-3">Trailer URL</dt>
                                            <dd class="col-sm-9">
                                                <a href="<?php echo $movie['trailerURL']; ?>">
                                                    <?php echo $movie['trailerURL']; ?>
                                                </a>
                                            </dd>
                                            <dt class="col-sm-3">Trailer Video</dt>
                                            <dd class="col-sm-9">
                                                <iframe width="560" height="315"
                                                src="<?php echo $movie['trailerURL']; ?>">
                                                </iframe>
                                            </dd>
                                        </div>
                                        <div class="col">
                                            <div class=" d-flex justify-content-center">
                                                <?php
                                                $posterImg = '<img id="posterImg" style="width:100%" src="data:image/png;base64,' . $movie['poster'] . '" alt="Movie Poster" />';
                                                echo $posterImg;?>
                                            </div>
                                        
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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