<?php
require_once 'conexion.php';
function showfix($data)
{
    $format = print_r('<pre>');
    $format = print_r($data);
    $format = print_r('</pre>');

    return $format;
}
$database = new Database();
$database->connect();

$rows=$database->select();


echo json_encode($rows);