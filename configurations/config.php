<?php

$conn = mysqli_connect('localhost','root','','sou_db');

if ($conn->connect_error)
{
    die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
}

?>