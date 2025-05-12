<?php
$secrets = include __DIR__ . '/secret.php';
$conn = new mysqli(
    $secrets['DB_HOST'], $secrets['DB_USER'],
    $secrets['DB_PASS'], $secrets['DB_NAME']
);
$schema_sql = file_get_contents(__DIR__ . '/schema.sql');
$seed_sql = file_get_contents(__DIR__ . '/seed.sql');
$mixed_sql = $schema_sql . "\n" . $seed_sql;

try {
    $conn->multi_query($mixed_sql);
    echo "✅ Executed all queries\n";
    $conn->close();
    exit(0);
} catch (Exception $err) {
    echo '❌ Error: ' . $err->getMessage() . "\n";
    $conn->close();
    exit(1);
}
