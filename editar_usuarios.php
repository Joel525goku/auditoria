<?php include('header.php'); ?>
<?php include('conexion.php'); ?>

<div class="container">
    <h1 class="mt-4">Editar Usuarios</h1>
    
    <?php
    // Verificar si se ha enviado el formulario de edición
    if (isset($_POST['editar'])) {
        $eCodUsuario = $_POST['eCodUsuario'];
        $tApellidoPaterno = $_POST['tApellidoPaterno'];
        $tApellidoMaterno = $_POST['tApellidoMaterno'];
        $tCorreoUsuario = $_POST['tCorreoUsuario'];
        $tContrasena = $_POST['tContrasena'];
        $bEstadoUsuario = $_POST['bEstadoUsuario'];
        $fk_eCodPuesto = $_POST['fk_eCodPuesto'];

        // Actualizar el usuario en la base de datos
        $sql = "UPDATE usuarios SET 
                    tApellidoPaterno = :tApellidoPaterno, 
                    tApellidoMaterno = :tApellidoMaterno, 
                    tCorreoUsuario = :tCorreoUsuario, 
                    tContrasena = :tContrasena, 
                    bEstadoUsuario = :bEstadoUsuario, 
                    fk_eCodPuesto = :fk_eCodPuesto,
                    fhFechaHoraActualizacionUsuario = NOW()
                WHERE eCodUsuario = :eCodUsuario";
                
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':tApellidoPaterno', $tApellidoPaterno);
        $stmt->bindParam(':tApellidoMaterno', $tApellidoMaterno);
        $stmt->bindParam(':tCorreoUsuario', $tCorreoUsuario);
        $stmt->bindParam(':tContrasena', $tContrasena);
        $stmt->bindParam(':bEstadoUsuario', $bEstadoUsuario);
        $stmt->bindParam(':fk_eCodPuesto', $fk_eCodPuesto);
        $stmt->bindParam(':eCodUsuario', $eCodUsuario);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Usuario actualizado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al actualizar el usuario.</div>";
        }
    }

    // Obtener la lista de usuarios
    $stmt = $conexion->query("SELECT * FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Formulario para seleccionar y editar usuario -->
    <form method="post" action="">
        <div class="form-group">
            <label for="eCodUsuario">Selecciona un usuario para editar:</label>
            <select class="form-control" id="eCodUsuario" name="eCodUsuario" onchange="cargarUsuario(this.value)">
                <option value="">Seleccionar usuario</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['eCodUsuario']; ?>"><?= $usuario['tApellidoPaterno'] . ' ' . $usuario['tApellidoMaterno']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="form-editar" style="display: none;">
            <div class="form-group">
                <label for="tApellidoPaterno">Apellido Paterno:</label>
                <input type="text" class="form-control" id="tApellidoPaterno" name="tApellidoPaterno" required>
            </div>
            <div class="form-group">
                <label for="tApellidoMaterno">Apellido Materno:</label>
                <input type="text" class="form-control" id="tApellidoMaterno" name="tApellidoMaterno" required>
            </div>
            <div class="form-group">
                <label for="tCorreoUsuario">Correo Electrónico:</label>
                <input type="email" class="form-control" id="tCorreoUsuario" name="tCorreoUsuario" required>
            </div>
            <div class="form-group">
                <label for="tContrasena">Contraseña:</label>
                <input type="password" class="form-control" id="tContrasena" name="tContrasena" required>
            </div>
            <div class="form-group">
                <label for="bEstadoUsuario">Estado:</label>
                <select class="form-control" id="bEstadoUsuario" name="bEstadoUsuario" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fk_eCodPuesto">Puesto:</label>
                <input type="text" class="form-control" id="fk_eCodPuesto" name="fk_eCodPuesto" required>
            </div>
            <button type="submit" class="btn btn-primary" name="editar">Guardar Cambios</button>
        </div>
    </form>
</div>

<script>
// Función para cargar los datos del usuario seleccionado en el formulario
function cargarUsuario(id) {
    if (id === "") {
        document.getElementById('form-editar').style.display = 'none';
        return;
    }

    fetch('obtener_usuario.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('tApellidoPaterno').value = data.tApellidoPaterno;
            document.getElementById('tApellidoMaterno').value = data.tApellidoMaterno;
            document.getElementById('tCorreoUsuario').value = data.tCorreoUsuario;
            document.getElementById('tContrasena').value = data.tContrasena;
            document.getElementById('bEstadoUsuario').value = data.bEstadoUsuario;
            document.getElementById('fk_eCodPuesto').value = data.fk_eCodPuesto;
            document.getElementById('form-editar').style.display = 'block';
        })
        .catch(error => console.error('Error al cargar los datos del usuario:', error));
}
</script>

<?php include('footer.php'); ?>


