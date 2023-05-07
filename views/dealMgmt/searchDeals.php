<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/deal_contr.php";

    $dc = new DealContr();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Manage F&B Items | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>
    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Manage Deals</h1>
                <div class="d-flex">
                    <form method="POST" action="../../controllers/deal_contr.php" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchText" name="searchText" placeholder="Search...">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Filter by</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" type="submit" name="filter" value="None"></button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="id">F&B Item ID</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="dealName">Name</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="price">Price</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="status">Status</button></li>
                            </ul>
                        </div>
                    </form>
                    <a href="createDeal.php" type="submit" class="btn btn-success bi bi-plus-lg fs-3 ms-4" title="Create Deal"></a>
                </div>
            </div>
            <table class="table table-hover text-white mt-4">
                <thead>
                    <tr>
                        <th>Deal ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th></th>
                    <tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($_SESSION['deals'] as $deal) { ?>
                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#view<?php echo $deal['id']; ?>">
                        <td><?php echo $deal['id']; ?></td>
                        <td><?php echo $deal['dealName']; ?></td>
                        <td>$<?php echo $deal['price']; ?></td>
                        <td><span class="<?php echo $deal['status'] == 'Available' ? 'badge bg-success' : 'badge bg-danger'; ?>"><?php echo $deal['status']; ?></span></td>
                        
                        <td class="d-flex justify-content-evenly">
                            <a href="updateDeal.php?dealId=<?php echo $deal['id']; ?>" type="submit" class="btn btn-outline-info bi bi-pencil fs-5" title="Edit Deal"></a>
                            <?php
                                if ($deal['status'] == 'Available') {
                                    echo '<button type="button" href="#" class="btn btn-danger bi bi-pause-fill fs-5" title="Suspend Deal" data-bs-toggle="modal" data-bs-target="#suspend' . $deal['id'] . '" onclick="event.stopPropagation();"></button>';
                                } else {
                                    echo '<a href="../../controllers/deal_contr.php?activateId=' . $deal["id"] . '" class="btn btn-success bi bi-play-fill fs-5" title="Activate Deal"></a>';
                                }
                            ?>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="suspend<?php echo $deal['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Suspend Deal</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Suspend the following deal?
                                <br/><br/>
                                <span>Deal ID </span>: <?php echo $deal['id']; ?><br/>
                                <span>Name </span> &nbsp;: <?php echo $deal['dealName']; ?><br/>
                            </div>
                            <div class="modal-footer">
                                <a href="../../controllers/deal_contr.php?suspendId=<?php echo $deal['id']; ?>" type="button" class="btn btn-danger">Yes</a>
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">No</button>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="view<?php echo $deal['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-100 w-75">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">View Deal</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                    <div class="col">
                                            <dl class="row">
                                                <dt class="col-sm-4">Deal ID</dt>
                                                <dd class="col-sm-8"><?php echo $deal['id']; ?></dd>

                                                <dt class="col-sm-4">Name</dt>
                                                <dd class="col-sm-8"><?php echo $deal['dealName']; ?></dd>

                                                <dt class="col-sm-4">Description</dt>
                                                <dd class="col-sm-8">
                                                    <p><?php echo $deal['description']; ?></p>
                                                </dd>

                                                <dt class="col-sm-4">Price</dt>
                                                <dd class="col-sm-8">$<?php echo $deal['price']; ?></dd>

                                                <dt class="col-sm-4">F&B items in deal:</dt>
                                                <dd class="col-sm-8">
                                                    <?php 
                                                        $fnbItems = $dc->getFnBItemInDeals($deal['id']);
                                                        echo "<ul>";
                                                        foreach($fnbItems as $item) {                                   
                                                            echo "<li>" . $item['itemName'] . "  x" . $item['COUNT(*)'] . "</li>";
                                                        } 
                                                        echo "</ul>";
                                                    ?>
                                                </dd>
                                                <dt class="col-sm-4">Status</dt>
                                                <dd class="col-sm-8">
                                                    <span class="<?php echo $deal['status'] == 'Available' ? 'badge bg-success' : 'badge bg-danger'; ?>"><?php echo $deal['status']; ?></span>
                                                </dd>
                                            </div>
                                            <div class="col">
                                                <div class=" d-flex justify-content-center">
                                                <?php
                                                    echo '<img src = "data:image/png;base64,' . $deal['image'] . '" style="width:auto;height:300px;"/>';?>
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