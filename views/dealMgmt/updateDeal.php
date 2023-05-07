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
    $dealDetails = $dc->retrieveOneDeal($_GET['dealId']);
    $chosenFnBItems = $dc->getFnBItemInDeals($_GET['dealId']);
    $itemNameArr = array();
    foreach($chosenFnBItems as $item){
        for($i = 0; $i < intval($item['COUNT(*)']); $i++) {
            $itemNameArr[] = $item['itemName'];
        }
    }
    $chosenFnBitemsString = implode(', ', $itemNameArr);
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

 
    <title>Update Deal | flicket</title>
    <link rel="icon" type="image/x-icon" href="/flicket/img/favicon.ico">
</head>

<body class="d-flex flex-column h-100">
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/flicket/templates/header.php';
    ?>

    <div class="container mt-4" style="margin-bottom: 80px">
        <div class="content d-flex justify-content-evenly align-items-center">
            <form method="POST" action="../../controllers/deal_contr.php?dealId=<?php echo $dealDetails['id'];?>"" enctype="multipart/form-data" class="w-50">
                <h1>Deal Details</h1>
                <div class="input-group mt-4">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="text" class="form-control" id="dealName" name="dealName" placeholder="Name" value="<?php echo $dealDetails['dealName'];?>" required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-book"></i>
                    </span>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Description" id="description" name="description" style="height: 100px" required><?php echo $dealDetails['description'];?></textarea>
                        <label class="text-secondary" for="synopsis">Description</label>
                    </div>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="number" class="form-control" min="0" step="any" id="price" name="price" placeholder=0 value="<?php echo $dealDetails['price'];?>"required>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <select class="form-select" id="suspendStatus" name="suspendStatus" aria-label="Default select">
                            <option value="0" <?php if($dealDetails['suspendStatus']=='0'){echo "selected";} ?>>Not Suspended</option>
                            <option value="1" <?php if($dealDetails['suspendStatus']=='1'){echo "selected";} ?>>Suspended</option>
                    </select>
                </div>
                <div class="input-group mt-3">
                    <span class="input-group-text">
                        <i class="bi bi-card-heading"></i>
                    </span>
                    <input type="text" class="form-control bg-dark-subtle" id="fnbItem" name="fnbItem" 
                    value="<?php echo $chosenFnBitemsString; ?>"
                    placeholder='F&B items (select using dropdown)' required onclick="this.blur();" onkeydown="return false;">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">F&B Items</button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><button class="dropdown-item fnbItem-btn" type="button" data-value="reset"><b>Reset</b></button></li>
                        <?php foreach ($fnbItems as $item) { ?>
                        <li><button class="dropdown-item fnbItem-btn" type="button" data-value="<?php echo $item['itemName']; ?>"><?php echo $item['itemName']; ?></button></li>
                        <?php } ?>
                    </ul>
                </div>

        
                <div class="mt-4">
                    <label for="imgFile" class="form-label">Upload Deal Image (Maximum size: 2MB)</label>
                    <input type="file" class="form-control" id="imgFile" name="imgFile" onchange="previewImage()" accept="image/*">
                </div>
                <div class="d-flex">
                    <button type="submit" name="updateDeal" class="btn btn-danger my-4 me-3">Update deal</button>
                    <a href="manageDeals.php" class="btn btn-outline-info my-4">Cancel</a>
                </div>
            </form>
            <div style="width:45%">
                <img id="img" src="" alt="Preview" style="display:none;width:-webkit-fill-available;height:-webkit-fill-available">
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