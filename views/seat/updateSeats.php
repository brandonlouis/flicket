<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/flicket/controllers/seat_contr.php';

    $sc = new SeatContr();
    $hallDetails = $sc->retrieveAllSeats($_GET['hallId']);
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
                            <td style="width:115px">Venue:</td>
                            <td><b><?php echo $hallDetails['name'] . ', Hall ' . $hallDetails['hallNumber']; ?></b></td>
                        </tr>
                        <tr>
                            <td>Seats available:</td>
                            <td><b><?php echo $hallDetails['seatsAvailable'] . '/' . $hallDetails['totalSeats'] ?></b></td>
                    </tbody>
                </table>
                <div class="input-group mt-3" title="Seat number">
                    <span class="input-group-text">
                        <i class="bi bi-ui-checks-grid"></i>
                    </span>
                    <input type="text" class="form-control bg-dark-subtle pe-none" id="seatLocation" name="seatLocation" placeholder="Select a seat from the diagram" required onkeydown="return false;">
                </div>
                <div class="input-group mt-3" title="Seat status">
                    <span class="input-group-text">
                        <i class="bi bi-gear"></i>
                    </span>
                    <select class="form-select" id="seatStatus" name="seatStatus" aria-label="Default select">
                        <option hidden>Assign a status for selected seat(s)</option>
                        <option value="Available">Available</option>
                        <option value="Occupied">Occupied</option>
                        <option value="Suspended">Suspended</option>
                    </select>
                </div>
                <div class="d-flex">
                    <button type="submit" name="updateSeat" class="btn btn-danger my-4 me-3">Update seat</button>
                    <a href="<?php echo isset($_GET['selectedSeat']) ? '../../controllers/seat_contr.php?search=true' : 'manageSeats.php'; ?>" class="btn btn-outline-info my-4">Back</a>
                </div>
            </form>
            <div class="d-flex justify-content-center flex-column align-items-center" style="width:45%">
                <div id="seatingLayout"></div>
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
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/footer.php';
    ?>


<script>
    function generateSeatingLayout() {
        const seatData = "<?php echo $hallDetails['seatData']; ?>".split(',');
        let selectedSeat = "<?php echo isset($_GET['selectedSeat']) ? $_GET['selectedSeat'] : ''; ?>";

        let html = '';
        html += '<div class="row screen"><div class="screen col-label">Screen</div></div>';

        let currentRow = '';
        for (let i = 0; i < seatData.length; i++) {
            const seat = seatData[i];
            const [row, seatNumber, status] = seat.split(':');

            if (row !== currentRow) {
                if (currentRow !== '') {
                    html += '</div>';
                }

                html += '<div class="row">';
                html += '<div class="col-label">' + row + '</div>';

                currentRow = row;
            }

            let seatClass = '';
            if (selectedSeat === row + seatNumber) {
                seatClass = 'selected';
            } else if (status === 'Available') {
                seatClass = 'available';
            } else if (status === 'Occupied') {
                seatClass = 'occupied';
            } else if (status === 'Suspended') {
                seatClass = 'suspended';
            }

            html += '<div class="seat ' + seatClass + '" data-seat="' + seat + '">' + seatNumber + '</div>';
        }

        if (currentRow !== '') {
            html += '</div>';
        }

        let htmlLegend = '';
        htmlLegend += '<div class="row legend pe-none mt-4 mb-0">';
        htmlLegend += '<div class="legend label">Available</div><div class="legendseat available mx-3 ms-1"></div>';
        htmlLegend += '<div class="legend label">Occupied</div><div class="legendseat occupied mx-3 ms-1"></div>';
        htmlLegend += '<div class="legend label">Suspended</div><div class="legendseat suspended mx-3 ms-1"></div>';
        htmlLegend += '</div>';

        document.getElementById('seatingLegend').innerHTML = htmlLegend;
        document.getElementById('seatingLayout').innerHTML = html;

        const seats = document.getElementsByClassName('seat');
        let selectedSeats = [];
        selectedSeats = selectedSeat !== '' ? [selectedSeat] : [];

        const selectedSeatsInput = document.getElementById('seatLocation');

        if (selectedSeat !== '') {
            selectedSeatsInput.value = selectedSeats.join(', ');
        }

        for (let i = 0; i < seats.length; i++) {
            seats[i].addEventListener('click', function(event) {
                const seatData = event.target.getAttribute('data-seat');
                const [row, seatNumber, status] = seatData.split(':');
                const seatId = row + seatNumber;

                const isSelected = selectedSeats.includes(seatId);
                if (isSelected) {
                    selectedSeats.splice(selectedSeats.indexOf(seatId), 1);
                    event.target.classList.remove('selected');
                    event.target.classList.add(status);
                } else {
                    selectedSeats.push(seatId);
                    event.target.classList.remove(status);
                    event.target.classList.add('selected');
                }
                
                selectedSeatsInput.value = selectedSeats.join(', ');
            });
        }
    }

    window.addEventListener('load', generateSeatingLayout);

</script>

</body>

</html>