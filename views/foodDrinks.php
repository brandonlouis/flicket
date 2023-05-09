<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/fnbitem_contr.php";

    $fnbc = new FnBItemContr();
    $fnbitems = $fnbc->retrieveAllAvailableFnBItem();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">

 
    <title>F&B Items | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <span>
                <h1>F&B Items</h1>
                <p style="margin:0">Purchase your snacks & drinks before the show!</p>
            </span>
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
                        <li><button class="dropdown-item" type="submit" name="filter" value="status">Status</button></li>
                    </ul>
                </div>
            </form>
        </div>    
        <table class="table table-hover text-white mt-4">
                <thead>
                    <tr>
                        <th>F&B Item ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th></th>
                    <tr>
                </thead>
                <tbody class="align-middle">
                    <?php foreach ($fnbitems as $item) { ?>
                    <tr class="clickable-row" data-bs-toggle="modal" data-bs-target="#view<?php echo $item['id']; ?>">
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['itemName']; ?></td>
                        <td>$<?php echo $item['price']; ?></td>
                        <td><?php echo $item['category']; ?></td>
                        <td class="d-flex justify-content-evenly">
                            <a href="updateFnBItem.php?fnbItemId=<?php echo $item['id']; ?>" type="submit" class="btn btn-outline-info bi" title="Purchase F&B Item">Purchase</a>
                        </td>
                    </tr>
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
                                                <dt class="col-sm-4">F&B Item ID</dt>
                                                <dd class="col-sm-8"><?php echo $item['id']; ?></dd>

                                                <dt class="col-sm-4">Name</dt>
                                                <dd class="col-sm-8"><?php echo $item['itemName']; ?></dd>

                                                <dt class="col-sm-4">Description</dt>
                                                <dd class="col-sm-8">
                                                    <p><?php echo $item['description']; ?></p>
                                                </dd>

                                                <dt class="col-sm-4">Price</dt>
                                                <dd class="col-sm-8">$<?php echo $item['price']; ?></dd>

                                                <dt class="col-sm-4">Category</dt>
                                                <dd class="col-sm-8"><?php echo $item['category']; ?></dd>

                                                <dt class="col-sm-4">Deals included in:</dt>
                                                <dd class="col-sm-8">
                                                    <?php 
                                                        if($fnbc->checkFnBitemInDeal($item['id'])){
                                                            $deals = $fnbc->getFnBItemDeals($item['id']);
                                                            echo "<ul>";
                                                            foreach($deals as $deal) {                                   
                                                                echo "<li>" . $deal['dealName'] . "</li>";
                                                            } 
                                                            echo "</ul>";
                                                        } else {
                                                            echo "None";
                                                        }
                                                    ?>
                                                </dd>
                                                <dt class="col-sm-4">Status</dt>
                                                <dd class="col-sm-8">
                                                    <span class="<?php echo $item['status'] == 'Available' ? 'badge bg-success' : 'badge bg-danger'; ?>"><?php echo $item['status']; ?></span>
                                                </dd>


                                            </div>
                                            <div class="col">
                                                <div class=" d-flex justify-content-center">
                                                    <?php echo '<img src = "data:image/png;base64,' . $item['image'] . '" style="width:auto;height:300px;"/>'; ?>
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


    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js" integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/footer.php';
    ?>
</body>

</html>