<?php
// Activar errores visibles
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Validando conexión a bases de datos...</h2>";

// --- Primero PostgreSQL (puerto 5432 explícito) ---
$pg_host   = '10.167.2.4';           // IP privada de tu PostgreSQL
$pg_port   = '5432';                 // Puerto
$pg_dbname = 'postgres';             // Nombre de la base de datos
$pg_user   = 'rooot';      // Usuario completo en Azure Flexible Server
$pg_pass   = 'Rut12345';             // Contraseña

// Cadena de conexión con SSL
$conn_str = sprintf(
    'host=%s port=%s dbname=%s user=%s password=%s sslmode=require',
    $pg_host,
    $pg_port,
    $pg_dbname,
    $pg_user,
    $pg_pass
);

// Intentamos conectar
$pg_conn = pg_connect($conn_str);

if (!$pg_conn) {
    // Si falla, pg_last_error($pg_conn) no sirve porque no hay recurso,
    // así que llamamos sin argumento para obtener el último mensaje general
    $err = pg_last_error();
    echo "<p style='color:red;'>❌ Error al conectar PostgreSQL: {$err}</p>";
    exit;
}

// Si conecta, probamos una consulta simple
echo "<p style='color:green;'>✅ Conexión SSL exitosa a PostgreSQL</p>";

$result = pg_query($pg_conn, 'SELECT version();');
if ($result) {
    $row = pg_fetch_row($result);
    echo "<p>🔵 PostgreSQL version: {$row[0]}</p>";
} else {
    echo "<p style='color:orange;'>⚠️ Error al ejecutar consulta: " . pg_last_error($pg_conn) . "</p>";
}
// Cerramos
pg_close($pg_conn);

// --- Luego MySQL (puerto 3306 explícito) ---
$con = mysqli_init();

// Configuramos SSL (no necesitas rutas a certificados en Azure interno)
mysqli_ssl_set($con, NULL, NULL, NULL, NULL, NULL);

// Parámetros de conexión
$host     = "10.167.0.4";     // IP privada de tu MySQL en PRD
$user     = "rooot";          // Usuario MySQL
$pass     = "Rut12345";       // Contraseña MySQL
$db       = "";    // Nombre de la base de datos
$port     = 3306;             // Puerto MySQL

// Conexión segura
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

// Validamos
if (mysqli_connect_errno()) {
    echo "<p style='color:red;'>❌ Error MySQL (SSL): " . mysqli_connect_error() . "</p>";
} else {
    echo "<p style='color:green;'>✅ Conexión SSL exitosa a MySQL</p>";
    mysqli_close($con);
}
?>
