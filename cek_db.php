<?php

$host = "153.92.15.82";
$user = "u492381568_pupr";
$pass = "Pupr123*#";
$db   = "u492381568_pupr";
$port = 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("❌ Koneksi gagal: " . mysqli_connect_error());
}

echo "✅ Koneksi berhasil!<br>";

// Query ke tabel menus
$result = mysqli_query($conn, "SELECT * FROM menus WHERE status = 'active' AND parent_id IS NULL ORDER BY `order` ASC");

if ($result) {
    echo "✅ Query menus berhasil!<br>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "- " . $row['name'] . "<br>";
    }
} else {
    echo "❌ Query gagal: " . mysqli_error($conn);
}

mysqli_close($conn);