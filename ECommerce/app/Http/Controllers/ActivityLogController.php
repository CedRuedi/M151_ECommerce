<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public static function log($action, $description = null)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'description' => $description,
            ]);
        }
    }

    public function index()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.activity_logs', compact('logs'));
    }
}
