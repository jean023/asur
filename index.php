<?php
$con = mysqli_init();
mysqli_ssl_set($con, NULL, NULL, NULL, NULL, NULL);
mysqli_real_connect(
    $con,
    "10.167.0.4",   // IP privada o DNS
    "rooot",
    "Rut12345",
    "mysqlprod21",   // Tu base de datos
    3306,
    NULL,
    MYSQLI_CLIENT_SSL
);

if (mysqli_connect_errno()) {
    die("❌ Error de conexión: " . mysqli_connect_error());
} else {
    echo "✅ Conectado exitosamente con SSL a MySQL.<br>";
}
?>