<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewLoggedEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:view {--recent : Show only recent emails (last 5)} {--follow : Follow the log file for real-time updates}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View logged emails from Laravel log';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!File::exists($logFile)) {
            $this->error('No Laravel log file found.');
            return 1;
        }

        $this->info('📧 Logged Emails');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        if ($this->option('follow')) {
            $this->followLog($logFile);
        } else {
            $this->displayEmails($logFile);
        }

        return 0;
    }

    private function displayEmails($logFile)
    {
        $content = File::get($logFile);
        $emails = $this->extractEmails($content);

        if (empty($emails)) {
            $this->warn('No emails found in log.');
            return;
        }

        // Sort by timestamp (newest first)
        usort($emails, function($a, $b) {
            return strtotime($b['timestamp'] ?? '') - strtotime($a['timestamp'] ?? '');
        });

        if ($this->option('recent')) {
            $emails = array_slice($emails, 0, 5);
        }

        foreach ($emails as $email) {
            $this->displayEmail($email);
            $this->line('');
        }
    }

    private function extractEmails($content)
    {
        $emails = [];
        $lines = explode("\n", $content);
        
        $currentEmail = null;
        $inEmail = false;
        
        foreach ($lines as $line) {
            // Look for email start
            if (strpos($line, 'Date:') !== false && strpos($line, '+0000') !== false) {
                $inEmail = true;
                $currentEmail = [
                    'timestamp' => trim(str_replace('Date:', '', $line)),
                    'content' => []
                ];
                continue;
            }
            
            // Look for email end
            if ($inEmail && (strpos($line, '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━') !== false || 
                           strpos($line, '[2025-') !== false)) {
                $inEmail = false;
                if ($currentEmail && !empty($currentEmail['content'])) {
                    $emails[] = $currentEmail;
                }
                $currentEmail = null;
                continue;
            }
            
            // Collect email content
            if ($inEmail && $currentEmail) {
                $currentEmail['content'][] = $line;
            }
        }
        
        // Add last email if still in progress
        if ($inEmail && $currentEmail && !empty($currentEmail['content'])) {
            $emails[] = $currentEmail;
        }
        
        return $emails;
    }

    private function displayEmail($email)
    {
        $this->line('📅 <fg=yellow>' . ($email['timestamp'] ?? 'Unknown') . '</>');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        
        $content = implode("\n", $email['content']);
        
        // Extract subject if available
        if (preg_match('/Subject:\s*(.+)/', $content, $matches)) {
            $this->line('📋 <fg=magenta>Subject:</> ' . trim($matches[1]));
        }
        
        // Extract to if available
        if (preg_match('/To:\s*(.+)/', $content, $matches)) {
            $this->line('📧 <fg=blue>To:</> ' . trim($matches[1]));
        }
        
        // Show first 200 characters of content
        $textContent = strip_tags($content);
        $textContent = preg_replace('/\s+/', ' ', $textContent);
        $textContent = trim($textContent);
        
        if (strlen($textContent) > 200) {
            $textContent = substr($textContent, 0, 200) . '...';
        }
        
        $this->line('💬 <fg=cyan>Content:</>');
        $this->line('   ' . wordwrap($textContent, 60, "\n   "));
    }

    private function followLog($logFile)
    {
        $this->info('Following email log file... (Press Ctrl+C to stop)');
        $this->line('');

        $lastSize = File::size($logFile);
        
        while (true) {
            clearstatcache();
            $currentSize = File::size($logFile);
            
            if ($currentSize > $lastSize) {
                $newContent = File::get($logFile);
                $newLines = array_slice(explode("\n", $newContent), -50);
                
                $emails = $this->extractEmails(implode("\n", $newLines));
                
                foreach ($emails as $email) {
                    $this->line('🆕 <fg=green>NEW EMAIL:</>');
                    $this->displayEmail($email);
                    $this->line('');
                }
                
                $lastSize = $currentSize;
            }
            
            sleep(2);
        }
    }
}
