<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $contacts = User::where('id', '!=', Auth::id())->orderBy('name')->get();

        return view('chat.index', [
            'contacts' => $contacts,
        ]);
    }

    public function show(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('chat.index');
        }

        $messages = Message::where(function ($query) use ($user) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)->where('receiver_id', Auth::id());
        })->orderBy('created_at')->get();

        Message::where('sender_id', $user->id)->where('receiver_id', Auth::id())->update(['is_read' => true]);

        return view('chat.show', [
            'contact' => $user,
            'messages' => $messages,
        ]);
    }

    public function send(Request $request, User $user)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:1000'],
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'body' => $data['body'],
            'is_read' => false,
        ]);

        return redirect()->route('chat.show', ['user' => $user->id]);
    }
}
