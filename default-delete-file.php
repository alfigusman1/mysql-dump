<?php
ini_set('display_errors', 1);
if ($handle = opendir('./sql/')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            unlink("./sql/$entry");
            echo "$entry <br />";
        }
    }
    closedir($handle);
}
