<?php

try {
    $pdo = new PDO(
        "mysql:host=153.92.15.82;port=3306;dbname=u492381568_pupr",
        "u492381568_pupr",
        "Pupr123*#",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "PDO with explicit host: SUCCESS\n";
    
    $stmt = $pdo->query("SELECT USER() as user");
    print_r($stmt->fetch(PDO::FETCH_ASSOC));
    
} catch (PDOException $e) {
    echo "FAILED: " . $e->getMessage() . "\n";
}