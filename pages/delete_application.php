<?php 
@include '../configurations/config.php';

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];

    $sql = " DELETE FROM application_tbl WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);

    if($result){
        header('location:./application.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}
?>