<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::query()
            ->orderByDesc('created_at')
            ->limit(200)
            ->get();

        return view('admin.messages.index', compact('messages'));
    }
}
