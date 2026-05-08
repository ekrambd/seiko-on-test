<?php
$host = "localhost";
$user = "ekrambd";
$pass = "Ekrambd28&50";
$db   = "shokal_seiko";

$conn = mysql_connect($host, $user, $pass);

if (!$conn) {
    die("DB connection failed: " . mysql_error());
}
mysql_select_db($db, $conn);

// run query
$query = "SELECT * FROM admin_log";
$result = mysql_query($query);

if (!$result) {
    die("Query Error: " . mysql_error());
}

// print data
while ($row = mysql_fetch_assoc($result)) {
    print_r($row);
    echo "<br><br>";
}
?>
