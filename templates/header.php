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
                <a class="nav-item nav-link <?php if ($_SERVER['REQUEST_URI'] == '/flicket/views/movies.php') echo 'active'; ?>" id="movies" href="/flicket/views/movies.php">Movies</a>
            </li>
            <li class="nav-item">
                <a class="nav-item nav-link <?php if ($_SERVER['REQUEST_URI'] == '/flicket/views/foodDrinks.php') echo 'active'; ?>" id="foodDrinks" href="/flicket/views/foodDrinks.php">Food & Drinks</a>
            </li>
        </ul>
        <?php
            if (isset($_SESSION['userType'])) {
                // user is logged in
                echo '<div class="dropdown">
                        <img class="btn btn-link dropdown-toggle p-0" src="/flicket/img/avatar.png" width="40px" alt="dropdown image" id="dropdownMenuButton1" data-bs-toggle="dropdown">
                        <ul class="dropdown-menu dropdown-menu-end">
                            ';
                if ($_SESSION['userType'] == "userAdmin") {
                    echo '<li><a class="dropdown-item" href="/flicket/views/account/manageAccounts.php">Manage Accounts</a></li>
                        <li><a class="dropdown-item" href="/flicket/views/profile/manageProfiles.php">Manage Profiles</a></li>';
                } elseif ($_SESSION['userType'] == "cinemaManager") {
                    echo '<li><a class="dropdown-item" href="/flicket/views/movieMgmt/manageMovies.php">Manage Movies</a></li>
                        <li><a class="dropdown-item" href="/flicket/views/sessionMgmt/manageSessions.php">Manage Sessions</a></li>
                        <li><a class="dropdown-item" href="/flicket/views/cinemaHallsMgmt/manageCinemaHalls.php">Manage Cinema Halls</a></li>
                        <li><a class="dropdown-item" href="/flicket/views/seat/manageSeats.php">Manage Seats</a></li>
                        <li><a class="dropdown-item" href="/flicket/views/ticketType/manageTicketTypes.php">Manage Ticket Types</a></li>
                        <li><a class="dropdown-item" href="/flicket/views/fnbItemMgmt/manageFnBitems.php">Manage F&B Items</a></li>';
                } elseif ($_SESSION['userType'] == 'cinemaOwner') {
                    echo '<li><a class="dropdown-item" href="/flicket/views/ticketSalesReport/genTicketSalesReport.php">Ticket Sales Report</a></li>
                    <li><a class="dropdown-item" href="/flicket/views/cinemaUtilReport/genCinemaUtilReport.php">Cinema Utilization Report</a></li>';
                } else {
                    echo '<li><a class="dropdown-item" href="#">Profile</a></li>';
                }
                // logout & suspend button
                echo '<li><a class="dropdown-item" href="/flicket/controllers/logout_contr.php">Logout</a></li>';

                if ($_SESSION['userType'] == "customer") {
                        echo '<li><a class="dropdown-item" href="/flicket/views/movieBookingMgmt/manageMovieBooking.php">Manage Bookings</a></li>
                            <li><a class="dropdown-item mt-3" name="deleteAccount" data-bs-toggle="modal" data-bs-target="#deleteConfirmation">Delete Account</a></li>
                        </ul>
                    </div>';
                }
            } else {
                // user is not logged in
                echo '<a href="/flicket/views/login.php" class="btn btn-danger">Login</a>';
            }
        ?>

        <div class="modal fade" id="deleteConfirmation" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-75 w-75">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Delete Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to <b>permanently</b> delete your account?
                    </div>
                    <div class="modal-footer">
                        <a href="/flicket/controllers/account/deleteAccount_contr.php?deleteId=<?php echo $_SESSION['id']; ?>" type="button" class="btn btn-danger">Yes</a>
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>