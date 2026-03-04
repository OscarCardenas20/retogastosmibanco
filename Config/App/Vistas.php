<?php
class Vistas {
    public function obtenerVista($controlador, $vista, $datos = "") {
        $controladorStr = get_class($controlador);
        
        if ($controladorStr == "Gastos") {
            $rutaVista = "Vistas/" . $controladorStr . "/" . $vista . ".php";
        } else {
            $rutaVista = "Vistas/" . $controladorStr . "/" . $vista . ".php";
        }
        
        require_once $rutaVista;
    }
}
?>
