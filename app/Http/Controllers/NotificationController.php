<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'count' => Notification::notRead()->count(),
                'notifications' => Notification::latest()->limit(5)->get(),
            ]);
        }

        return view('dashboard.notification', ['notifications' => Notification::latest()->get()]);
    }
}
