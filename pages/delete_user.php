<?php 
@include '../configurations/config.php';

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];

    $sql = " DELETE FROM user_tbl WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);

    $sql2 = " DELETE FROM commitment_tbl WHERE user_id = $id; "; //to also delete all records of user 
    $result2 = mysqli_query($conn, $sql2);

    if($result && $result2){
        header('location:./manage_user.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}
?>