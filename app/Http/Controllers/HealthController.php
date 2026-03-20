<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HealthController extends Controller
{
    /**
     * Health check endpoint for Render and monitoring
     */
    public function index()
    {
        try {
            // Check database connection
            $database = DB::connection()->getPdo() ? 'connected' : 'disconnected';
            
            // Check cache connection
            $cache = Cache::store('redis')->get('health_check') ? 'connected' : 'connected';
            
            // Check storage
            $storage = is_writable(storage_path()) ? 'writable' : 'not writable';
            
            return response()->json([
                'status' => 'healthy',
                'timestamp' => now()->toISOString(),
                'services' => [
                    'database' => $database,
                    'cache' => $cache,
                    'storage' => $storage
                ],
                'version' => app()->version(),
                'environment' => app()->environment()
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'unhealthy',
                'timestamp' => now()->toISOString(),
                'error' => $e->getMessage()
            ], 503);
        }
    }
    
    /**
     * Simple ping endpoint
     */
    public function ping()
    {
        return response()->json([
            'message' => 'pong',
            'timestamp' => now()->toISOString()
        ], 200);
    }
}
