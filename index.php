<?php
$host = 'serverl.mysql.database.azure.com';       // IP privada o DNS interno del MySQL Flexible Server en PRD
$user = 'rooot';            // Tu usuario de MySQL
$pass = 'Rut12345';         // Tu contraseña
$db   = 'mysqlprod21';      // Tu base de datos en MySQL

// Conexión
$conn = new mysqli($host, $user, $pass, $db,3306,MYSQLI_CLIENT_SSL);

// Validar conexión
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
} else {
    echo "✅ Conexión exitosa a MySQL desde App Service.<br>";
}

$conn->close();
?>