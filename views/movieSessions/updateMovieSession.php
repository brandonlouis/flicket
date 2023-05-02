<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include "../../classes/dbh_classes.php";
    include "../../controllers/movie_contr.php";

    $mc = new MovieContr();
    $mc->retrieveAMovie($_GET['movieId']);
    $mc->retrieveLanguages();
    $mc->retrieveGenres();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Update Movie Session | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include("../../templates/header.php");
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../includes/movieMgmt_inc.php?movieId=<?php echo $_SESSION['movieDetails']['id']; ?>" enctype="multipart/form-data" style="width:45%">
                <h1>Movie Details</h1>
        
                <div class="input-group mt-4">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $_SESSION['movieDetails']['title']; ?>" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-book"></i>
                    </span>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Synopsis" id="synopsis" name="synopsis" style="height: 100px" required><?php echo $_SESSION['movieDetails']['synopsis']; ?></textarea>
                        <label class="text-secondary" for="synopsis">Synopsis</label>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-clock-history"></i>
                    </span>
                    <input type="text" class="form-control" id="runtimeMin" name="runtimeMin" placeholder="Runtime (Minutes)" pattern="^[0-9]{1,4}$" value="<?php echo $_SESSION['movieDetails']['runtimeMin']; ?>" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-link"></i>
                    </span>
                    <input type="text" class="form-control" id="" name="trailerURL" placeholder="Trailer URL" value="<?php echo $_SESSION['movieDetails']['trailerURL']; ?>" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <div class="form-floating">
                        <input type="date" class="form-control" id="startDate" name="startDate" placeholder="Start Date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $_SESSION['movieDetails']['startDate']; ?>" required>
                        <label class="text-secondary" for="startDate">Start Date</label>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <div class="form-floating">
                        <input type="date" class="form-control" id="endDate" name="endDate" placeholder="End Date" value="<?php echo $_SESSION['movieDetails']['endDate']; ?>" required>
                        <label class="text-secondary" for="endDate">End Date</label>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-translate"></i>
                    </span>
                    <select class="form-select" id="language" name="language" aria-label="Default select">
                        <?php foreach ($_SESSION['languages'] as $language) { ?>
                            <option value="<?php echo $language['languageName']; ?>" <?php if($_SESSION['movieDetails']['language'] == $language['languageName']) { ?> selected <?php } ?>><?php echo $language['languageName']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-camera-reels"></i>
                    </span>
                    <input type="text" class="form-control bg-dark-subtle" id="genre" name="genre" placeholder='Genre (select using dropdown)' value="<?php echo $_SESSION['movieDetails']['genres']; ?>" required onclick="this.blur();" onkeydown="return false;">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">Genres</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item genre-btn" type="button" data-value="reset"><b>Reset</b></button></li>
                        <?php foreach ($_SESSION['genres'] as $genre) { ?>
                        <li><button class="dropdown-item genre-btn" type="button" data-value="<?php echo $genre['genreName']; ?>"><?php echo $genre['genreName']; ?></button></li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="mt-4">
                    <label for="posterFile" class="form-label">Upload Poster Image (Maximum size: 2MB)</label>
                    <input type="file" class="form-control" id="posterFile" name="posterFile" onchange="previewPoster()" accept="image/*" max-size="2MB">
                </div>
                <div class="d-flex">
                    <button type="submit" name="updateMovieSession" class="btn btn-danger my-4 me-3">Update movie session</button>
                    <a href="manageMovieSessions.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
            </form>
            <?php
                $posterImg = '<img id="posterImg" style="width:45%" src="data:image/png;base64,' . $_SESSION['movieDetails']['poster'] . '" alt="Movie Poster" />';
                echo $posterImg;
            ?>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <?php
        include("../../templates/footer.php");
    ?>


<script>
    const genreBtns = document.querySelectorAll('.genre-btn');
    const genreInput = document.querySelector('#genre');

    genreBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const value = btn.getAttribute('data-value');
            if (value === "reset") {
            genreInput.value = "";
            return;
            }
            if (genreInput.value.includes(value)) return;
            genreInput.value += (genreInput.value ? ', ' : '') + value;
        });
    });

    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');

    startDateInput.addEventListener('change', () => {
        if (endDateInput.value < startDateInput.value) endDateInput.value = startDateInput.value;
        endDateInput.min = startDateInput.value;
    });

    function previewPoster() {
        const fileInput = document.getElementById('posterFile');
        const file = fileInput.files[0];
        
        if (file && file.size > 2097152) {
            alert('File size should be less than 2MB');
            fileInput.value = '';
        } else {
            const previewImg = document.getElementById('posterImg');
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                previewImg.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    }

</script>
</body>

</html>