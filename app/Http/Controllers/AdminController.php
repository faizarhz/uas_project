<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalProducts' => Product::count(),
            'totalMessages' => ContactMessage::count(),
            'totalStock' => Product::sum('stock'),
        ]);
    }

    public function messages()
    {
        $messages = ContactMessage::latest()->get();

        return view('admin.messages', compact('messages'));
    }

    public function readMessage($id)
    {
        $message = ContactMessage::findOrFail($id);

        $message->update(['is_read' => true]);

        return view('admin.message-detail', compact('message'));
    }

    public function deleteMessage($id)
    {
        ContactMessage::findOrFail($id)->delete();

        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
