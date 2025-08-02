<?php

// // Recibir los datos en formato JSON
$data = json_decode(file_get_contents('php://input'), true);
echo json_encode($data);
// // echo "hola pruebafrank";

// $Data= $_POST;

// var_dump($_POST);