<?php include('header.php'); ?>
<?php include('conexion.php'); ?>

<div class="container">
    <h1 class="mt-4">Obtener Puesto del Usuario</h1>

    <?php
    $puestoUsuario = '';

    // Verificar si se ha seleccionado un usuario
    if (isset($_POST['consultar'])) {
        $eCodUsuario = $_POST['eCodUsuario'];

        // Consultar el puesto del usuario en la base de datos
        $sql = "SELECT auditoria.nombre_puesto FROM usuarios 
                INNER JOIN auditoria ON usuarios.fk_eCodPuesto = auditoria.eCodPuesto 
                WHERE usuarios.eCodUsuario = :eCodUsuario";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':eCodUsuario', $eCodUsuario);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            $puestoUsuario = $usuario['nombre_puesto'];
        } else {
            $puestoUsuario = 'Puesto no encontrado para el usuario seleccionado';
        }
    }

    // Obtener la lista de usuarios
    $stmt = $conexion->query("SELECT eCodUsuario, tApellidoPaterno, tApellidoMaterno FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Formulario para seleccionar y consultar el puesto del usuario -->
    <form method="post" action="">
        <div class="form-group">
            <label for="eCodUsuario">Selecciona un usuario para consultar su puesto:</label>
            <select class="form-control" id="eCodUsuario" name="eCodUsuario">
                <option value="">Seleccionar usuario</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['eCodUsuario']; ?>"><?= $usuario['tApellidoPaterno'] . ' ' . $usuario['tApellidoMaterno']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="consultar">Consultar Puesto</button>
    </form>

    <?php if (!empty($puestoUsuario)): ?>
        <!-- Mostrar el puesto del usuario -->
        <div class="mt-4">
            <h4>Puesto del Usuario Seleccionado: <span class="badge badge-info"><?= $puestoUsuario; ?></span></h4>
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>

