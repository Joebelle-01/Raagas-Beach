<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Log an administrative activity.
     *
     * @param string $action
     * @param string|null $description
     * @return void
     */
    protected function logActivity($action, $description = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'ip_address' => Request::ip(),
        ]);
    }
}
