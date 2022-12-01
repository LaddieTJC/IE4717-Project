<?php
@ $dbcnx = new mysqli('localhost','root','','project');
if ($dbcnx->connect_error){
    echo "Database is not online";
    exit;
}
?>