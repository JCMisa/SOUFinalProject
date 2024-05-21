<?php
    @include '../configurations/config.php';

    if(isset($_GET['file_id']) && isset($_GET['action']) && $_GET['action'] === 'view'){
        $id = $_GET['file_id'];

        $sql = " SELECT * FROM application_upload WHERE id = $id; ";
        $result = mysqli_query($conn, $sql);
        $file = mysqli_fetch_assoc($result);

        $filepath = '../application_uploads/' . $file['name'];

        if(file_exists($filepath)) {
            header('Content-Type: application/pdf');
            readfile($filepath);
            exit;
        }
    }
?>