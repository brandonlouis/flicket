<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/cinemahall/manageCinemaHall_contr.php";

    $mch = new ManageCinemaHallContr();
    $cinemahalls = $mch->retrieveAllCinemaHalls();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Manage Cinema Halls | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Manage Cinema Halls</h1>

                <div class="d-flex">
                    <form method="POST" action="../../controllers/cinemahall/searchCinemaHall_contr.php" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchText" name="searchText" placeholder="Search...">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Filter by</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" type="submit" name="filter" value="None"></button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="id">Cinema Hall ID</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="name">Cinema Name</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="hallNumber">Hall Number</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="address">Address</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="capacity">Capacity</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="status">Status</button></li>
                            </ul>
                        </div>
                    </form>
                    <a href="createCinemaHall.php" type="submit" class="btn btn-success bi bi-plus-lg fs-3 ms-4" title="Create Hall"></a>
                </div>
            </div>
            <table class="table table-hover text-white mt-4">
                <thead>
                    <tr>
                        <th>Cinema Hall ID</th>
                        <th>Cinema Name</th>
                        <th>Hall Number</th>
                        <th>Address</th>
                        <th>Capacity</th>
                        <th>Status</th>
                        <th></th>
                    <tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($cinemahalls as $cinemahall) { ?>
                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#view<?php echo $cinemahall['id']; ?>">
                        <td><?php echo $cinemahall['id']; ?></td>
                        <td title="<?php echo $cinemahall['name']; ?>"><?php echo $cinemahall['name']; ?></td>
                        <td title="<?php echo $cinemahall['hallNumber']; ?>"><?php echo $cinemahall['hallNumber']; ?></td>
                        <td><?php echo $cinemahall['address']; ?></td>
                        <td><?php echo $cinemahall['capacity']; ?></td>
                        <td><span class="<?php echo $cinemahall['status'] == 'Available' ? 'badge bg-success' : 'badge bg-danger'; ?>"><?php echo $cinemahall['status']; ?></span></td>

                        <td class="d-flex justify-content-evenly">
                            <a href="updateCinemaHall.php?cinemaHallId=<?php echo $cinemahall['id']; ?>" type="submit" class="btn btn-outline-info bi bi-pencil fs-5" title="Edit Cinema Hall"></a>
                            <?php
                                if ($cinemahall['status'] == 'Available') {
                                    echo '<button type="button" href="#" class="btn btn-danger bi bi-pause-fill fs-5" title="Suspend Movie" data-bs-toggle="modal" data-bs-target="#suspend' . $cinemahall['id'] . '" onclick="event.stopPropagation();"></button>';
                                } else {
                                    echo '<a href="../../controllers/cinemahall/suspendCinemaHall_contr.php?activateId=' . $cinemahall["id"] . '" class="btn btn-success bi bi-play-fill fs-5" title="Activate Movie"></a>';
                                }
                            ?>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="suspend<?php echo $cinemahall['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Suspend Cinema Hall</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Suspend the following cinema hall?
                                    <br/><br/>
                                    <span>CinemaHall ID </span>: <?php echo $cinemahall['id']; ?><br/>
                                    <span>Name </span> &nbsp;: <?php echo $cinemahall['name']; ?><br/>
                                    <span>Hall Number </span> &nbsp;: <?php echo $cinemahall['hallNumber']; ?><br/>
                                </div>
                                <div class="modal-footer">
                                    <a href="../../controllers/cinemahall/suspendCinemaHall_contr.php?suspendId=<?php echo $cinemahall['id']; ?>" type="button" class="btn btn-danger">Yes</a>
                                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">No</button>
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