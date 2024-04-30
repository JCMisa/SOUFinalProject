<?php 
@include '../configurations/config.php';

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];

    $sql = " DELETE FROM manage_events WHERE id = $id; ";
    $result = mysqli_query($conn, $sql);

    if($result){
        header('location:./approve_events.php');
        die();
    }else{
        die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
    }
}
?>