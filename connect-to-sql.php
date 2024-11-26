<?php
$connection = new mysqli("localhost", "root", "root", "db_hr");
mysqli_set_charset($connection,"utf8");
if ($connection->connect_errno) {
    echo $connection->connect_errno;
} else {
   
}
