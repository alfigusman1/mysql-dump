<?php
// db_backup_zip_delete.php

// Konfigurasi timezone dan error reporting
date_default_timezone_set('Asia/Jakarta');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Konfigurasi database
$database = array(
    "db_database",
);
$user = '';
$pass = '';
$host = 'localhost';

foreach ($database as $dbName) {
    // Direktori backup dan kompresi
    $backupDir = dirname(__FILE__) . '/sql/' . $dbName . '/';
    $compressedDir = dirname(__FILE__) . '/compressed/' . $dbName . '/';

    // Membuat direktori jika belum ada
    if (!file_exists($backupDir)) {
        mkdir($backupDir, 0777, true);
    }
    if (!file_exists($compressedDir)) {
        mkdir($compressedDir, 0777, true);
    }

    // Nama file SQL
    $backupFile = $backupDir . $dbName . '_' . date('YmdHis') . '.sql';

    // Backup database ke file SQL
    echo "<h3>Backing up database to `<code>{$backupFile}</code>`</h3>";
    exec("mysqldump --user={$user} --password={$pass} --host={$host} {$dbName} -R -K --triggers --result-file={$backupFile} 2>&1", $output);
    var_dump($output);

    // Kompres file SQL ke ZIP
    if (file_exists($backupFile)) {
        $zip = new ZipArchive();
        $zipFile = $compressedDir . $dbName . '_' . date('Y_m_d_H_i_s') . '.zip';
        if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($backupFile, basename($backupFile));
            $zip->close();
            echo "<h3>Database compressed to `<code>{$zipFile}</code>`</h3>";

            // Hapus file SQL setelah dikompresi
            if (unlink($backupFile)) {
                echo "<h3>Deleted SQL file: `<code>{$backupFile}</code>`</h3>";
            } else {
                echo "<h3>Failed to delete SQL file: `<code>{$backupFile}</code>`</h3>";
            }
        } else {
            echo "<h3>Failed to create ZIP file: `<code>{$zipFile}</code>`</h3>";
        }
    } else {
        echo "<h3>Backup file not found: `<code>{$backupFile}</code>`</h3>";
    }
}
