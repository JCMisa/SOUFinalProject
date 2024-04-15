<?php 
    @include '../configurations/config.php';
    session_start();

    if(isset($_GET['file_id'])){
        $id = $_GET['file_id'];

        $sql = " SELECT * FROM application_upload WHERE id = $id; ";
        $result = mysqli_query($conn, $sql);
        $file = mysqli_fetch_assoc($result);

        $filepath = '../application_uploads/' . $file['name'];

        if(file_exists($filepath)) {
            header('Content-Type: application/octet-stream');
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma:public');
            header('Content-Length:' . filesize('../application_uploads/' . $file['name']));

            readfile('../application_uploads/' . $file['name']);

            $newCount = $file['downloads'] + 1;

            $updateQuery = " UPDATE application_upload SET downloads = $newCount WHERE id = $id; ";

            mysqli_query($conn, $updateQuery);

            exit;
        }
    }

    if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'super_admin') {
        // If the user is not an super admin, redirect them to a access denied page
        header('Location: ./error_pages/denied.php');
        die();
    }
?>