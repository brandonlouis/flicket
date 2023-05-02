<?php

session_start();
session_unset();
session_destroy();

setcookie('flash_message', 'Logged out successfully!', time() + 3, '/');
setcookie('flash_message_type', 'success', time() + 3, '/');

header("location: ../index.php");