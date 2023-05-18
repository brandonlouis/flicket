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

 
    <title>Manage Sessions | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Manage Sessions</h1>

                <div class="d-flex">
                    <form method="POST" action="../../controllers/session/searchSession_contr.php" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchText" name="searchText" placeholder="Search...">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Filter by</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" type="submit" name="filter" value="None"></button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="s.id">Session ID</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="title">Movie Title</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="CONCAT(ch.name, ', Hall ', ch.hallNumber)">Venue</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="DATE(s.startTime)">Date</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="DATE_FORMAT(s.startTime, '%h:%i %p')">Start Time</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="DATE_FORMAT(s.endTime, '%h:%i %p')">End Time</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="s.status">Status</button></li>
                            </ul>
                        </div>
                    </form>
                    <a href="createSession.php" type="submit" class="btn btn-success bi bi-plus-lg fs-3 ms-4" title="Create Session"></a>
                </div>
            </div>
            <table class="table table-hover text-white mt-4">
                <thead>
                    <tr>
                        <th style="width:8%">Session ID</th>
                        <th style="width:18%">Movie Title</th>
                        <th style="width:18%">Venue</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th></th>
                    <tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($_SESSION['sessions'] as $session) { ?>
                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#view<?php echo $session['id']; ?>">
                        <td><?php echo $session['id']; ?></td>
                        <td title="<?php echo $session['title'] ?>"><?php echo $session['title']; ?></td>
                        <td title="<?php echo $session['venue'] ?>"><?php echo $session['venue']; ?></td>
                        <td><?php echo $session['date']; ?></td>
                        <td><?php echo $session['startTime']; ?></td>
                        <td><?php echo $session['endTime']; ?></td>
                        <td><span class="<?php echo $session['status'] == 'Available' ? 'badge bg-success' : 'badge bg-danger'; ?>"><?php echo $session['status']; ?></span></td>

                        <td class="d-flex justify-content-evenly">
                            <a href="updateSession.php?sessionId=<?php echo $session['id']; ?>" type="submit" class="btn btn-outline-info bi bi-pencil fs-5" title="Edit Session"></a>
                            <?php
                                if ($session['status'] == 'Available') {
                                    echo '<button type="button" href="#" class="btn btn-danger bi bi-pause-fill fs-5" title="Suspend Session" data-bs-toggle="modal" data-bs-target="#suspend' . $session['id'] . '" onclick="event.stopPropagation();"></button>';
                                } else {
                                    echo '<a href="../../controllers/session/suspendSession_contr.php?activateId=' . $session["id"] . '" class="btn btn-success bi bi-play-fill fs-5" title="Activate Session"></a>';
                                }
                            ?>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="suspend<?php echo $session['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Suspend Session</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Suspend the following session?
                                    <br/><br/>
                                    <span>Session ID </span>: <?php echo $session['id']; ?><br/>
                                    <span>Title </span> &nbsp;: <?php echo $session['title']; ?><br/>
                                    <span>Venue </span>: <?php echo $session['venue']; ?><br/>
                                    <span>Date </span> &nbsp;&nbsp;: <?php echo $session['date']; ?><br/>
                                    <span>Start Time </span>: <?php echo $session['startTime']; ?><br/>
                                    <span>End Time </span> : <?php echo $session['endTime']; ?><br/>
                                </div>
                                <div class="modal-footer">
                                    <a href="../../controllers/session/suspendSession_contr.php?suspendId=<?php echo $session['id']; ?>" type="button" class="btn btn-danger">Yes</a>
                                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">No</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="view<?php echo $session['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" style="min-width:50%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">View Session</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body pb-4">
                                    <div class="container">
                                        <div class="d-flex justify-content-around align-items-center">
                                            <div class="d-flex">
                                                <div class="me-5">
                                                    <p><span class="fw-bold">Session ID</span> :</p>
                                                    <p><span class="fw-bold">Title</span> :</p>
                                                    <p><span class="fw-bold">Runtime</span> :</p>
                                                    <p><span class="fw-bold">Venue</span> :</p>
                                                    <p><span class="fw-bold">Date</span> :</p>
                                                    <p><span class="fw-bold">Start Time</span> :</p>
                                                    <p><span class="fw-bold">End Time</span> :</p>
                                                    <p><span class="fw-bold">Status</span> :</p>
                                                </div>
                                                <div>
                                                    <p><?php echo $session['id']; ?></p>
                                                    <p><?php echo $session['title']; ?></p>
                                                    <p><?php echo $session['runtimeMin']; ?> minutes</p>
                                                    <p><?php echo $session['venue']; ?></p>
                                                    <p><?php echo $session['date']; ?></p>
                                                    <p><?php echo $session['startTime']; ?></p>
                                                    <p><?php echo $session['endTime']; ?></p>
                                                    <span class="<?php echo $session['status'] == 'Available' ? 'badge bg-success' : 'badge bg-danger'; ?>"><?php echo $session['status']; ?></span>
                                                </div>
                                            </div>
                                            <div class=" d-flex justify-content-end">
                                                <?php echo '<img id="posterImg" style="width:auto;height:300px;" src="data:image/png;base64,' . $session['poster'] . '" alt="Session Poster" />'; ?>
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