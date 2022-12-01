<?php
include "dbconnect.php";
session_start();

if (isset($_POST['username']) && isset($_POST['password'])){
        $userid = $_POST['username'];
        $password = md5($_POST['password']);
        $query = 'select * from employee '
        ."where username='$userid' "
        ." and password='$password'";
        // echo $query;
        $result = $dbcnx->query($query);
        if($result->num_rows>0){
            $_SESSION['valid_user'] = $userid;
        }
        else{
            unset($_SESSION['valid_user']);
        }
        $dbcnx->close();
}
if (isset($_SESSION['valid_user'])){
    header("Location: editMovie.php"); 
    exit();
}
else{
    echo '<script type="text/javascript">alert("Incorrect user and password!");history.go(-1);</script>';
    exit();
}

?>