<?php
// Activar errores visibles
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Validando conexión a bases de datos...</h2>";

// --- Primero PostgreSQL (puerto 5432 explícito) ---
//$pg_conn = pg_connect(
//    "host=10.161.2.4 " .
//   "port=5432 " .
 //   "dbname=postgres " .
 //   "user=Tiancris " .
//    "password=#Zarache060221 " .
//    "sslmode=require"
//);

if ($pg_conn) {
    echo "<p style='color:green;'>✅ Conexión exitosa a PostgreSQL</p>";
    pg_close($pg_conn);
} else {
    echo "<p style='color:red;'>❌ Error PostgreSQL: " . pg_last_error() . "</p>";
}

// --- Luego MySQL (puerto 3306 explícito) ---
$mysql = mysqli_connect(
    "10.167.0.4",    // Host MySQL
    "rooot",      // Usuario
    "Rut12345",// Contraseña
    "",              // Base de datos (vacío si no aplica)
    3306             // Puerto
);

if ($mysql) {
    echo "<p style='color:green;'>✅ Conexión exitosa a MySQL</p>";
    mysqli_close($mysql);
} else {
    echo "<p style='color:red;'>❌ Error MySQL: " . mysqli_connect_error() . "</p>";
}
?>