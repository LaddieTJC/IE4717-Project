<?php
unset($_SESSION['valid_user']);
session_destroy();
header("Location: login.html");
exit();
?>

