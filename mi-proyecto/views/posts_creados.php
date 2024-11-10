<?php
// Iniciar sesión para obtener el ID del usuario logueado
session_start();
require_once '../inc/conexion.php'; // Ruta correcta al archivo de conexión

// Consultar todos los posts del usuario logueado
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM posts WHERE user_id = :user_id";
$stmt = $conexion->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Posts Creados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin: 0;
        }
        .header-links {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .header-links a {
            color: #007bff;
            text-decoration: none;
            margin-right: 15px;
            font-weight: bold;
        }
        .header-links a:hover {
            text-decoration: underline;
        }
        .post-container {
            width: 80%;
            max-width: 800px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }
        .post {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
            display: flex;
            flex-direction: column;
        }
        .post:last-child {
            border-bottom: none;
        }
        .post h3 {
            margin: 0;
            color: #333;
        }
        .post p {
            color: #666;
        }
        .post img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            margin-top: 10px;
        }
        .post-buttons {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
        .post-buttons a, .post-buttons form {
            text-decoration: none;
        }
        .btn {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            display: inline-block;
        }
        .btn-warning {
            background-color: #04DA38;
            color: #fff;
        }
        .btn-danger {
            background-color: #F44336;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="header-links">
        <a href="dashboard.php">Volver al Dashboard</a>
        <a href="admin.php">Crear Nuevo Post</a>
    </div>

    <h1>Posts Creados</h1>

    <?php if (count($posts) > 0): ?>
        <div class="post-container">
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['titulo']); ?></h3>
                    <?php if (!empty($post['imagen'])): ?>
                        <img src="../uploads/<?php echo htmlspecialchars($post['imagen']); ?>" alt="Imagen del post">
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars($post['descripcion']); ?></p>

                    <div class="post-buttons">
                        <!-- Botón de Eliminar -->
                        <form action="eliminar_post.php" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este post?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                        
                        <!-- Botón de Modificar -->
                        <a href="modificar_post.php?id=<?php echo $post['id']; ?>" class="btn btn-warning">Modificar</a>
                        
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No has creado ningún post aún.</p>
    <?php endif; ?>
</body>
</html>
