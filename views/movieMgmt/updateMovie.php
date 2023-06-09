<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/movie/manageMovie_contr.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/ticketType/manageTicketType_contr.php";

    $mmc = new ManageMovieContr();
    $movieDetails = $mmc->retrieveOneMovie($_GET['movieId']);
    $languages = $mmc->retrieveAllLanguages();
    $genres = $mmc->retrieveAllGenres();

    $ttc = new ManageTicketTypeContr();
    $ticketTypes = $ttc->retrieveAllTicketTypes();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Update Movie | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../controllers/movie/updateMovie_contr.php?movieId=<?php echo $movieDetails['id']; ?>" enctype="multipart/form-data" class="w-50">
                <h1>Movie Details</h1>
                <div class="input-group mt-4" title="Movie Title">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="<?php echo $movieDetails['title']; ?>" required>
                </div>
                <div class="input-group mt-3" title="Synopsis">
                    <span class="input-group-text">
                        <i class="bi bi-book"></i>
                    </span>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Synopsis" id="synopsis" name="synopsis" style="height: 100px" required><?php echo $movieDetails['synopsis']; ?></textarea>
                        <label class="text-secondary" for="synopsis">Synopsis</label>
                    </div>
                </div>
                <div class="input-group mt-3" title="Runtime (Minutes)">
                    <span class="input-group-text">
                        <i class="bi bi-clock-history"></i>
                    </span>
                    <input type="text" class="form-control" id="runtimeMin" name="runtimeMin" placeholder="Runtime (Minutes)" pattern="^[0-9]{1,4}$" value="<?php echo $movieDetails['runtimeMin']; ?>" required>
                </div>
                <div class="input-group mt-3" title="Trailer URL (Embed)">
                    <span class="input-group-text">
                        <i class="bi bi-link"></i>
                    </span>
                    <input type="text" class="form-control" id="trailerURL" name="trailerURL" placeholder="Trailer URL (Embed)" value="<?php echo $movieDetails['trailerURL']; ?>" required>
                </div>
                <div class="input-group mt-3" title="Start Date">
                    <span class="input-group-text">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <div class="form-floating">
                        <input type="date" class="form-control" id="startDate" name="startDate" placeholder="Start Date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo $movieDetails['startDate']; ?>" required>
                        <label class="text-secondary" for="startDate">Start Date</label>
                    </div>
                </div>
                <div class="input-group mt-3" title="End Date">
                    <span class="input-group-text">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <div class="form-floating">
                        <input type="date" class="form-control" id="endDate" name="endDate" placeholder="End Date" value="<?php echo $movieDetails['endDate']; ?>" required>
                        <label class="text-secondary" for="endDate">End Date</label>
                    </div>
                </div>
                <div class="input-group mt-3" title="Language">
                    <span class="input-group-text">
                        <i class="bi bi-translate"></i>
                    </span>
                    <select class="form-select" id="language" name="language" aria-label="Default select">
                        <?php foreach ($languages as $language) { ?>
                            <option value="<?php echo $language['languageName']; ?>" <?php if($movieDetails['language'] == $language['languageName']) { ?> selected <?php } ?>><?php echo $language['languageName']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group mt-3"  title="Genre">
                    <span class="input-group-text">
                        <i class="bi bi-camera-reels"></i>
                    </span>
                    <input type="text" class="form-control bg-dark-subtle pe-none" id="genre" name="genre" placeholder='Genre (select using dropdown)' value="<?php echo $movieDetails['genres']; ?>" required onkeydown="return false;">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">Genres</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item genre-btn" type="button" data-value="reset"><b>Reset</b></button></li>
                        <?php foreach ($genres as $genre) { ?>
                            <li><button class="dropdown-item genre-btn" type="button" data-value="<?php echo $genre['genreName']; ?>"><?php echo $genre['genreName']; ?></button></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="input-group mt-3" title="Ticket Type(s)">
                    <span class="input-group-text">
                        <i class="bi bi-ticket-perforated"></i>
                    </span>
                    <input type="text" class="form-control bg-dark-subtle pe-none" id="ticketType" name="ticketType" placeholder='Ticket Type (select using dropdown)' value="<?php echo $movieDetails['ticketTypes']; ?>" required onkeydown="return false;">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">Ticket Types</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item ticketType-btn" type="button" data-value="reset"><b>Reset</b></button></li>
                        <?php foreach ($ticketTypes as $ticketType) { ?>
                        <li><button class="dropdown-item ticketType-btn" type="button" data-value="<?php echo $ticketType['name']; ?>"><?php echo $ticketType['name']; ?></button></li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="mt-4">
                    <label for="posterFile" class="form-label">Upload Poster Image (Maximum size: 2MB)</label>
                    <input type="file" class="form-control" id="posterFile" name="posterFile" onchange="previewPoster()" accept="image/*">
                </div>
                <div class="d-flex">
                    <button type="submit" name="updateMovie" class="btn btn-danger my-4 me-3">Update movie</button>
                    <a href="manageMovies.php" class="btn btn-outline-info my-4">Cancel</a>
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

    const ticketTypeBtns = document.querySelectorAll('.ticketType-btn');
    const ticketTypeInput = document.querySelector('#ticketType');

    ticketTypeBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const value = btn.getAttribute('data-value');
            if (value === "reset") {
                ticketTypeInput.value = "";
            return;
            }
            if (ticketTypeInput.value.includes(value)) return;
            ticketTypeInput.value += (ticketTypeInput.value ? ', ' : '') + value;
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