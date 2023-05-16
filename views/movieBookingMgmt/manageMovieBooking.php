<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/bookmovie/manageMovieBooking_contr.php";

    $mbc = new ManageMovieBookingContr();
    $movieBookings = $mbc->retrieveAllMovieBookings($_SESSION['id']);
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Manage Movie Bookings | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Manage Movie Bookings</h1>
            </div>
            <table class="table table-hover text-white mt-4">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Title</th>
                        <th>Cinema Name</th>
                        <th>Hall Number</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Quantity</th>
                        <th></th>
                    <tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($movieBookings as $movieBooking) { ?>
                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#view<?php echo $movieBooking['id']; ?>">
                        <td><?php echo $movieBooking['id']; ?></td>
                        <td title="<?php echo $movieBooking['title']; ?>"><?php echo $movieBooking['title']; ?></td>
                        <td title="<?php echo $movieBooking['cinemaName']; ?>"><?php echo $movieBooking['cinemaName']; ?></td>
                        <td>Hall <?php echo $movieBooking['hallNumber']; ?></td>
                        <td><?php echo $movieBooking['startTime']; ?></td>
                        <td><?php echo $movieBooking['endTime']; ?></td>
                        <td><?php echo $movieBooking['quantity']; ?></td>
                        
                        <td class="d-flex justify-content-evenly">
                            <button type="button" href="#" class="btn btn-danger fs-5" title="Delete Movie Booking" data-bs-toggle="modal" data-bs-target="#delete<?php echo $movieBooking['id']; ?>" >Delete</button>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="delete<?php echo $movieBooking['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Delete Movie Booking</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Delete the following movie booking?
                                <br/><br/>
                                <span>Movie Booking ID </span>: <?php echo $movieBooking['id']; ?><br/>
                                <span>Title </span> &nbsp;: <?php echo $movieBooking['title']; ?><br/>
                                <span>Cinema Name </span> &nbsp;: <?php echo $movieBooking['cinemaName']; ?><br/>
                                <span>Hall Number </span> &nbsp;: <?php echo $movieBooking['hallNumber']; ?><br/>
                                <span>Start Time </span> &nbsp;: <?php echo $movieBooking['startTime']; ?><br/>
                                <span>End Time </span> &nbsp;: <?php echo $movieBooking['endTime']; ?><br/>
                                <span>Quantity </span> &nbsp;: <?php echo $movieBooking['quantity']; ?><br/>
                            </div>
                            <div class="modal-footer">
                                <a href="../../controllers/bookmovie/deleteMovieBooking_contr.php?deleteId=<?php echo $movieBooking['id']; ?>" type="button" class="btn btn-danger">Yes</a>
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">No</button>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="view<?php echo $movieBooking['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-100 w-75">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">View Movie Booking</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <dl class="row">
                                                <dt class="col-sm-4">Movie Booking ID</dt>
                                                <dd class="col-sm-8"><?php echo $movieBooking['id']; ?></dd>

                                                <dt class="col-sm-4">Title</dt>
                                                <dd class="col-sm-8"><?php echo $movieBooking['title']; ?></dd>

                                                <dt class="col-sm-4">Cinema Name</dt>
                                                <dd class="col-sm-8">
                                                    <p><?php echo $movieBooking['cinemaName']; ?></p>
                                                </dd>

                                                <dt class="col-sm-4">Hall Number</dt>
                                                <dd class="col-sm-8"><?php echo $movieBooking['hallNumber']; ?></dd>

                                                <dt class="col-sm-4">Start Time</dt>
                                                <dd class="col-sm-8"><?php echo $movieBooking['startTime']; ?></dd>

                                                <dt class="col-sm-4">End Time</dt>
                                                <dd class="col-sm-8"><?php echo $movieBooking['endTime']; ?></dd>

                                                <dt class="col-sm-4">Quantity</dt>
                                                <dd class="col-sm-8"><?php echo $movieBooking['quantity']; ?></dd>

                                            </div>
                                            <div class="col">
                                                <div class=" d-flex justify-content-end">
                                                    <?php echo '<img id="posterImg" style="width:auto;height:500px;" src="data:image/png;base64,' . $movieBooking['poster'] . '" alt="Movie Poster" />'; ?>
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