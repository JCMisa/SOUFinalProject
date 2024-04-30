<?php 
    @include '../configurations/config.php';
    session_start();
    
    if(isset($_GET['file_id'])){
        $id = $_GET['file_id'];

        $sql = " SELECT * FROM manage_events WHERE id = $id; ";
        $result = mysqli_query($conn, $sql);
        $file = mysqli_fetch_assoc($result);

        $filepath = '../events_uploads/' . $file['file'];

        if(file_exists($filepath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma:public');
            header('Content-Length:' . filesize('../events_uploads/' . $file['file']));

            readfile('../events_uploads/' . $file['file']);

            exit;
        }
    }

    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'super_admin') {
        // If the user is not an super admin, redirect them to a access denied page
        header('Location: ./error_pages/denied.php');
        die();
    }
?>