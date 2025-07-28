<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ViewContactSubmissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contacts:view {--recent : Show only recent submissions (last 10)} {--follow : Follow the log file for real-time updates}';

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
        $logFile = storage_path('logs/contact-form.log');
        
        if (!File::exists($logFile)) {
            $this->error('No contact form log file found.');
            return 1;
        }

        $this->info('🔍 Contact Form Submissions');
        $this->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        if ($this->option('follow')) {
            $this->followLog($logFile);
        } else {
            $this->displayLogs($logFile);
        }

        return 0;
    }

    private function displayLogs($logFile)
    {
        $lines = File::lines($logFile);
        $submissions = [];
        
        foreach ($lines as $line) {
            $data = json_decode(trim($line), true);
            if ($data) {
                $submissions[] = $data;
            }
        }

        if (empty($submissions)) {
            $this->warn('No submissions found.');
            return;
        }

        // Sort by timestamp (newest first)
        usort($submissions, function($a, $b) {
            return strtotime($b['timestamp'] ?? '') - strtotime($a['timestamp'] ?? '');
        });

        if ($this->option('recent')) {
            $submissions = array_slice($submissions, 0, 10);
        }

        foreach ($submissions as $submission) {
            $this->displaySubmission($submission);
            $this->line('');
        }
    }

    private function displaySubmission($submission)
    {
        if (isset($submission['error'])) {
            $this->error('❌ Email Error: ' . $submission['error']);
            $this->line('   Message: ' . $submission['message']);
            if (isset($submission['contact_data'])) {
                $this->displayContactData($submission['contact_data']);
            }
            return;
        }

        $this->displayContactData($submission);
    }

    private function displayContactData($data)
    {
        $this->line('📅 <fg=yellow>' . ($data['timestamp'] ?? 'Unknown') . '</>');
        $this->line('👤 <fg=green>Name:</> ' . ($data['name'] ?? 'N/A'));
        $this->line('📧 <fg=blue>Email:</> ' . ($data['email'] ?? 'N/A'));
        $this->line('📋 <fg=magenta>Subject:</> ' . ($data['subject'] ?? 'N/A'));
        $this->line('💬 <fg=cyan>Message:</>');
        $this->line('   ' . wordwrap($data['message'] ?? 'N/A', 60, "\n   "));
        
        if (isset($data['ip'])) {
            $this->line('🌐 <fg=gray>IP:</> ' . $data['ip']);
        }
    }

    private function followLog($logFile)
    {
        $this->info('Following contact form log file... (Press Ctrl+C to stop)');
        $this->line('');

        $lastSize = File::size($logFile);
        
        while (true) {
            clearstatcache();
            $currentSize = File::size($logFile);
            
            if ($currentSize > $lastSize) {
                $newContent = File::get($logFile);
                $newLines = array_slice(explode("\n", $newContent), -1);
                
                foreach ($newLines as $line) {
                    if (trim($line)) {
                        $data = json_decode(trim($line), true);
                        if ($data) {
                            $this->line('🆕 <fg=green>NEW SUBMISSION:</>');
                            $this->displaySubmission($data);
                            $this->line('');
                        }
                    }
                }
                
                $lastSize = $currentSize;
            }
            
            sleep(1);
        }
    }
}
