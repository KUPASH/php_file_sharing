<?php
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
error_reporting(E_ALL);
?>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="userFile">
        <button type="submit">Submit</button>
    </form>
    Users have previously submitted:

    <?
        $allowed_ext = ['jpg', 'jpeg'];

        echo '<pre>';
        print_r($_FILES);
        echo '</pre>';

        if(isset($_FILES['userFile'])) {
            $filename = md5(time() . rand(1, 9999) . $_FILES['userFile']['name']);

            $ext = explode('.', $_FILES['userFile']['name']);
            $ext = $ext[count($ext) - 1];

            if (!in_array($ext, $allowed_ext)) {
                echo '<div style="color: red">ERROR: Invalid file extension; valid jpg, jpeg</div>';
            }else {

                $subdirname1 = $filename[0];
                $subdirname2 = $filename[1];

                if (!file_exists('./uploads/' .
                    $subdirname1 . '/' .
                    $subdirname2)
                ) {
                    mkdir('./uploads/' .
                        $subdirname1 . '/' .
                        $subdirname2, 0777, true);
                }

                move_uploaded_file($_FILES['userFile']['tmp_name'],
                    './uploads/' .
                    $subdirname1 . '/' .
                    $subdirname2 . '/' .
                    $filename . '.' . $ext);
            }
        }

        function dirToArray($dir) {

            $result = [];

            $cdir = scandir($dir);
            foreach ($cdir as $value) {
                if (!in_array($value,array(".",".."))) {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
                    {
                        $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
                    }
                    else
                    {
                        $result[] = $value;
                        echo '<img src="'. $dir . DIRECTORY_SEPARATOR . $value .'" width="100">';
                        echo '<div><a href="download.php?name=' . $value . '">Link</a><div>';
                    }
                }
            }

            return $result;

        }
        dirToArray('./uploads/');

        ?>
</body>
</html>