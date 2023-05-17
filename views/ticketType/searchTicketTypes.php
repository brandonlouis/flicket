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

 
    <title>Search Ticket Types | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Manage Ticket Types</h1>

                <div class="d-flex">
                    <form method="POST" action="../../controllers/tickettype/searchTicketType_contr.php" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchText" name="searchText" placeholder="Search...">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Filter by</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" type="submit" name="filter" value="None"></button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="id">Ticket Type ID</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="name">Name</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="description">Description</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="price">Price</button></li>
                            </ul>
                        </div>
                    </form>
                    <a href="createTicketType.php" type="submit" class="btn btn-success bi bi-plus-lg fs-3 ms-4" title="Create Ticket Type"></a>
                </div>
            </div>
            <table class="table table-hover text-white mt-4">
                <thead>
                    <tr>
                        <th>Ticket Type ID</th>
                        <th>Name</th>
                        <th class="w-50">Description</th>
                        <th>Price</th>
                        <th></th>
                    <tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($_SESSION['ticketTypes'] as $ticketType) { ?>
                    <tr>
                        <td><?php echo $ticketType['id']; ?></td>
                        <td title="<?php echo $ticketType['name']; ?>"><?php echo $ticketType['name']; ?></td>
                        <td title="<?php echo $ticketType['description']; ?>"><?php echo $ticketType['description']; ?></td>
                        <td>$<?php echo $ticketType['price']; ?></td>

                        <td class="d-flex justify-content-evenly">
                            <a href="updateTicketType.php?ticketTypeId=<?php echo $ticketType['id']; ?>" type="submit" class="btn btn-outline-info bi bi-pencil fs-5" title="Edit Ticket Type"></a>
                            <button type="button" href="#" class="btn btn-danger bi bi-trash fs-5" title="Delete Ticket Type" data-bs-toggle="modal" data-bs-target="#delete<?php echo $ticketType['id']; ?>"></button>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="delete<?php echo $ticketType['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Delete Ticket Type</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Permanently delete the following ticket type?
                                <br/><br/>
                                <span>Ticket Type ID </span>: <?php echo $ticketType['id']; ?><br/>
                                <span>Name </span> &nbsp;: <?php echo $ticketType['name']; ?><br/>
                            </div>
                            <div class="modal-footer">
                                <a href="../../controllers/tickettype/deleteTicketType_contr.php?deleteId=<?php echo $ticketType['id']; ?>" type="button" class="btn btn-danger">Yes</a>
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