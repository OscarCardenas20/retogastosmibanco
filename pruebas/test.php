<?php
require_once __DIR__ . "/../Modelos/GastosModelo.php";

$modelo = new GastosModelo();

$tituloTest = "Gasto de Prueba " . time();
$motivoTest = "Prueba Unitaria";
$fechaTest = date('Y-m-d');
$montoTest = 100.50;

echo "Iniciando pruebas unitarias...\n";

$resultadoGuardar = $modelo->guardarGasto($tituloTest, $motivoTest, $fechaTest, $montoTest);
if ($resultadoGuardar) {
    echo "[OK] Insertar gasto\n";
} else {
    echo "[ERROR] Insertar gasto\n";
    exit(1);
}

$gastos = $modelo->obtenerGastos();
$ultimoGasto = end($gastos);
$idTest = $ultimoGasto['id'];

if ($ultimoGasto['titulo'] === $tituloTest) {
    echo "[OK] Obtener gastos\n";
} else {
    echo "[ERROR] Obtener gastos\n";
    exit(1);
}

$nuevoTitulo = "Gasto Editado";
$resultadoActualizar = $modelo->actualizarGasto($idTest, $nuevoTitulo, $motivoTest, $fechaTest, 200.00);

if ($resultadoActualizar) {
    $gastoEditado = $modelo->obtenerGasto($idTest);
    if ($gastoEditado['titulo'] === $nuevoTitulo) {
        echo "[OK] Actualizar gasto\n";
    } else {
        echo "[ERROR] Verificar actualizacion de gasto\n";
        exit(1);
    }
} else {
    echo "[ERROR] Actualizar gasto\n";
    exit(1);
}

$resultadoEliminar = $modelo->eliminarGasto($idTest);
if ($resultadoEliminar) {
    $gastoEliminado = $modelo->obtenerGasto($idTest);
    if ($gastoEliminado === null) {
        echo "[OK] Eliminar gasto\n";
    } else {
        echo "[ERROR] Verificar eliminacion de gasto\n";
        exit(1);
    }
} else {
    echo "[ERROR] Eliminar gasto\n";
    exit(1);
}

echo "Todas las pruebas pasaron correctamente.\n";
exit(0);
?>
