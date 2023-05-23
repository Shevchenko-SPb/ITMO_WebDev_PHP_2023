<?php
$dir = "./../uploads/";

foreach (scandir($dir) as $value) {
    $fileUrl = $dir . $value;
}


makeFileList($dir);
function makeFileList ($dir)
{
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) == true) {
                if (is_file($dir . $file)) {
                    echo "<form>";
                    echo "<form action=./template/downloadFile.php method='post'>";
                    echo "<input type='submit' name='$dir$file' value='Download'/>";
                    echo "файл: $file";
                    echo "</form>";
                }
            }
        }
        closedir($dh);
    }
}

