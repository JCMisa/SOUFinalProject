<?php 
@include '../configurations/config.php';

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];

    $sql1 = " DELETE FROM objectives WHERE plan_id = $id; ";
    $result1 = mysqli_query($conn, $sql1);

    $sql2 = " DELETE FROM brief_description WHERE plan_id = $id; ";
    $result2 = mysqli_query($conn, $sql2);

    $sql3 = " DELETE FROM activities WHERE plan_id = $id; ";
    $result3 = mysqli_query($conn, $sql3);

    $sql4 = " DELETE FROM persons_involved WHERE plan_id = $id; ";
    $result4 = mysqli_query($conn, $sql4);

    $sql5 = " DELETE FROM target_date WHERE plan_id = $id; ";
    $result5 = mysqli_query($conn, $sql5);

    $sql6 = " DELETE FROM target_budget WHERE plan_id = $id; ";
    $result6 = mysqli_query($conn, $sql6);


    $sql7 = " DELETE FROM plans WHERE id = $id; ";
    $result7 = mysqli_query($conn, $sql7);


    if($result1 && $result2 && $result3 && $result4 && $result5 && $result6 && $result7){
        header('location:./plans.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}
?>