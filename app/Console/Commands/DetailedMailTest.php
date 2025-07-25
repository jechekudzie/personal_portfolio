<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class DetailedMailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:detailed-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detailed mail testing with various configurations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Detailed Mail Server Testing');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->newLine();
        
        // Test different configurations
        $configs = [
            ['port' => 465, 'encryption' => 'ssl'],
            ['port' => 587, 'encryption' => 'tls'],
            ['port' => 25, 'encryption' => null],
            ['port' => 2525, 'encryption' => 'tls'],
        ];
        
        foreach ($configs as $config) {
            $this->info("Testing Port {$config['port']} with " . ($config['encryption'] ?: 'no') . " encryption...");
            
            // Temporarily override config
            config([
                'mail.mailers.smtp.port' => $config['port'],
                'mail.mailers.smtp.encryption' => $config['encryption']
            ]);
            
            $testData = [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'subject' => "Test Email - Port {$config['port']}",
                'message' => 'This is a test email to verify mail configuration.'
            ];
            
            try {
                // Set a shorter timeout for faster testing
                $originalTimeout = ini_get('default_socket_timeout');
                ini_set('default_socket_timeout', 10);
                
                Mail::to('nigel@jeche.dev')->send(new ContactFormMail($testData));
                
                $this->info("✅ Port {$config['port']} ({$config['encryption']}): SUCCESS");
                
                // Restore timeout
                ini_set('default_socket_timeout', $originalTimeout);
                
                // If one works, we can stop testing
                $this->info('🎉 Found working configuration!');
                break;
                
            } catch (\Exception $e) {
                $this->error("❌ Port {$config['port']} ({$config['encryption']}): " . $e->getMessage());
                
                // Restore timeout
                ini_set('default_socket_timeout', $originalTimeout);
            }
            
            $this->newLine();
        }
        
        $this->newLine();
        $this->info('Testing alternative approaches...');
        
        // Test with different stream context options
        $this->line('Testing with relaxed SSL verification...');
        
        config([
            'mail.mailers.smtp.port' => 465,
            'mail.mailers.smtp.encryption' => 'ssl',
            'mail.mailers.smtp.stream' => [
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'crypto_method' => STREAM_CRYPTO_METHOD_TLS_CLIENT,
                ]
            ]
        ]);
        
        try {
            $testData = [
                'name' => 'Test User - Relaxed SSL',
                'email' => 'test@example.com', 
                'subject' => 'Test Email - Relaxed SSL',
                'message' => 'Testing with relaxed SSL verification.'
            ];
            
            Mail::to('nigel@jeche.dev')->send(new ContactFormMail($testData));
            $this->info('✅ Relaxed SSL verification: SUCCESS');
            
        } catch (\Exception $e) {
            $this->error('❌ Relaxed SSL verification: ' . $e->getMessage());
        }
        
        return 0;
    }
}
