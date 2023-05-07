<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/movie_contr.php";

    $mc = new MovieContr();
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

 
    <title>Create Movie | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../controllers/movie_contr.php" enctype="multipart/form-data" class="w-50">
                <h1>Movie Details</h1>
                <div class="input-group mt-4">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-book"></i>
                    </span>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Synopsis" id="synopsis" name="synopsis" style="height: 100px" required></textarea>
                        <label class="text-secondary" for="synopsis">Synopsis</label>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-clock-history"></i>
                    </span>
                    <input type="text" class="form-control" id="runtimeMin" name="runtimeMin" placeholder="Runtime (Minutes)" pattern="^[0-9]{1,4}$" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-link"></i>
                    </span>
                    <input type="text" class="form-control" id="" name="trailerURL" placeholder="Trailer URL" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <div class="form-floating">
                        <input type="date" class="form-control" id="startDate" name="startDate" placeholder="Start Date" min="<?php echo date("Y-m-d"); ?>" required>
                        <label class="text-secondary" for="startDate">Start Date</label>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-calendar3"></i>
                    </span>
                    <div class="form-floating">
                        <input type="date" class="form-control" id="endDate" name="endDate" placeholder="End Date" required>
                        <label class="text-secondary" for="endDate">End Date</label>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-translate"></i>
                    </span>
                    <select class="form-select" id="language" name="language" aria-label="Default select">
                        <?php foreach ($languages as $language) { ?>
                            <option value="<?php echo $language['languageName']; ?>" ><?php echo $language['languageName']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-camera-reels"></i>
                    </span>
                    <input type="text" class="form-control bg-dark-subtle pe-none" id="genre" name="genre" placeholder='Genre (select using dropdown)' required onkeydown="return false;">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">Genres</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item genre-btn" type="button" data-value="reset"><b>Reset</b></button></li>
                        <?php foreach ($genres as $genre) { ?>
                        <li><button class="dropdown-item genre-btn" type="button" data-value="<?php echo $genre['genreName']; ?>"><?php echo $genre['genreName']; ?></button></li>
                        <?php } ?>
                    </ul>
                </div>


                <div class="mt-4">
                    <label for="posterFile" class="form-label">Upload Poster Image (Maximum size: 2MB)</label>
                    <input type="file" class="form-control" id="posterFile" name="posterFile" onchange="previewPoster()" accept="image/*" required>
                </div>
                <div class="d-flex">
                    <button type="submit" name="createMovie" class="btn btn-danger my-4 me-3">Create movie</button>
                    <a href="manageMovies.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
            </form>
            <div style="width:45%" class="d-flex justify-content-end">
                <img id="posterImg" src="" alt="Preview" style="display:none;width:auto;height:700px">
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

    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');

    startDateInput.addEventListener('change', () => {
        if (endDateInput.value < startDateInput.value) endDateInput.value = startDateInput.value;
        endDateInput.min = startDateInput.value;
    });

    function previewPoster() {
        const input = document.getElementById("posterFile");
        const file = input.files[0];

        if (file.size > 2097152) {
            alert('File size should be less than 2MB');
            input.value = "";
            previewImg.style.display = "none";
        } else {
            const reader = new FileReader();
            const previewImg = document.getElementById("posterImg");

            reader.onload = function (event) {
                previewImg.src = event.target.result;
                previewImg.style.display = "block";
            };

            reader.readAsDataURL(file);
        }


    }


</script>

</body>

</html>