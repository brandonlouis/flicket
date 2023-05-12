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

 
    <title>Create Ticket Type | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../controllers/tickettype/createTicketType_contr.php" class="w-50">
                <h1>Ticket Type Details</h1>
                <div class="input-group mt-4">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                </div>
                <div class="input-group mt-3" title="Description">
                    <span class="input-group-text">
                        <i class="bi bi-card-text"></i>
                    </span>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 100px" required></textarea>
                        <label class="text-secondary" for="description">Description</label>
                    </div>
                </div>
                <div class="input-group mt-3" title="Price">
                    <span class="input-group-text">
                        <i class="bi bi-currency-dollar"></i>
                    </span>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Price (e.g. 19.99)" pattern="^\d{1,4}(?:\.\d{1,2})?$" step="0.01" min="0" max="999.99" required>
                </div>
                <div class="d-flex">
                    <button type="submit" name="createTicketType" class="btn btn-danger my-4 me-3">Create ticket type</button>
                    <a href="manageTicketTypes.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
            </form>
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