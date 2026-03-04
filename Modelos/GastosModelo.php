<?php
class GastosModelo {
    private $archivo;

    public function __construct() {
        $this->archivo = "datos/gastos.json";
        if (!file_exists($this->archivo)) {
            file_put_contents($this->archivo, json_encode([]));
        }
    }

    public function obtenerGastos() {
        $datos = file_get_contents($this->archivo);
        return json_decode($datos, true);
    }

    public function obtenerGasto($id) {
        $gastos = $this->obtenerGastos();
        foreach ($gastos as $gasto) {
            if ($gasto['id'] == $id) {
                return $gasto;
            }
        }
        return null; // o false
    }

    public function guardarGasto($titulo, $motivo, $fecha, $monto) {
        $gastos = $this->obtenerGastos();
        
        $id = count($gastos) > 0 ? end($gastos)['id'] + 1 : 1;
        
        $nuevoGasto = [
            'id' => $id,
            'titulo' => $titulo,
            'motivo' => $motivo,
            'fecha' => $fecha,
            'monto' => $monto
        ];
        
        $gastos[] = $nuevoGasto;
        $this->guardarArchivo($gastos);
        return true;
    }

    public function actualizarGasto($id, $titulo, $motivo, $fecha, $monto) {
        $gastos = $this->obtenerGastos();
        $actualizado = false;
        
        foreach ($gastos as $key => $gasto) {
            if ($gasto['id'] == $id) {
                $gastos[$key]['titulo'] = $titulo;
                $gastos[$key]['motivo'] = $motivo;
                $gastos[$key]['fecha'] = $fecha;
                $gastos[$key]['monto'] = $monto;
                $actualizado = true;
                break;
            }
        }
        
        if ($actualizado) {
            $this->guardarArchivo($gastos);
            return true;
        }
        return false;
    }

    public function eliminarGasto($id) {
        $gastos = $this->obtenerGastos();
        $nuevoArray = [];
        $eliminado = false;
        
        foreach ($gastos as $gasto) {
            if ($gasto['id'] == $id) {
                $eliminado = true;
                continue;
            }
            $nuevoArray[] = $gasto;
        }
        
        if ($eliminado) {
            $this->guardarArchivo($nuevoArray);
            return true;
        }
        return false;
    }

    public function filtrarPorMes($anioMes) {
        $gastos = $this->obtenerGastos();
        $filtrados = [];
        
        foreach ($gastos as $gasto) {
            $fechaGasto = substr($gasto['fecha'], 0, 7);
            if ($fechaGasto === $anioMes) {
                $filtrados[] = $gasto;
            }
        }
        
        return $filtrados;
    }

    private function guardarArchivo($datos) {
        file_put_contents($this->archivo, json_encode($datos, JSON_PRETTY_PRINT));
    }
}
?>
