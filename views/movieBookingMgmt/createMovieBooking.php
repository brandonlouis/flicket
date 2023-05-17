<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/movie/manageMovie_contr.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/ticketType/manageTicketType_contr.php";
    include $_SERVER['DOCUMENT_ROOT'] . '/flicket/controllers/seat/manageSeat_contr.php';

    $mmc = new ManageMovieContr();
    $movieDetails = $mmc->retrieveOneMovie($_GET['movieId']);

    $ttc = new ManageTicketTypeContr();
    $ticketTypes = $ttc->retrieveAllTicketTypes();

    $shc = new ManageSeatContr();
    $hallDetails = $shc->retrieveAllSeats($_GET['hallId']);
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Book Movie | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div style="width:45%" class="d-flex">
            <img src="data:image/png;base64,<?php echo $movieDetails['poster']; ?>" style="width:-webkit-fill-available;position:absolute;z-index:-1;opacity:0.15;clip-path:inset(0 0 50% 0);left:0;right:0;" alt="<?php echo $movies[$random_number]['title'] ?>">
        </div>  
        <div class="content d-flex justify-content-evenly align-items-center mt-5">
            <form method="POST" action="../../controllers/bookmovie/createMovieBooking_contr.php?hallId=<?php echo $_GET['hallId'] ?>&sessionId=<?php echo $_GET['sessionId'] ?>" enctype="multipart/form-data" class="w-50">  
                <h1><?php echo $movieDetails['title']?></h1>
                <p><?php echo $movieDetails['synopsis']?></p>
                <p>Runtime: <?php echo $movieDetails['runtimeMin'] ?> mins</p>
                
                <div class="input-group mt-3" title="Seat number">
                    <span class="input-group-text">
                        <i class="bi bi-ui-checks-grid"></i>
                    </span>
                    <input type="text" class="form-control bg-dark-subtle pe-none" id="seatLocation" name="seatLocation" placeholder="Select a seat from the diagram" required onkeydown="return false;">
                </div>
                <div class="input-group mt-3" title="Ticket Type">
                    <span class="input-group-text">
                        <i class="bi bi-ticket-perforated"></i>
                    </span>
                    <select class="form-select" id="ticketType" name="ticketType" aria-label="Default select">
                        <?php
                        $subsetTicketTypes = explode(', ', $movieDetails['ticketTypes']);
                        foreach ($ticketTypes as $ticketType) {
                            if (in_array($ticketType['name'], $subsetTicketTypes)) { ?>
                            <option value="<?php echo $ticketType['name'] . '|' . $ticketType['price']; ?>" selected>
                                <?php echo $optionLabel = $ticketType['name']; ?> | $<?php echo $ticketType['price']; ?>
                            </option>
                        <?php
                            }
                        } ?>
                    </select>
                </div>
                <div class="input-group mt-3" title="Seat number">
                    <span class="input-group-text">
                        <i class="bi bi-currency-dollar"></i>
                    </span>
                    <input type="text" class="form-control bg-dark-subtle pe-none" id="totalPrice" name="totalPrice" placeholder="Total Price" required onkeydown="return false;">
                </div>

                <div class="d-flex">
                    <button type="submit" name="createMovieBooking" class="btn btn-danger my-4 me-3">Book movie</button>
                    <a href="../movies.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
            </form>
            <div class="d-flex justify-content-center flex-column align-items-center">
                <div id="seatingLayout"></div>
                    <div id="seatingLegend">
                        <div class="row legend pe-none mt-4 mb-0">
                            <div class="legend label">Available</div><div class="seat available mx-3 ms-1"></div>
                            <div class="legend label">Occupied</div><div class="seat occupied mx-3 ms-1"></div>
                            <div class="legend label">Suspended</div><div class="seat suspended mx-3 ms-1"></div>
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
            if (status === 'Available') {
                seatClass = 'available';
            } else if (status === 'Occupied') {
                seatClass = 'pe-none occupied';
            } else if (status === 'Suspended') {
                seatClass = 'pe-none suspended';
            }

            html += '<div class="seat ' + seatClass + '" data-seat="' + seat + '">' + seatNumber + '</div>';
        }

        if (currentRow !== '') {
            html += '</div>';
        }

        let htmlLegend = '';
        htmlLegend += '<div class="row legend pe-none mt-4 mb-0">';
        htmlLegend += '<div class="legend label">Available</div><div class="seat available mx-3 ms-1"></div>';
        htmlLegend += '<div class="legend label">Occupied</div><div class="seat occupied mx-3 ms-1"></div>';
        htmlLegend += '<div class="legend label">Suspended</div><div class="seat suspended mx-3 ms-1"></div>';
        htmlLegend += '</div>';

        document.getElementById('seatingLegend').innerHTML = htmlLegend;
        document.getElementById('seatingLayout').innerHTML = html;

        const seats = document.getElementsByClassName('seat');
        let selectedSeats = [];

        const selectedSeatsInput = document.getElementById('seatLocation');

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
                selectedSeatsInput.dispatchEvent(new Event('change'));
            });
        }
    }

    window.addEventListener('load', generateSeatingLayout);


    const seatLocationInput = document.getElementById("seatLocation");
    const ticketTypeSelect = document.getElementById("ticketType");
    const totalPriceInput = document.getElementById("totalPrice");

    seatLocationInput.addEventListener('change', calculateTotalPrice);

    function calculateTotalPrice() {
        const seatLocation = seatLocationInput.value;
        const ticketTypePrice = parseFloat(getSelectedTicketTypePrice());
        const numSeats = seatLocation.split(', ').length;
        const totalPrice = ticketTypePrice * numSeats;

        totalPriceInput.value = totalPrice.toFixed(2);
    }

    function getSelectedTicketTypePrice() {
        const selectedOption = ticketTypeSelect.options[ticketTypeSelect.selectedIndex];
        const priceString = selectedOption.value.split('|')[1].trim();
        return parseFloat(priceString);
    }

</script>

</body>

</html>