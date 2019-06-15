<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL);

if(isset($_GET['name'])) {
    $name = $_GET['name'];
    if(file_exists('./uploads/' .
        $name[0] . '/' .
        $name[1] . '/' .
        $name) && !empty($name[0]) && !empty($name[1])) {
        $path = './uploads/' .
            $name[0] . '/' .
            $name[1] . '/' .
            $name;

        header('Content-Description: File Transfer');
        header('Content-Type: octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($path));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        readfile($path);
    }
}
header('Location: index.html');