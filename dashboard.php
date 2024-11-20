<?php
// Función para leer el archivo JSON y convertirlo en un array
function leerUsuarios() {
    $json = file_get_contents('users.json');
    return json_decode($json, true);
}

// Función para guardar el array de usuarios en el archivo JSON
function guardarUsuarios($usuarios) {
    file_put_contents('users.json', json_encode($usuarios, JSON_PRETTY_PRINT));
}

// Validación de los datos del usuario
function validarUsuario($nombre, $contraseña, $rol) {
    //Si el usuario o la contraseña estan vacios mandar mensaje
    if (empty($nombre) || empty($contraseña) || empty($rol)) {
        return "Todos los campos son requeridos.";
    }
    return null; // Si no hay errores, se retorna null
}

// Crear un nuevo usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {

    //Datos del formulario
    $nombre = $_POST['nombre'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
    $rol = $_POST['rol'];

    // Validación de los datos
    $error = validarUsuario($nombre, $_POST['contraseña'], $rol);

    //Si error es diferente de null o vacio muestra el error
    if ($error) {
        echo $error;
        
        //Si no añadir usuario
    } else {
        // Leer usuarios y añadir el nuevo
        $usuarios = leerUsuarios();
        $nuevoUsuario = [
            'id' => uniqid(),
            'nombre' => $nombre,
            'contraseña' => $contraseña,
            'rol' => $rol
        ];
        $usuarios['usuarios'][] = $nuevoUsuario;
        guardarUsuarios($usuarios);
        echo "Usuario creado con éxito.";
    }
}

// Editar un usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
    $rol = $_POST['rol'];

    // Validación de los datos
    $error = validarUsuario($nombre, $_POST['contraseña'], $rol);
    if ($error) {
        echo $error;
    } else {
        // Leer usuarios y actualizar el usuario
        $usuarios = leerUsuarios();
        foreach ($usuarios['usuarios'] as &$usuario) {
            if ($usuario['id'] == $id) {
                $usuario['nombre'] = $nombre;
                $usuario['contraseña'] = $contraseña;
                $usuario['rol'] = $rol;
                break;
            }
        }
        guardarUsuarios($usuarios);
        echo "Usuario actualizado con éxito.";
    }
}

// Eliminar un usuario
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $usuarios = leerUsuarios();
    $usuarios['usuarios'] = array_filter($usuarios['usuarios'], function($usuario) use ($id) {
        return $usuario['id'] != $id;
    });
    guardarUsuarios($usuarios);
    echo "Usuario eliminado con éxito.";
}

$usuarios = leerUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Usuarios</title>
    <link rel="stylesheet" href="dashboard.css"
</head>
<body>
    <h1>Administrar Usuarios</h1>

    <!-- Formulario para crear usuario -->
    <h2>Crear Usuario</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="password" name="contraseña" placeholder="Contraseña" required><br>
        <select name="rol" required>
            <option value="administrador">Administrador</option>
            <option value="visitante">Visitante</option>
        </select><br>
        <button type="submit" name="crear">Crear Usuario</button>
    </form>

    <h2>Lista de Usuarios</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios['usuarios'] as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                    <td><?= htmlspecialchars($usuario['rol']) ?></td>
                    <td>
                        <a href="dashboard.php?editar=<?= $usuario['id'] ?>">Editar</a> | 
                        <a href="dashboard.php?eliminar=<?= $usuario['id'] ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
    // Si se va a editar un usuario, mostrar el formulario de edición
    if (isset($_GET['editar'])):
        $id = $_GET['editar'];
        $usuario = null;
        foreach ($usuarios['usuarios'] as $u) {
            if ($u['id'] == $id) {
                $usuario = $u;
                break;
            }
        }
        if ($usuario):
    ?>
    <h2>Editar Usuario</h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required><br>
        <input type="password" name="contraseña" placeholder="Nueva contraseña" required><br>
        <select name="rol" required>
            <option value="administrador" <?= $usuario['rol'] == 'administrador' ? 'selected' : '' ?>>Administrador</option>
            <option value="visitante" <?= $usuario['rol'] == 'visitante' ? 'selected' : '' ?>>Visitante</option>
        </select><br>
        <button type="submit" name="editar">Actualizar Usuario</button>
    </form>
    <?php endif; endif; ?>


    <a href="musica.php">
        <button href>Musica</button>
    </a>
    
</body>
</html>
