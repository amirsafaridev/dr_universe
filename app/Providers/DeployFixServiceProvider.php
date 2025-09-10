<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class DeployFixServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->runDeployFix();
    }

    /**
     * Run deployment fix commands if not already executed
     */
    private function runDeployFix(): void
    {
        $deployDoneFile = base_path('.deploy_done');
        $logFile = base_path('deploy-fix.log');

        // Check if deployment has already been done
        if (File::exists($deployDoneFile)) {
            $this->logToFile($logFile, "Deploy fix already executed. Skipping...");
            return;
        }

        $this->logToFile($logFile, "Starting deployment fix process...");

        // Define all commands to execute
        $commands = [
            'sudo chmod -R 775 /var/www/html/storage',
            'sudo chmod -R 775 /var/www/html/bootstrap/cache',
            'mkdir -p /var/www/html/storage/framework/cache/data',
            'mkdir -p /var/www/html/storage/framework/sessions',
            'mkdir -p /var/www/html/storage/framework/views',
            'sudo chmod -R 775 /var/www/html/storage',
            'sudo chown -R www-data:www-data /var/www/html/storage',
            'sudo chmod -R 775 /var/www/html/storage',
            'sudo chown -R www-data:www-data /var/www/html/storage',
            'sudo chmod -R 777 /tmp',
            'php artisan cache:clear',
            'php artisan config:clear',
            'php artisan route:clear',
            'php artisan view:clear'
        ];

        $allCommandsSuccessful = true;

        // Execute each command
        foreach ($commands as $command) {
            $this->logToFile($logFile, "Executing: {$command}");
            
            $output = [];
            $returnCode = 0;
            
            // Execute command and capture output
            exec($command . ' 2>&1', $output, $returnCode);
            
            $status = ($returnCode === 0) ? 'SUCCESS' : 'FAILED';
            $this->logToFile($logFile, "Status: {$status}");
            
            if (!empty($output)) {
                $this->logToFile($logFile, "Output: " . implode("\n", $output));
            }
            
            if ($returnCode !== 0) {
                $allCommandsSuccessful = false;
                $this->logToFile($logFile, "Command failed with return code: {$returnCode}");
            }
            
            $this->logToFile($logFile, "---");
        }

        // Create .deploy_done file if all commands were successful
        if ($allCommandsSuccessful) {
            File::put($deployDoneFile, date('Y-m-d H:i:s') . ' - Deploy fix completed successfully');
            $this->logToFile($logFile, "All commands executed successfully. Created .deploy_done file.");
        } else {
            $this->logToFile($logFile, "Some commands failed. .deploy_done file not created.");
        }

        $this->logToFile($logFile, "Deployment fix process completed.");
    }

    /**
     * Log message to file with timestamp
     */
    private function logToFile(string $logFile, string $message): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[{$timestamp}] {$message}" . PHP_EOL;
        
        File::append($logFile, $logMessage);
    }
}
