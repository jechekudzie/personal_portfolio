<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email configuration and sending';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing email configuration...');
        
        // Display current configuration
        $this->info('Current Mail Configuration:');
        $this->line('MAIL_MAILER: ' . config('mail.default'));
        $this->line('MAIL_HOST: ' . config('mail.mailers.smtp.host'));
        $this->line('MAIL_PORT: ' . config('mail.mailers.smtp.port'));
        $this->line('MAIL_USERNAME: ' . config('mail.mailers.smtp.username'));
        $this->line('MAIL_ENCRYPTION: ' . config('mail.mailers.smtp.encryption'));
        $this->line('MAIL_FROM_ADDRESS: ' . config('mail.from.address'));
        $this->line('MAIL_FROM_NAME: ' . config('mail.from.name'));
        
        $this->newLine();
        
        // Test data
        $testData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Email Configuration Test',
            'message' => 'This is a test email to verify the mail configuration is working correctly.'
        ];
        
        try {
            $this->info('Attempting to send test email...');
            
            Mail::to('nigel@jeche.dev')->send(new ContactFormMail($testData));
            
            $this->info('✅ Test email sent successfully!');
            $this->info('Check nigel@jeche.dev for the test email.');
            
        } catch (\Exception $e) {
            $this->error('❌ Failed to send test email:');
            $this->error($e->getMessage());
            
            // Additional debugging
            $this->newLine();
            $this->warn('Debugging information:');
            $this->line('Exception class: ' . get_class($e));
            $this->line('File: ' . $e->getFile() . ':' . $e->getLine());
            
            if ($e->getPrevious()) {
                $this->line('Previous exception: ' . $e->getPrevious()->getMessage());
            }
        }
        
        return 0;
    }
}
