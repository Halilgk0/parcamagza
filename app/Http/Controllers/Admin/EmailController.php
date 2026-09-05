<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::where('is_active', true)->get();
        $templates = EmailTemplate::where('is_active', true)->get();
        return view('admin.emails.index', compact('users', 'templates'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'recipients' => 'required|string',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'template_id' => 'nullable|exists:email_templates,id',
        ]);

        try {
            // Eğer şablon seçildiyse onu kullan
            $subject = $request->subject;
            $message = $request->message;
            $template = null;
            
            if ($request->filled('template_id')) {
                $template = EmailTemplate::findOrFail($request->template_id);
                $subject = $template->subject;
                $message = $template->body;
            }
            
            // Hem şablon hem mesaj boşsa hata ver
            if (empty($message) && empty($template)) {
                return back()->withErrors(['message' => 'Lütfen bir mesaj girin veya şablon seçin.'])->withInput();
            }

            // Check if the "all" option is selected
            if ($request->recipients === 'all') {
                // Get all active users
                $users = User::where('is_active', true)->get();
            } else {
                // Get the selected user
                $users = User::where('id', $request->recipients)->get();
            }

            $sentCount = 0;
            foreach ($users as $user) {
                // E-posta içeriğindeki değişkenleri değiştir
                $personalizedSubject = $this->replaceVariables($subject, $user);
                $personalizedMessage = $this->replaceVariables($message, $user);
                
                // Eğer şablon HTML formatında ise HTML olarak gönder
                if ($template) {
                    Mail::html($personalizedMessage, function ($message) use ($personalizedSubject, $user) {
                        $message->to($user->email)
                                ->subject($personalizedSubject);
                    });
                } else {
                    Mail::raw($personalizedMessage, function ($message) use ($personalizedSubject, $user) {
                        $message->to($user->email)
                                ->subject($personalizedSubject);
                    });
                }
                $sentCount++;
            }

            return back()->with('success', $sentCount . ' kullanıcıya e-posta başarıyla gönderildi.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'E-posta gönderilirken bir hata oluştu: ' . $e->getMessage()])->withInput();
        }
    }
    
    /**
     * E-posta içeriğindeki değişkenleri değiştir
     */
    private function replaceVariables($content, $user)
    {
        $replacements = [
            '{ad}' => $user->name,
            '{email}' => $user->email,
            '{site_adi}' => config('app.name', 'Parca Magaza'),
        ];
        
        return str_replace(array_keys($replacements), array_values($replacements), $content);
    }
} 