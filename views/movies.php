<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/movie/manageMovie_contr.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/session/manageSession_contr.php";

    $mc = new ManageMovieContr();
    $movies = $mc->retrieveAllAvailableMovies();
    
    $sc = new ManageSessionContr();
    $sessions = $sc->retrieveAllAvailableSessions();
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
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <span>
                <h1>Movies</h1>
                <p style="margin:0">Discover new movies, book your seats, and enjoy the show</p>
            </span>
        </div>    
        <div class="content" style="display:grid; grid-template-columns: repeat(4, 1fr); justify-items:center;">
            <?php foreach ($movies as $movie) { ?>
                <a href="#" class="text-decoration-none border-0 mb-5" style="width: 17rem;" data-bs-toggle="modal" data-bs-target="#view<?php echo $movie['id']; ?>">
                    <img src="data:image/png;base64,<?php echo $movie['poster']; ?>" class="card-img-top mb-3" style="height:400px; object-fit:cover;" alt="<?php echo $movie['title'] ?>">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-white mb-2"><?php echo $movie['title'] ?></h5>
                        <div class="d-flex justify-content-between">
                            <p class="card-text text-white" style="font-size:12px;width: fit-content;padding: 2px 10px;background-color: #d74545;border-radius: 15px;"><?php echo $movie['genres'] ?></p>
                            <p class="card-text text-white-50" style="font-size:12px;"><?php echo $movie['runtimeMin'] ?> minutes</p>
                        </div>
                    </div>
                </a>

                <div class="modal fade" id="view<?php echo $movie['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:800px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Movie Details</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5">
                                <div class="container">
                                    <iframe height="393" style="width: -webkit-fill-available;"
                                        src="<?php echo $movie['trailerURL']; ?>">
                                    </iframe>
                                    <div class="d-flex mt-4">
                                        <div class="w-100">
                                            <div class="d-flex flex-row align-items-center">
                                                <p class="card-text text-white" style="font-size:12px;width: fit-content;padding: 2px 10px;background-color: #d74545;border-radius: 15px;"><?php echo $movie['genres']; ?></p>
                                                <p class="d-flex mx-5" style="font-size:14px;"><i class="bi bi-clock-history"></i>&nbsp;&nbsp;<?php echo $movie['runtimeMin']; ?> minutes</p>
                                                <p class="d-flex" style="font-size:14px;"><i class="bi bi-translate"></i>&nbsp;&nbsp;<?php echo $movie['language']; ?></p>
                                            </div>
                                            <h2><?php echo $movie['title']; ?></h2>
                                            <p><?php echo $movie['synopsis']; ?></p>
                                            
                                            <div class="d-flex justify-content-center mt-5">
                                                <div class="input-group w-75" title="Session">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-clock"></i>
                                                    </span>
                                                    <select class="form-select" id="sessionId" name="sessionId" aria-label="Default select">
                                                        <option hidden selected value="">Select a Session</option>
                                                        <?php foreach ($sessions as $session) {
                                                            if ($session['movieId'] == $movie['id']) {?>
                                                                <option value="<?php echo $session['id'] . '|' . $session['hallId']; ?>"><?php echo $session['name']?> | <?php echo $formattedDate = date('j F', strtotime($session['date'])); ?>, <?php echo $session['startTime']; ?> - <?php echo $session['endTime'];?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="d-flex ms-5">
                                                    <?php if (isset($_SESSION['email'])) {?>
                                                        <a href="movieBookingMgmt/createMovieBooking.php?movieId=<?php echo $movie['id']; ?>&hallId=" id="bookNowButton" type="button" class="btn btn-danger">Book now</a>
                                                    <?php } else { ?>
                                                        <a href="login.php" type="button" class="btn btn-danger">Login to book</a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/footer.php';
    ?>


<script>
    const bookNowButtons = document.querySelectorAll('#bookNowButton');
    const selectSessions = document.querySelectorAll('#sessionId');

    for (let i = 0; i < bookNowButtons.length; i++) {
        const bnb = bookNowButtons[i];
        const ss = selectSessions[i];

        bnb.addEventListener('click', function(event) {
            if (ss.value == '') {
                event.preventDefault();
                alert('Please select a Session');
            }
        });

        ss.addEventListener('change', function() {
            const sessionId = ss.value.split('|')[0];
            const hallId = ss.value.split('|')[1];
            const hrefParts = bnb.href.split('?');
            const newHref = `${hrefParts[0]}?${hrefParts[1].replace(/hallId=[^&]*/, `hallId=${hallId}&sessionId=${sessionId}`)}`;

            bnb.href = newHref;
        });
    }
</script>

</body>

</html>