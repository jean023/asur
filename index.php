<?php
// Activar errores visibles
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Validando conexión a bases de datos...</h2>";

// --- Primero PostgreSQL (puerto 5432 explícito) ---
$pg_host   = '10.167.2.4';           
$pg_port   = '5432';                 
$pg_dbname = 'postgres';             
$pg_user   = 'rooot';      
$pg_pass   = 'Rut12345';             

$conn_str = sprintf(
    'host=%s port=%s dbname=%s user=%s password=%s sslmode=require',
    $pg_host,
    $pg_port,
    $pg_dbname,
    $pg_user,
    $pg_pass
);

$pg_conn = pg_connect($conn_str);
if (!$pg_conn) {
    $err = pg_last_error();
    echo "<p style='color:red;'>❌ Error al conectar PostgreSQL: {$err}</p>";
    exit;
}
echo "<p style='color:green;'>✅ Conexión SSL exitosa a PostgreSQL</p>";
pg_close($pg_conn);

// --- Función de conexión MySQL con SSL ---
function getMySqlConnection() {
    $host = "10.167.0.4";
    $user = "rooot";
    $pass = "Rut12345";
    $db   = "main";
    $port = 3306;

    $con = mysqli_init();
    mysqli_ssl_set($con, NULL, NULL, NULL, NULL, NULL);
    mysqli_real_connect(
        $con,
        $host,
        $user,
        $pass,
        $db,
        $port,
        NULL,
        MYSQLI_CLIENT_SSL
    );

    if (mysqli_connect_errno()) {
        die("<p style='color:red;'>❌ Error MySQL (SSL): " . mysqli_connect_error() . "</p>");
    }
    return $con;
}

// --- Función de registro ---
function registerUser($username, $password) {
    $con = getMySqlConnection();
    // Verificar existencia
    $stmt = $con->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "<p style='color:red;'>❌ El usuario '{$username}' ya existe.</p>";
        $stmt->close();
        $con->close();
        return;
    }
    $stmt->close();
    // Insertar con hash
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $con->prepare("INSERT INTO usuarios (nombre, usuario, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $username, $hash);
    if ($stmt->execute()) {
        echo "<p style='color:green;'>✅ Usuario '{$username}' registrado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error al registrar: " . $stmt->error . "</p>";
    }
    $stmt->close();
    $con->close();
}

// --- Función de login ---
function loginUser($username, $password) {
    $con = getMySqlConnection();
    // Obtener hash
    $stmt = $con->prepare("SELECT contrasena FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hash);
    if (!$stmt->fetch()) {
        echo "<p style='color:red;'>❌ Usuario '{$username}' no encontrado.</p>";
        $stmt->close();
        $con->close();
        return;
    }
    $stmt->close();
    // Verificar contraseña
    if (password_verify($password, $hash)) {
        echo "<p style='color:green;'>✅ Login exitoso. ¡Bienvenido, {$username}!</p>";
    } else {
        echo "<p style='color:red;'>❌ Contraseña incorrecta.</p>";
    }
    $con->close();
}

// --- Lógica de recepción de formulario ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action   = $_POST['action']   ?? '';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($action === 'register') {
        registerUser($username, $password);
    } elseif ($action === 'login') {
        loginUser($username, $password);
    } else {
        echo "<p style='color:orange;'>⚠️ Acción inválida.</p>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Auth PHP en App Service</title>
</head>
<body>
  <h2>Register</h2>
  <form method="post">
    <input type="hidden" name="action" value="register">
    <label>Usuario: <input type="text" name="username" required></label><br>
    <label>Contraseña: <input type="password" name="password" required></label><br>
    <button type="submit">Registrar</button>
  </form>

  <hr>

  <h2>Login</h2>
  <form method="post">
    <input type="hidden" name="action" value="login">
    <label>Usuario: <input type="text" name="username" required></label><br>
    <label>Contraseña: <input type="password" name="password" required></label><br>
    <button type="submit">Entrar</button>
  </form>
</body>
</html>