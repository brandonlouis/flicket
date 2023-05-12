<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/fnbitem/manageFnBItem_contr.php";

    $fnbc = new ManageFnBItemContr();
    $fnbItemDetails = $fnbc->retrieveOneFnBItem($_GET['fnbItemId']);
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Create F&B Item | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../controllers/fnbitem/updateFnBItem_contr.php?fnbItemId=<?php echo $fnbItemDetails['id'];?>" enctype="multipart/form-data" class="w-50">
                <h1>F&B Item Details</h1>
                <div class="input-group mt-4" title="Name">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="text" class="form-control" id="itemName" name="itemName" placeholder="Name" value="<?php echo $fnbItemDetails['itemName'];?>" required>
                </div>
                <div class="input-group mt-3" title="Description">
                    <span class="input-group-text">
                        <i class="bi bi-card-text"></i>
                    </span>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 100px" required><?php echo $fnbItemDetails['description'];?></textarea>
                        <label class="text-secondary" for="synopsis">Description</label>
                    </div>
                </div>
                <div class="input-group mt-3" title="Price">
                    <span class="input-group-text">
                        <i class="bi bi-currency-dollar"></i>
                    </span>
                    <input type="number" class="form-control" min="0" step="0.01" id="price" name="price" placeholder="Price (e.g. 4.99)" value="<?php echo $fnbItemDetails['price'];?>" required>
                </div>
                <div class="input-group mt-3" title="Category">
                    <span class="input-group-text">
                        <i class="bi bi-tag"></i>
                    </span>
                    <select class="form-select" id="category" name="category" aria-label="Default select">
                        <option value="Food" <?php echo $fnbItemDetails['category'] == 'Food' ? 'selected' : ''; ?>>Food</option>
                        <option value="Drink" <?php echo $fnbItemDetails['category'] == 'Drink' ? 'selected' : ''; ?>>Drink</option>
                    </select>
                </div>
        
                <div class="mt-4">
                    <label for="imgFile" class="form-label">Upload F&B Item Image (Maximum size: 2MB)</label>
                    <input type="file" class="form-control" id="imgFile" name="imgFile" onchange="previewImg()" accept="image/*">
                </div>
                <div class="d-flex">
                    <button type="submit" name="updateFnBItem" class="btn btn-danger my-4 me-3">Update F&B item</button>
                    <a href="manageFnBItems.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
            </form>
            <div style="width:45%" class="d-flex justify-content-center">
                <?php echo '<img src = "data:image/png;base64,' . $fnbItemDetails['image'] . '" style="width:auto;height:550px;max-width:-webkit-fill-available;" id="img"/>'; ?>
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

function previewImg() {
        const fileInput = document.getElementById('imgFile');
        const file = fileInput.files[0];
        
        if (file && file.size > 2097152) {
            alert('File size should be less than 2MB');
            fileInput.value = '';
        } else {
            const previewImg = document.getElementById('img');
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                previewImg.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    }


</script>

</body>

</html>