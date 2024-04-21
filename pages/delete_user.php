<?php 
@include '../configurations/config.php';

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];

    $sql = " DELETE FROM user_tbl WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);

    $sql2 = " DELETE FROM commitment_tbl WHERE user_id = $id; "; //to also delete all records of user 
    $result2 = mysqli_query($conn, $sql2);

    $sql3 = " DELETE FROM application_tbl WHERE user_id = $id; "; //to also delete all records of user 
    $result3 = mysqli_query($conn, $sql3);

    $sql4 = " DELETE FROM renewal_tbl WHERE user_id = $id; "; //to also delete all records of user 
    $result4 = mysqli_query($conn, $sql4);

    $sql5 = " DELETE FROM application_upload WHERE user_id = $id; "; //to also delete all records of user 
    $result5 = mysqli_query($conn, $sql5);

    $sql7 = " DELETE FROM plans WHERE user_id = $id; "; //to also delete all records of user 
    $result7 = mysqli_query($conn, $sql7);

    if($result && $result2 && $result3 && $result4 && $result5 && $result7){
        header('location:./manage_user.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}
?>