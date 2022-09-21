<?php
date_default_timezone_get('Asia/Jakarta');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$database = array(
    "db_database",
);
$user = '';
$pass = '';
$host = 'localhost';
for ($i = 0; $i < sizeof($database); $i++) {
    $dir = dirname(__FILE__) . '/sql/' . $database[$i] . '/';
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    $dir .= $database[$i] . '_' . date('YmdHis') . '.sql';
    echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";
    exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database[$i]} -R -K --triggers --result-file={$dir} 2>&1", $output);
    var_dump($output);
}
