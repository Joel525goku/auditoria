<?php include('header.php'); ?>
<?php include('conexion.php'); ?>

<div class="container">
    <h1 class="mt-4">Estado del Usuario</h1>
    
    <?php
    $estadoUsuario = '';

    // Verificar si se ha seleccionado un usuario
    if (isset($_POST['consultar'])) {
        $eCodUsuario = $_POST['eCodUsuario'];

        // Consultar el estado del usuario en la base de datos
        $sql = "SELECT bEstadoUsuario FROM usuarios WHERE eCodUsuario = :eCodUsuario";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':eCodUsuario', $eCodUsuario);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            $estadoUsuario = $usuario['bEstadoUsuario'] == 1 ? 'Activo' : 'Inactivo';
        } else {
            $estadoUsuario = 'Usuario no encontrado';
        }
    }

    // Obtener la lista de usuarios
    $stmt = $conexion->query("SELECT eCodUsuario, tApellidoPaterno, tApellidoMaterno FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Formulario para seleccionar y consultar el estado del usuario -->
    <form method="post" action="">
        <div class="form-group">
            <label for="eCodUsuario">Selecciona un usuario para consultar su estado:</label>
            <select class="form-control" id="eCodUsuario" name="eCodUsuario">
                <option value="">Seleccionar usuario</option>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['eCodUsuario']; ?>"><?= $usuario['tApellidoPaterno'] . ' ' . $usuario['tApellidoMaterno']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="consultar">Consultar Estado</button>
    </form>

    <?php if (!empty($estadoUsuario)): ?>
        <!-- Mostrar el estado del usuario -->
        <div class="mt-4">
            <h4>Estado del Usuario Seleccionado: <span class="badge badge-info"><?= $estadoUsuario; ?></span></h4>
        </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>

