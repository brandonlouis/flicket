<?php
    session_start();
    if (!isset($_SESSION['email']) || $_SESSION['userType'] !== 'cinemaManager') { // Check if logged in and if user is admin
        header('Location: ../../index.php');
        exit;
    }

    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/deal_contr.php";
    include $_SERVER['DOCUMENT_ROOT'] . "/flicket/controllers/fnbitem_contr.php";
    $dc = new DealContr();
    $fnbc = new FnBItemContr();
    $fnbItems = $fnbc->retrieveAllFnBitems();
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/flicket/css/style.css">

 
    <title>Create Deal | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../controllers/deal_contr.php" enctype="multipart/form-data" class="w-50">
                <h1>Deal Details</h1>
                <div class="input-group mt-4" title="Name">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="text" class="form-control" id="dealName" name="dealName" placeholder="Name" required>
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
                    <input type="number" class="form-control" min="0" step="0.01" id="price" name="price" placeholder="Price (e.g. 12.99)" required>
                </div>
                <div class="input-group mt-3" title="F&B Items included in the deal">
                    <span class="input-group-text">
                        <i class="bi bi-bag-check"></i>
                    </span>
                    <input type="text" class="form-control bg-dark-subtle pe-none" id="fnbItem" name="fnbItem" placeholder='Select F&B items (select using dropdown)' required onkeydown="return false;">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">F&B Items</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item fnbItem-btn" type="button" data-value="reset"><b>Reset</b></button></li>
                        <?php foreach ($fnbItems as $item) { ?>
                        <li><button class="dropdown-item fnbItem-btn" type="button" data-value="<?php echo $item['itemName']; ?>"><?php echo $item['itemName']; ?></button></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="input-group mt-3" title="Status">
                    <span class="input-group-text">
                        <i class="bi bi-gear"></i>
                    </span>
                    <select class="form-select" id="status" name="status" aria-label="Default select">
                        <option hidden>Select a status for the Deal</option>
                        <option value="Available">Available</option>
                        <option value="Suspended">Suspended</option>
                    </select>
                </div>
        
                <div class="mt-4">
                    <label for="imgFile" class="form-label">Upload Deal Image (Maximum size: 2MB)</label>
                    <input type="file" class="form-control" id="imgFile" name="imgFile" onchange="previewImage()" accept="image/*" required>
                </div>
                <div class="d-flex">
                    <button type="submit" name="createDeal" class="btn btn-danger my-4 me-3">Create deal</button>
                    <a href="manageDeals.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
            </form>
            <div style="width:45%" class="d-flex justify-content-end">
                <img id="img" src="" alt="Preview" style="display:none;width:auto;height:550px;max-width:-webkit-fill-available;">
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
    const fnbItemBtns = document.querySelectorAll('.fnbItem-btn');
    const fnbItemInput = document.querySelector('#fnbItem');

    fnbItemBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const value = btn.getAttribute('data-value');
            if (value === "reset") {
                fnbItemInput.value = "";
            return;
            }
            fnbItemInput.value += (fnbItemInput.value ? ', ' : '') + value;
        });
    });

    function previewImage() {
        const input = document.getElementById("imgFile");
        const file = input.files[0];

        if (file.size > 2097152) {
            alert('File size should be less than 2MB');
            input.value = "";
            previewImg.style.display = "none";
        } else {
            const reader = new FileReader();
            const previewImg = document.getElementById("img");

            reader.onload = function (event) {
                previewImg.src = event.target.result;
                previewImg.style.display = "block";
            };

            reader.readAsDataURL(file);
        }


    }


</script>

</body>

</html>