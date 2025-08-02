<?php

// Recibir los datos en formato JSON
$data = json_decode(file_get_contents('php://input'), true);
var_dump($data);