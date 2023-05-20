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

 
    <title>Food & Drinks | flicket</title>
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
                    <div class="modal-dialog modal-dialog-centered" style="max-width:600px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">F&B Item Details</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-4">
                                <div class="container d-flex">
                                    <div>
                                        <?php echo '<img src = "data:image/png;base64,' . $item['image'] . '" style="width:auto;height:300px;"/>'; ?>
                                    </div>
                                    <div class="ms-5 d-flex flex-column justify-content-evenly">
                                        <div>
                                            <p class="card-text text-white" style="width: fit-content;padding: 2px 10px;background-color: #d74545;border-radius: 15px;">$<?php echo $item['price']; ?></p>
                                            <h2><?php echo $item['itemName']; ?></h2>
                                            <p><?php echo $item['description']; ?></p>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-around">
                                            <div class="w-25">
                                                <p class="mt-4 mb-1">Quantity:</p>
                                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                                            </div>
                                            <?php if (isset($_SESSION['email'])) {?>
                                                <a type="submit" data-bs-toggle="modal" data-bs-target="#purchase<?php echo $item['id']; ?>" class="btn btn-danger bi d-flex justify-content-center w-50" title="Purchase F&B Item">Purchase</a>
                                            <?php } else { ?>
                                                <a href="login.php" type="button" class="btn btn-danger">Login to purchase</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="purchase<?php echo $item['id']; ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:500px;">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Purchase Payment</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body pb-5 px-4">
                                <div class="container d-flex">
                                    <div class="w-100 d-flex flex-column justify-content-evenly">
                                        <div>
                                            <form method="POST" action="../controllers/fnbitem/purchaseFnBItem_contr.php?fnbItemId=<?php echo $item['id'];?>">
                                                <div class="d-flex">
                                                    <div class="w-75">
                                                        <label>Cardholder</label>
                                                        <input type="text" class="form-control" pattern="[a-zA-Z\s]*" placeholder="Full Name" required>
                                                    </div>
                                                    <div class="w-25">
                                                        <label>CVV</label>
                                                        <input type="text" class="form-control" placeholder="***" pattern="[0-9]{3,4}" required>
                                                    </div>
                                                </div>
                                                <div class="my-2">
                                                    <label>Card Number</label>
                                                    <input type="text" class="form-control" placeholder="0000 0000 0000 0000" required>
                                                </div>
                                                
                                                <label>Expiration Date</label>
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <div class="d-flex w-50">
                                                    <select class="form-select" aria-label="Default select">
                                                        <option value="01">January</option>
                                                        <option value="02">February </option>
                                                        <option value="03">March</option>
                                                        <option value="04">April</option>
                                                        <option value="05">May</option>
                                                        <option value="06">June</option>
                                                        <option value="07">July</option>
                                                        <option value="08">August</option>
                                                        <option value="09">September</option>
                                                        <option value="10">October</option>
                                                        <option value="11">November</option>
                                                        <option value="12">December</option>
                                                    </select>
                                                    <select class="form-select" aria-label="Default select">
                                                        <option value="23"> 2023</option>
                                                        <option value="24"> 2024</option>
                                                        <option value="25"> 2025</option>
                                                        <option value="26"> 2026</option>
                                                        <option value="27"> 2027</option>
                                                        <option value="28"> 2028</option>
                                                    </select>
                                                    </div>

                                                    <div>
                                                        <img src="../img/visa.png">
                                                        <img src="../img/mastercard.png">
                                                        <img src="../img/amex.png">
                                                    </div>
                                                </div>
                                                <button type="submit" name="purchaseFnBItem" class="btn btn-danger mt-4 w-100">Confirm purchase</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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


<script>
    const quantityInputs = document.querySelectorAll("#quantity");

    for (let i = 0; i < quantityInputs.length; i++) {
        const quantityInput = quantityInputs[i];

        quantityInput.addEventListener('input', function() {
            if (quantityInput.value < 1) {
                quantityInput.value = 1;
            }
        });
    }
</script>

</body>

</html>