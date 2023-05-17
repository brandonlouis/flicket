<?php
    session_start();

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/classes/dbh_classes.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/fnbitem/manageFnBItem_contr.php";

    $fnbc = new ManageFnBItemContr();
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
        </div> 
        <div class="content" style="display:grid; grid-template-columns: repeat(4, 1fr); justify-items:center;">
            <?php foreach ($fnbitems as $item) { ?>
                <a href="#" class="text-decoration-none border-0 mb-5" style="width: 17rem;" data-bs-toggle="modal" data-bs-target="#view<?php echo $item['id']; ?>">
                    <img src="data:image/png;base64,<?php echo $item['image']; ?>" class="card-img-top mb-3" style="height:400px; object-fit:cover;" alt="<?php echo $item['itemName'] ?>">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title text-white mb-2"><?php echo $item['itemName'] ?></h5>
                        <div class="d-flex justify-content-between">
                            <p class="card-text text-white" style="font-size:12px;width: fit-content;padding: 2px 10px;background-color: #d74545;border-radius: 15px;">$<?php echo $item['price'] ?></p>
                            <p class="card-text text-white-50" style="font-size:12px;"><?php echo $item['category'] ?></p>
                        </div>
                    </div>
                </a>

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

                                            <div class="d-flex mt-5">
                                                <a type="submit" data-bs-toggle="modal" data-bs-target="#purchase<?php echo $item['id']; ?>" class="btn btn-danger bi d-flex justify-content-center" title="Purchase F&B Item">Purchase</a>
                                            </div>

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

                <div class="modal fade" id="purchase<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered mw-100 w-75">
                        <form method="POST" action="../controllers/fnbitem/purchaseFnBItem_contr.php?fnbItemId=<?php echo $item['id'];?>">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Purchase <?php echo $item['itemName'];?></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row">
                                        <div class="col">
                                            <dl class="row">
                                                <dt class="col-sm-4">Item Name</dt>
                                                <dd class="col-sm-8"><?php echo $item['itemName']; ?></dd>

                                                <dt class="col-sm-4">Description</dt>
                                                <dd class="col-sm-8">
                                                    <p><?php echo $item['description']; ?></p>
                                                </dd>

                                                <dt class="col-sm-4">Price</dt>
                                                <dd class="col-sm-8">$<?php echo $item['price']; ?></dd>

                                                <dt class="col-sm-4 mt-5">Name</dt>
                                                <dd class="col-sm-8 mt-5">
                                                    <input type="text" class="form-control" id="buyerName" name="buyerName" pattern="[a-zA-Z\s]*" placeholder="Full Name" required>
                                                </dd>
                                                <dt class="col-sm-4">Email Address</dt>
                                                <dd class="col-sm-8">
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                                </dd>
                                                <dt class="col-sm-4">Quantity</dt>
                                                <dd class="col-sm-8">
                                                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" min="1" value="1" required>
                                                </dd>
                                                <div class="d-flex">
                                                    <button style="position:absolute;bottom:2rem;" type="submit" name="purchaseFnBItem" class="btn btn-danger mt-5">Confirm Purchase</button>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class=" d-flex justify-content-center">
                                                    <?php echo '<img src = "data:image/png;base64,' . $item['image'] . '" style="width:auto;height:500px;"/>'; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            <?php } ?>
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