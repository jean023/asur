<?php
$con = mysqli_init();

// Iniciar SSL (sin necesidad de certificados explícitos, porque estás dentro de Azure)
mysqli_ssl_set($con, NULL, NULL, NULL, NULL, NULL);

// Conexión segura
mysqli_real_connect(
    $con,
    "10.167.0.4",        // IP privada de tu MySQL en PRD
    "rooot@mysqlserver", // Usuario (puede requerir @mysqlserver si es Flexible Server)
    "Rut12345",          // Contraseña
    "mysqlprod21",       // Base de datos
    3306,
    NULL,
    MYSQLI_CLIENT_SSL    // <- Importante
);

// Validar
if (mysqli_connect_errno()) {
    die("❌ Error de conexión: " . mysqli_connect_error());
} else {
    echo "✅ Conectado correctamente a MySQL con SSL desde App Service.<br>";
}
?>