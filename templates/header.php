<?php if (isset($_COOKIE['flash_message'])) : ?>
<div class="alert alert-<?php echo $_COOKIE['flash_message_type']; ?> alert-dismissible fade show my-0 w-100" role="alert">
    <?php echo $_COOKIE['flash_message']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php setcookie('flash_message', '', time() - 3600, '/'); ?>
<?php setcookie('flash_message_type', '', time() - 3600, '/'); ?>
<?php endif; ?>


<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="/flicket/index.php"><img src="/flicket/img/flicket.png" height="30"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="navbar-nav me-auto">
            <li class="nav-item">
                <a class="nav-item nav-link <?php if ($_SERVER['REQUEST_URI'] == '/flicket/index.php') echo 'active'; ?>" id="home" href="/flicket/index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link <?php if ($_SERVER['REQUEST_URI'] == '/flicket/views/movies.php') echo 'active'; ?>" id="movies" href="/movies">Movies</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link <?php if ($_SERVER['REQUEST_URI'] == '/flicket/views/foodDrinks.php') echo 'active'; ?>" id="foodDrinks" href="/foodDrinks">Food & Drinks</a>
            </li>
        </ul>
        
        <?php
            if (isset($_SESSION['userType'])) {
                if ($_SESSION['userType'] == "userAdmin") {
                    echo '<div class="dropdown">
                            <img class="btn btn-link dropdown-toggle p-0" src="/flicket/img/avatar.png" width="40px" alt="dropdown image" id="dropdownMenuButton1" data-bs-toggle="dropdown">
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/">Profile</a></li>
                                <li><a class="dropdown-item" href="/flicket/views/manageAccounts.php">Manage Accounts</a></li>
                                <li><a class="dropdown-item" href="">Manage Profiles</a></li>
                                <li><a class="dropdown-item" href="/flicket/includes/logout_inc.php">Logout</a></li>
                            </ul>
                        </div>';
                } else {
                    echo '<div class="dropdown">
                            <img class="btn btn-link dropdown-toggle p-0" src="/flicket/img/avatar.png" width="40px" alt="dropdown image" id="dropdownMenuButton1" data-bs-toggle="dropdown">
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="/">Profile</a></li>
                                <li><a class="dropdown-item" href="/flicket/includes/logout_inc.php">Logout</a></li>
                            </ul>
                        </div>';
                }
            } else {
                echo '<a href="views/login.php" class="btn btn-danger">Login</a>';
            }
        ?>
    </div>
</nav>