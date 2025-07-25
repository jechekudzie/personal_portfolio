<?php

echo "Testing SMTP Connection to mail.jeche.dev\n";
echo "=========================================\n\n";

$host = 'mail.jeche.dev';
$username = 'web@jeche.dev';
$password = 'Incorrect@123!xx';

// Test different configurations
$configs = [
    ['port' => 465, 'protocol' => 'ssl'],
    ['port' => 587, 'protocol' => 'tls'],
    ['port' => 25, 'protocol' => 'tcp'],
];

foreach ($configs as $config) {
    echo "Testing {$config['protocol']}://{$host}:{$config['port']}\n";
    
    $context = stream_context_create([
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ]);
    
    $connection = @stream_socket_client(
        "{$config['protocol']}://{$host}:{$config['port']}", 
        $errno, 
        $errstr, 
        10, 
        STREAM_CLIENT_CONNECT,
        $context
    );
    
    if ($connection) {
        echo "✅ Connection successful on port {$config['port']} ({$config['protocol']})\n";
        
        // Try to read server greeting
        $response = fgets($connection, 512);
        echo "Server greeting: " . $response;
        
        fclose($connection);
        break;
    } else {
        echo "❌ Connection failed: {$errstr} ({$errno})\n";
    }
    
    echo "\n";
}

echo "Test completed.\n";
?>