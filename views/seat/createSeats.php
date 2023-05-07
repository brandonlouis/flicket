<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/flicket/controllers/seat_contr.php';

    $sc = new SeatContr();
    $hallDetails = $sc->retrieveOneHall($_GET['hallId']);
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Seat Details | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../controllers/seat_contr.php?hallId=<?php echo $hallDetails['id']; ?>" class="w-50" id="form">
                <h1>Seat Details</h1>
                <table class="text-white my-4">
                    <tbody>
                        <tr>
                            <td style="width:115px">Cinema Hall:</td>
                            <td><b><?php echo $hallDetails['name'] . ', Hall ' . $hallDetails['hallNumber']; ?></b></td>
                        </tr>
                        <tr>
                            <td>Seats created:</td>
                            <td><b><?php echo $hallDetails['totalSeats'] . '/' . $hallDetails['capacity']; ?></b></td>
                    </tbody>
                </table>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-arrow-bar-right"></i>
                    </span>
                    <input type="number" class="form-control" id="rowCount" name="rowCount" placeholder="Number of Rows" min="1" max="10" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-123"></i>
                    </span>
                    <input type="number" class="form-control" id="seatCount" name="seatCount" placeholder="Number of Seats per row" min="1" max="20" required>
                </div>
                <div class="input-group mt-3" title="Seat status">
                    <span class="input-group-text">
                        <i class="bi bi-gear"></i>
                    </span>
                    <select class="form-select" id="status" name="status" aria-label="Default select">
                        <option hidden>Assign a status for seat(s)</option>
                        <option value="Available">Available</option>
                        <option value="Occupied">Occupied</option>
                        <option value="Suspended">Suspended</option>
                    </select>
                </div>
                <div class="d-flex">
                    <button type="submit" name="createSeats" class="btn btn-danger my-4 me-3">Create seats</button>
                    <a href="manageSeats.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
                <input type="hidden" name="seatData" id="seatData">
            </form>
            <div class="d-flex justify-content-center flex-column align-items-center" style="width:45%">
                <div id="seatingLayout"><div class="row screen"><div class="screen col-label">Screen</div></div></div>
                <div id="seatingLegend">
                    <div class="row legend pe-none mt-4 mb-0">
                        <div class="legend label">Available</div><div class="legendseat available mx-3 ms-1"></div>
                        <div class="legend label">Occupied</div><div class="legendseat occupied mx-3 ms-1"></div>
                        <div class="legend label">Suspended</div><div class="legendseat suspended mx-3 ms-1"></div>
                    </div>
                </div>
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
    const rowCountInput = document.getElementById('rowCount');
    const seatCountInput = document.getElementById('seatCount');
    const statusInput = document.getElementById('status');

    rowCountInput.addEventListener('input', generateSeatingLayout);
    seatCountInput.addEventListener('input', generateSeatingLayout);
    statusInput.addEventListener('input', generateSeatingLayout);

    function generateSeatingLayout() {
        const rowCount = rowCountInput.value;
        const seatCount = seatCountInput.value;
        const status = statusInput.value;

        let html = '';
        html += '<div class="row screen"><div class="screen col-label">Screen</div></div>';

        for (let i = 0; i < rowCount && i < <?php echo $hallDetails['capacity'] ?>; i++) {
            html += '<div class="row">';
            html += '<div class="col-label">' + String.fromCharCode(65 + i) + '</div>';
            for (let j = 0; j < seatCount && (i * seatCount + j) < <?php echo $hallDetails['capacity'] ?>; j++) {
                html += '<div class="seat ' + (status === 'Available' ? 'available' : status === 'Occupied' ? 'occupied' : 'suspended') + ' pe-none" data-seat="' + String.fromCharCode(65 + i) + ':' + (j + 1) + '">' + (j + 1) + '</div>';
            }
            html += '</div>';
        }        

        document.getElementById('seatingLayout').innerHTML = html;

        const divs = document.querySelectorAll('.row .seat');
        const seatData = [];
        divs.forEach(div => {
            const seat = div.dataset.seat;
            seatData.push(seat);
        });

        const seatDataInput = document.getElementById('seatData');
        seatDataInput.value = JSON.stringify(seatData);
    }

</script>

</body>

</html>