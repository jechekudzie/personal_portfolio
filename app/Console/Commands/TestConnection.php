<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test-connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test SMTP connection to mail server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = 'mail.jeche.dev';
        $ports = [587, 25, 465, 2525];
        
        $this->info("Testing connection to {$host}...");
        $this->newLine();
        
        foreach ($ports as $port) {
            $this->line("Testing port {$port}...");
            
            $connection = @fsockopen($host, $port, $errno, $errstr, 10);
            
            if ($connection) {
                $this->info("✅ Port {$port}: Connection successful");
                fclose($connection);
            } else {
                $this->error("❌ Port {$port}: Connection failed - {$errstr} ({$errno})");
            }
        }
        
        $this->newLine();
        $this->info('Testing DNS resolution...');
        $ip = gethostbyname($host);
        
        if ($ip !== $host) {
            $this->info("✅ DNS resolution successful: {$host} -> {$ip}");
        } else {
            $this->error("❌ DNS resolution failed for {$host}");
        }
        
        return 0;
    }
}
