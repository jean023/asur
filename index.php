<?php
// Datos conexión MySQL
$mysql_host = 'serverl.mysql.database.azure.com';       // IP privada o DNS interno de tu servidor MySQL
$mysql_user = 'rooot';             // USUARIO corregido
$mysql_pass = 'Rut12345';          // CONTRASEÑA corregida
$mysql_db   = 'main';       // Nombre de tu base de datos MySQL

// Datos conexión PostgreSQL
$pgsql_host = 'serverx.postgres.database.azure.com';        // IP privada o DNS interno de tu servidor PostgreSQL
$pgsql_user = 'rooot';             // Mismo usuario "rooot" (si también lo usas en PostgreSQL)
$pgsql_pass = 'Rut12345';          // Misma contraseña
$pgsql_db   = 'main';          // Nombre de tu base de datos PostgreSQL

// Conexión MySQL
$mysqli = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db);

if ($mysqli->connect_error) {
    die("❌ Error de conexión a MySQL: " . $mysqli->connect_error);
} else {
    echo "✅ Conexión exitosa a MySQL.<br>";
}

// Conexión PostgreSQL
$pgsql_conn = pg_connect("host=$pgsql_host dbname=$pgsql_db user=$pgsql_user password=$pgsql_pass sslmode=require");

if (!$pgsql_conn) {
    die("❌ Error de conexión a PostgreSQL.");
} else {
    echo "✅ Conexión exitosa a PostgreSQL.<br>";
}

// Cierra conexiones
$mysqli->close();
pg_close($pgsql_conn);
?>