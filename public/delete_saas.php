<?php
$file = 'c:\laragon\www\sampah\resources\views\admin\saas-dashboard.blade.php';
if (file_exists($file)) {
    unlink($file);
    echo "Deleted saas-dashboard.blade.php";
} else {
    echo "File not found.";
}
