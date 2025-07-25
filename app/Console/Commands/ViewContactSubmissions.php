<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ViewContactSubmissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contacts:view {--recent=10 : Number of recent submissions to show}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View contact form submissions from logs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $recent = $this->option('recent');
        $logPath = storage_path('logs');
        
        $this->info('🔍 Contact Form Submissions');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->newLine();
        
        // Get all log files
        $logFiles = glob($logPath . '/laravel-*.log');
        
        if (empty($logFiles)) {
            $this->warn('No log files found.');
            return 0;
        }
        
        // Sort by modification time (newest first)
        usort($logFiles, function($a, $b) {
            return filemtime($b) - filemtime($a);
        });
        
        $submissions = [];
        
        foreach ($logFiles as $logFile) {
            $content = file_get_contents($logFile);
            
            // Look for contact form submissions
            $pattern = '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\].*?Contact form submission.*?({.*?})\s*$/m';
            
            if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $timestamp = $match[1];
                    $data = json_decode($match[2], true);
                    
                    if ($data) {
                        $submissions[] = [
                            'timestamp' => $timestamp,
                            'data' => $data,
                            'file' => basename($logFile)
                        ];
                    }
                }
            }
            
            // Also look for manual follow-up entries
            $followUpPattern = '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\].*?IMPORTANT - Manual follow-up required.*?contact_data.*?({.*?})\s*$/m';
            
            if (preg_match_all($followUpPattern, $content, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $timestamp = $match[1];
                    $jsonData = $match[2];
                    
                    // Extract the contact_data from the JSON
                    if (preg_match('/"contact_data":\s*({[^}]+})/', $jsonData, $contactMatch)) {
                        $data = json_decode($contactMatch[1], true);
                        
                        if ($data) {
                            $submissions[] = [
                                'timestamp' => $timestamp,
                                'data' => $data,
                                'file' => basename($logFile),
                                'requires_followup' => true
                            ];
                        }
                    }
                }
            }
        }
        
        // Sort by timestamp (newest first)
        usort($submissions, function($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });
        
        // Limit results
        $submissions = array_slice($submissions, 0, $recent);
        
        if (empty($submissions)) {
            $this->warn('No contact form submissions found in logs.');
            return 0;
        }
        
        $this->info("Showing {$recent} most recent submissions:");
        $this->newLine();
        
        foreach ($submissions as $index => $submission) {
            $data = $submission['data'];
            $followUp = isset($submission['requires_followup']) ? '⚠️  NEEDS FOLLOW-UP' : '✅ Processed';
            
            $this->line("📧 Submission #" . ($index + 1) . " - {$followUp}");
            $this->line("📅 Date: {$submission['timestamp']}");
            $this->line("👤 Name: {$data['name']}");
            $this->line("📧 Email: {$data['email']}");
            $this->line("📋 Subject: {$data['subject']}");
            $this->line("💬 Message: " . substr($data['message'], 0, 100) . (strlen($data['message']) > 100 ? '...' : ''));
            $this->line("📄 Log: {$submission['file']}");
            $this->newLine();
        }
        
        return 0;
    }
}
