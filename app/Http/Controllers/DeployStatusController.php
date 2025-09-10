<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DeployStatusController extends Controller
{
    /**
     * Show deployment status and logs
     */
    public function index()
    {
        $deployDoneFile = base_path('.deploy_done');
        $logFile = base_path('deploy-fix.log');
        
        $isDeployed = File::exists($deployDoneFile);
        $deployTime = $isDeployed ? File::get($deployDoneFile) : null;
        
        $logContent = '';
        if (File::exists($logFile)) {
            $logContent = File::get($logFile);
        }
        
        return view('deploy-status', compact('isDeployed', 'deployTime', 'logContent'));
    }
    
    /**
     * Get deployment status as JSON
     */
    public function status()
    {
        $deployDoneFile = base_path('.deploy_done');
        $logFile = base_path('deploy-fix.log');
        
        $isDeployed = File::exists($deployDoneFile);
        $deployTime = $isDeployed ? File::get($deployDoneFile) : null;
        
        $logContent = '';
        if (File::exists($logFile)) {
            $logContent = File::get($logFile);
        }
        
        return response()->json([
            'is_deployed' => $isDeployed,
            'deploy_time' => $deployTime,
            'log_content' => $logContent,
            'log_file_exists' => File::exists($logFile)
        ]);
    }
    
    /**
     * Force re-run deployment (for testing)
     */
    public function forceRun()
    {
        $deployDoneFile = base_path('.deploy_done');
        
        // Remove .deploy_done file to force re-run
        if (File::exists($deployDoneFile)) {
            File::delete($deployDoneFile);
        }
        
        return response()->json([
            'message' => 'Deployment will run on next page refresh',
            'success' => true
        ]);
    }
}
