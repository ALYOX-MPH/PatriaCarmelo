<?php

$URL= $_SERVER["REQUEST_URI"];
$Module= strtolower( trim($URL, "/"));





switch ($Module) {

    // Landing Page
    case 'home':
        require_once "./modules/LandingPage/index.php";
        break;

     case 'agregarseguro':
            require_once "./modules/LandingPage/formSeguros.php";
            break;
        
    case 'pagoscuotas':
        require_once "modules/LandingPage/pagosCuotas.php";
        break;

     case 'registros':
        require_once "./modules/LandingPage/registros.php";
        break;    

     case 'tarifas':
        require_once "./modules/LandingPage/tarifas.php";
        break;
    
     case 'reportes':
        require_once "./modules/LandingPage/reportes.php";
        break;

    case 'error':
        require_once "./modules/AdminPanel/error.php";
        break;
    
    case 'login':
        require_once "./modules/Login/login.php";
        break;
   
    default:
       require_once "./modules/AdminPanel/error.php";
        break;
}