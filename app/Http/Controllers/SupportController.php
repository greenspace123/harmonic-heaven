<?php
// app/Http/Controllers/SupportController.php
namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function send(Request $request) {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'email' => 'required|email',
            'name' => 'nullable|string|max:255'
        ]);
        
        $feedback = new Feedback();
        $feedback->subject = $request->subject;
        $feedback->message = $request->message;
        $feedback->email = $request->email;
        $feedback->name = $request->name ?? 'Anonymous';
        
        if (Auth::check()) {
            $feedback->user_id = Auth::id();
            $feedback->name = Auth::user()->name;
            $feedback->email = Auth::user()->email;
        }
        
        $feedback->save();
        
        return back()->with('success', 'Ваше сообщение отправлено! Мы ответим в течение 24 часов.');
    }
}