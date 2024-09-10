<?php include('header.php'); ?>
<?php include('conexion.php'); ?>

<div class="container">
    <h1 class="mt-4">Bienvenido a la Gestión de Usuarios</h1>
    <p>Utiliza el menú de navegación para acceder a las diferentes funcionalidades del sistema.</p>

    <?php
    // Verificar si se ha enviado la solicitud de borrado
    if (isset($_GET['borrar'])) {
        $eCodUsuario = $_GET['borrar'];

        // Eliminar el usuario de la base de datos
        $sql = "DELETE FROM usuarios WHERE eCodUsuario = :eCodUsuario";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':eCodUsuario', $eCodUsuario);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Usuario eliminado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el usuario.</div>";
        }
    }

    // Obtener la lista de usuarios
    $stmt = $conexion->query("SELECT * FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <!-- Tabla para mostrar los usuarios registrados -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Puesto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['eCodUsuario']; ?></td>
                    <td><?= $usuario['tApellidoPaterno']; ?></td>
                    <td><?= $usuario['tApellidoMaterno']; ?></td>
                    <td><?= $usuario['tCorreoUsuario']; ?></td>
                    <td><?= $usuario['bEstadoUsuario'] == 1 ? 'Activo' : 'Inactivo'; ?></td>
                    <td><?= $usuario['fk_eCodPuesto']; ?></td>
                    <td>
                        <!-- Botón de Editar -->
                        <a href="editar_usuarios.php?eCodUsuario=<?= $usuario['eCodUsuario']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        
                        <!-- Botón de Borrar -->
                        <a href="index.php?borrar=<?= $usuario['eCodUsuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('footer.php'); ?>

