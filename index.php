<?php
$con = mysqli_init();
mysqli_ssl_set($con, NULL, NULL, NULL, NULL, NULL);
mysqli_real_connect($con, "serverk.mysql.database.azure.com", "rooot", "Rut12345", "sys", 3306, MYSQLI_CLIENT_SSL);

if (mysqli_connect_errno()) {
    die("❌ Conexión fallida: " . mysqli_connect_error());
} else {
    echo "✅ Conectado correctamente a MySQL.";
}
?>