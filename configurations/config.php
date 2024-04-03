<?php

$server = "sql312.infinityfree.com";
$username = "if0_36297433";
$password = "mPgNmuqNSbaxcj";
$dbname = "if0_36297433_sou_db";

$conn = mysqli_connect('localhost','root','','sou_db');

if ($conn->connect_error)
{
    die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

?>