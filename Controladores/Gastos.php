<?php
class Gastos extends Controlador {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mes']) && $_POST['mes'] !== '') {
            $mesFiltro = $_POST['mes'];
            $gastos = $this->modelo->filtrarPorMes($mesFiltro);
            $filtroActivo = true;
        } else {
            $mesFiltro = date('Y-m');
            $gastos = $this->modelo->obtenerGastos();
            $filtroActivo = false;
        }

        $datos = [
            'gastos'       => $gastos,
            'mesFiltro'    => $mesFiltro,
            'filtroActivo' => $filtroActivo
        ];

        $this->vistas->obtenerVista($this, "index", $datos);
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titulo = $_POST['titulo'];
            $motivo = $_POST['motivo'];
            $fecha  = $_POST['fecha'];
            $monto  = floatval($_POST['monto']);

            if ($monto <= 0) {
                header("Location: /retogastosmibanco/Gastos/?error=El+monto+debe+ser+mayor+a+0");
                exit;
            }

            if ($this->modelo->guardarGasto($titulo, $motivo, $fecha, $monto)) {
                $mensaje = ['tipo' => 'success', 'texto' => 'Gasto registrado'];
            } else {
                $mensaje = ['tipo' => 'error', 'texto' => 'Error al registrar'];
            }

            header("Location: /retogastosmibanco/Gastos/");
            exit;
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id     = $_POST['id'];
            $titulo = $_POST['titulo'];
            $motivo = $_POST['motivo'];
            $fecha  = $_POST['fecha'];
            $monto  = floatval($_POST['monto']);

            if ($monto <= 0) {
                header("Location: /retogastosmibanco/Gastos/?error=El+monto+debe+ser+mayor+a+0");
                exit;
            }

            if ($this->modelo->actualizarGasto($id, $titulo, $motivo, $fecha, $monto)) {
                $mensaje = ['tipo' => 'success', 'texto' => 'Gasto actualizado'];
            } else {
                $mensaje = ['tipo' => 'error', 'texto' => 'Error al actualizar'];
            }

            header("Location: /retogastosmibanco/Gastos/");
            exit;
        }
    }

    public function eliminar($id) {
        if ($this->modelo->eliminarGasto($id)) {
            $mensaje = ['tipo' => 'success', 'texto' => 'Gasto eliminado'];
        } else {
            $mensaje = ['tipo' => 'error', 'texto' => 'Error al eliminar'];
        }

        header("Location: /retogastosmibanco/Gastos/");
        exit;
    }
}
?>
