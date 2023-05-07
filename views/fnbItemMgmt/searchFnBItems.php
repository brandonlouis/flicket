<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/fnbitem_contr.php";

    $fnbc = new FnBItemContr();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Search F&B Items | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Manage F&B Items</h1>
                
                <div class="d-flex">
                    <form method="POST" action="../../controllers/fnbitem_contr.php" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchText" name="searchText" placeholder="Search...">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Filter by</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><button class="dropdown-item" type="submit" name="filter" value="None"></button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="id">F&B Item ID</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="itemName">Name</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="price">Price</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="category">Category</button></li>
                                <li><button class="dropdown-item" type="submit" name="filter" value="suspendStatus">Suspend Status</button></li>
                            </ul>
                        </div>
                    </form>
                    <a href="createFnBItem.php" type="submit" class="btn btn-success bi bi-plus-lg fs-3 ms-4" title="Create Movie Session"></a>
                </div>
            </div>
            
            <table class="table table-hover text-white mt-4">
                <thead>
                    <tr>
                        <th>F&B Item ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Suspend Status</th>
                        <th></th>
                    <tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($_SESSION['fnbItems'] as $item) { ?>
                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#view<?php echo $item['id']; ?>">
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['itemName']; ?></td>
                        <td><?php echo $item['price']; ?></td>
                        <td><?php echo $item['category']; ?></td>
                        <?php if($item['suspendStatus'] == 0) : ?>
                            <td><span class="badge bg-success">Not Suspended</span></td>
                        <?php else: ?>
                            <td><span class="badge bg-danger">Suspended</span></td>
                        <?php endif; ?>
                        
                        <td class="d-flex justify-content-evenly">
                            <a href="updateFnBItem.php?fnbItemId=<?php echo $item['id']; ?>" type="submit" class="btn btn-outline-info bi bi-pencil fs-5" title="Edit F&B Item"></a>
                            <button type="button" href="#" class="btn btn-danger bi bi-trash fs-5" title="Delete F&B Item" data-bs-toggle="modal" data-bs-target="#delete<?php echo $item['id']; ?>"></button>
                        </td>
                    </tr>
                    
                    <div class="modal fade" id="delete<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Delete F&B item</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Permanently delete the following F&B item?
                                <br/><br/>
                                <span>F&B Item ID </span>: <?php echo $item['id']; ?><br/>
                                <span>Name </span> &nbsp;: <?php echo $item['itemName']; ?><br/>
                                <?php 
                                    if($fnbc->checkFnBitemInDeal($item['id'])){
                                        echo "<span>Deals included in </span>: ";
                                        $deals = $fnbc->getFnBItemDeals($item['id']);
                                        echo "<ul>";
                                        foreach($deals as $deal) {                                   
                                            echo "<li>" . $deal['dealName'] . "</li>";
                                        } 
                                        echo "</ul>";
                                        echo "<p class='text-danger'>Warning: If deleted, the associated deals will be deleted as well</p>";
                                    } 
                                ?> 
                                <br/>
                            </div>
                            <div class="modal-footer">
                                <a href="../../controllers/fnbitem_contr.php?deleteId=<?php echo $item['id']; ?>" type="button" class="btn btn-danger">Yes</a>
                                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">No</button>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="view<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered mw-100 w-75">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">View F&B Item</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                        <dl class="row">
                                            <dt class="col-sm-3">F&B Item ID</dt>
                                            <dd class="col-sm-9 mb-5"><?php echo $item['id']; ?></dd>

                                            <dt class="col-sm-3">Name</dt>
                                            <dd class="col-sm-9 mb-5"><?php echo $item['itemName']; ?></dd>

                                            <dt class="col-sm-3">Description</dt>
                                            <dd class="col-sm-9 mb-5">
                                                <p><?php echo $item['description']; ?></p>
                                            </dd>

                                            <dt class="col-sm-3">Price</dt>
                                            <dd class="col-sm-9 mb-5">$<?php echo $item['price']; ?></dd>

                                            <dt class="col-sm-3">Category</dt>
                                            <dd class="col-sm-9 mb-5"><?php echo $item['category']; ?></dd>

                                            <dt class="col-sm-3">Suspend Status</dt>
                                            <dd class="col-sm-9 mb-5">
                                                <?php if ($item['suspendStatus'] == 0) : ?>
                                                    <span class="badge bg-success">Not Suspended</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Suspended</span>
                                                <?php endif; ?>
                                            </dd>

                                            <dt class="col-sm-3">Deals included in</dt>
                                            <dd class="col-sm-9 mb-5">
                                                <?php 
                                                    if($fnbc->checkFnBitemInDeal($item['id'])){
                                                        $deals = $fnbc->getFnBItemDeals($item['id']);
                                                        echo "<ul>";
                                                        foreach($deals as $deal) {                                   
                                                            echo "<li>" . $deal['dealName'] . "</li>";
                                                        } 
                                                        echo "</ul>";
                                                    } else {
                                                        echo "Not in any deals";
                                                    }
                                                ?>
                                            </dd>
                                            
                                        </div>
                                        <div class="col">
                                            <div class=" d-flex justify-content-center">
                                            <?php
                                                echo '<img src = "data:image/png;base64,' . base64_encode($item['image']) . '" style="width:100%"/>';?>
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