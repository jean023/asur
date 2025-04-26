<?php
// Activar errores visibles
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Validando conexión a bases de datos...</h2>";

// --- Luego MySQL (puerto 3306 explícito) ---
$mysql = mysqli_connect(
    "serverl.mysql.database.azure.com",    // Host MySQL
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