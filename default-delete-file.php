<?php
ini_set('display_errors', 1);
$database = array(
    "db_database",
);
for ($i = 0; $i < sizeof($database); $i++) {
    $dir = './sql/' . $database[$i];
    if (file_exists($dir)) {
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    unlink($dir . '/' . $entry);
                    echo "$entry <br />";
                }
            }
            closedir($handle);
        }
    } else {
        echo $dir . ' not found. <br>';
    }
}
