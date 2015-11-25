<?php

$path = isset($_GET['path']) ? $_GET['path'] : "";
$fileName = isset($_GET['nome']) ? $_GET['nome'] : "";

header("Content-Type: application/force-download");
header("Content-type: application/octet-stream;");
header("Content-Length: " . filesize($path));
header("Content-disposition: attachment; filename=" . $fileName);
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
header("Expires: 0");
readfile($path);
flush();
