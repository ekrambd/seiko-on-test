<?php
$host = "localhost";
$user = "ekrambd";
$pass = "Ekrambd28&50";
$db   = "shokal_seiko";

$conn = mysql_connect($host, $user, $pass);

if (!$conn) {
    die("DB connection failed: " . mysql_error());
}
echo "connected";
mysql_select_db($db, $conn);
?>
