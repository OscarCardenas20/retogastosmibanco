<?php
class Controlador {
    protected $vistas;
    protected $modelo;

    public function __construct() {
        $this->vistas = new Vistas();
        $this->cargarModelo();
    }

    public function cargarModelo() {
        $claseModelo = get_class($this) . "Modelo";
        $rutaModelo = "Modelos/" . $claseModelo . ".php";
        
        if (file_exists($rutaModelo)) {
            require_once $rutaModelo;
            $this->modelo = new $claseModelo();
        }
    }
}
?>
