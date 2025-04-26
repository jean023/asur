<?php
// Activar errores visibles
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Validando conexión a bases de datos...</h2>";

// --- Primero PostgreSQL (puerto 5432 explícito) ---
$pg_conn = pg_connect(
   "host=10.167.2.4" .
   "port=5432" .
    "dbname=postgres" .
    "user=rooot" .
    "password=Rut12345" .
    "sslmode=require"
);

if ($pg_conn) {
   echo "<p style='color:green;'>✅ Conexión exitosa a PostgreSQL</p>";
   pg_close($pg_conn);
} else {
   echo "<p style='color:red;'>❌ Error PostgreSQL: " . pg_last_error() . "</p>";
}

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
