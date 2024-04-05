<?php 
@include '../configurations/config.php';

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];

    $sql1 = " DELETE FROM objectives WHERE plan_id = $id; ";
    $result1 = mysqli_query($conn, $sql1);

    $sql2 = " DELETE FROM brief_description WHERE plan_id = $id; ";
    $result2 = mysqli_query($conn, $sql2);

    $sql3 = " DELETE FROM plans WHERE id = $id; ";
    $result3 = mysqli_query($conn, $sql3);

    if($result1 && $result2 && $result3){
        header('location:./plans.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}
?>