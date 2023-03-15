<?php
ini_set('display_errors', 1);
$database = array(
    "db_database",
);
for ($i = 0; $i < sizeof($database); $i++) {
    $dir = dirname(__FILE__) . '/sql/' . $database[$i];
    if (file_exists($dir)) {
        if ($handle = opendir($dir)) {
            $zip = new ZipArchive();
            $zip->open('compressed/'. $database[$i] .'/'. $database[$i] .'_'. date('YmdHis') .'.zip', ZipArchive::CREATE);
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $zip->addFile($dir . '/' . $entry, $entry);
                }
            }
            echo json_encode($zip);
            $zip->close();
            closedir($handle);
        }
    } else {
        echo $dir . ' not found. <br>';
    }
}
