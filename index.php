<?php
$ruta = !empty($_GET['url']) ? $_GET['url'] : "Gastos/index";
$arreglo = explode("/", $ruta);
$controlador = $arreglo[0];
$metodo = "index";
$parametro = "";

if (!empty($arreglo[1])) {
    if ($arreglo[1] != "") {
        $metodo = $arreglo[1];
    }
}

if (!empty($arreglo[2])) {
    if ($arreglo[2] != "") {
        for ($i = 2; $i < count($arreglo); $i++) {
            $parametro .= $arreglo[$i] . ",";
        }
        $parametro = trim($parametro, ",");
    }
}

require_once "Config/App/autoload.php";

$dirControladores = "Controladores/" . $controlador . ".php";

if (file_exists($dirControladores)) {
    require_once $dirControladores;
    
    if (class_exists($controlador)) {
        $objetoControlador = new $controlador();
        
        if (method_exists($objetoControlador, $metodo)) {
            $objetoControlador->$metodo($parametro);
        } else {
            die("Metodo no encontrado");
        }
    } else {
        die("Clase no encontrada");
    }
} else {
    die("Controlador no encontrado");
}
?>
