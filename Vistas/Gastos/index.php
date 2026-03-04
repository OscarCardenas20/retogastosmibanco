<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Gastos</title>
    <link rel="stylesheet" href="/retogastosmibanco/Assets/css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <div class="encabezado">
            <h1>Gestión de Gastos</h1>
            <button class="btn btn-primario" onclick="abrirModal()">+ Nuevo Gasto</button>
        </div>

        <div class="tarjeta">
            <form action="/retogastosmibanco/Gastos/index" method="POST" class="controles-filtro">
                <label for="mes">Filtrar por mes:</label>
                <input type="month" id="mes" name="mes" value="<?php echo $datos['filtroActivo'] ? $datos['mesFiltro'] : ''; ?>">
                <button type="submit" class="btn btn-primario">Filtrar</button>
                <?php if ($datos['filtroActivo']): ?>
                    <a href="/retogastosmibanco/Gastos/" class="btn btn-secundario">Listar Todo</a>
                    <span style="margin-left:8px; color:#888; font-size:0.9em;">
                        Mostrando: <strong><?php echo $datos['mesFiltro']; ?></strong>
                    </span>
                <?php else: ?>
                    <span style="margin-left:8px; color:#888; font-size:0.9em;">
                        Mostrando: <strong>Todos los gastos</strong>
                    </span>
                <?php endif; ?>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Motivo</th>
                        <th>Fecha</th>
                        <th>Monto (S/)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    if (!empty($datos['gastos'])) {
                        foreach ($datos['gastos'] as $gasto) { 
                            $total += $gasto['monto'];
                    ?>
                        <tr>
                            <td><?php echo $gasto['id']; ?></td>
                            <td><?php echo htmlspecialchars($gasto['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($gasto['motivo']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($gasto['fecha'])); ?></td>
                            <td><?php echo number_format($gasto['monto'], 2); ?></td>
                            <td class="acciones">
                                <button class="btn btn-verde" onclick="editarGasto(<?php echo htmlspecialchars(json_encode($gasto)); ?>)">Editar</button>
                                <a href="/retogastosmibanco/Gastos/eliminar/<?php echo $gasto['id']; ?>" class="btn btn-rojo" onclick="return confirm('¿Seguro que desea eliminar este gasto?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else { ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">
                                <?php echo $datos['filtroActivo'] ? 'No hay gastos en este mes.' : 'No hay gastos registrados.'; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align: right;">TOTAL:</th>
                        <th colspan="2">S/ <?php echo number_format($total, 2); ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div id="modalGasto" class="modal">
        <div class="modal-contenido">
            <div class="modal-cabecera">
                <h2 id="modalTitulo">Nuevo Gasto</h2>
                <span class="cerrar" onclick="cerrarModal()">&times;</span>
            </div>
            
            <form id="formGasto" action="/retogastosmibanco/Gastos/registrar" method="POST">
                <input type="hidden" id="id" name="id">
                
                <div class="grupo-formulario">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>
                
                <div class="grupo-formulario">
                    <label for="motivo">Motivo de Gasto</label>
                    <input type="text" id="motivo" name="motivo" required>
                </div>
                
                <div class="grupo-formulario">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha" required>
                </div>
                
                <div class="grupo-formulario">
                    <label for="monto">Monto</label>
                    <input type="number" step="0.01" id="monto" name="monto" required min="0.01">
                </div>
                
                <button type="submit" class="btn btn-primario" style="width: 100%;">Guardar Gasto</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalGasto');
        const form = document.getElementById('formGasto');
        const modalTitulo = document.getElementById('modalTitulo');

        function abrirModal() {
            form.reset();
            form.action = '/retogastosmibanco/Gastos/registrar';
            document.getElementById('id').value = '';
            modalTitulo.textContent = 'Nuevo Gasto';
            modal.style.display = 'flex';
        }

        function cerrarModal() {
            modal.style.display = 'none';
        }

        function editarGasto(gasto) {
            form.action = '/retogastosmibanco/Gastos/actualizar';
            modalTitulo.textContent = 'Editar Gasto';
            
            document.getElementById('id').value = gasto.id;
            document.getElementById('titulo').value = gasto.titulo;
            document.getElementById('motivo').value = gasto.motivo;
            document.getElementById('fecha').value = gasto.fecha;
            document.getElementById('monto').value = gasto.monto;
            
            modal.style.display = 'flex';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                cerrarModal();
            }
        }
    </script>
</body>
</html>
