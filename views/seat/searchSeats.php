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

 
    <title>Search Seats | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Search Seats</h1>

                <div class="d-flex">
                    <a href="manageSeats.php" type="submit" class="btn btn-outline-light fs-6 me-4">&#11148; Back</a>
                    <form method="POST" action="../../controllers/seat_contr.php" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchText" name="searchText" placeholder="Search...">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Filter by</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" type="submit" name="filter" value="None"></button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="cinemaName">Cinema Name</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="hallNumber">Hall Number</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="accessType">Seat Number</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="status">Status</button></li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-hover text-white mt-4">
                <thead>
                    <tr>
                        <th>Cinema Name</th>
                        <th>Hall Number</th>
                        <th>Seat Number</th>
                        <th>Status</th>
                        <th></th>
                    <tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($_SESSION['seats'] as $seat) { ?>
                    <tr>
                        <td><?php echo $seat['name']; ?></td>
                        <td><?php echo $seat['hallNumber']; ?></td>
                        <td><?php echo $seat['rowLetter'] . $seat['seatNumber']; ?></td>
                        <td>
                            <span class="<?php echo $seat['status'] == 'available' ? 'badge bg-success' : ($seat['status'] == 'occupied' ? 'badge bg-warning text-black' : 'badge bg-danger'); ?>">
                                <?php echo ucfirst($seat['status']); ?>
                            </span>
                        </td>

                        <td class="d-flex justify-content-evenly">
                            <a href="updateSeats.php?hallId=<?php echo $seat['hallId']; ?>&selectedSeat=<?php echo $seat['rowLetter'] . $seat['seatNumber']; ?>" type="submit" class="btn btn-outline-info bi bi-pencil fs-5" title="Edit Seat"></a>
                        </td>
                    </tr>
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