<?php 
@include '../configurations/config.php';

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];

    $sql = " DELETE FROM colleges WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);

    if($result){
        header('location:./manage_college.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}
?>