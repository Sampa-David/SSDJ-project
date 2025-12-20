<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display all conversations for client
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $conversations = $user->conversations()
            ->with('admin', 'messages')
            ->latest('updated_at')
            ->paginate(10);

        return view('messages.index', compact('conversations'));
    }

    /**
     * Display conversations for admin
     */
    public function adminConversations()
    {
        if (Auth::user()->email !== 'admin@gmail.com') {
            abort(403);
        }

        $conversations = Conversation::with('user', 'messages')
            ->latest('updated_at')
            ->paginate(10);

        return view('messages.admin-conversations', compact('conversations'));
    }

    /**
     * Show a specific conversation with all messages
     */
    public function show(Conversation $conversation)
    {
        // Check if user is participant
        if (!$conversation->isParticipant(Auth::id())) {
            abort(403);
        }

        // Mark messages as read
        $conversation->markAsRead(Auth::id());

        $messages = $conversation->messages()->paginate(20);

        return view('messages.show', compact('conversation', 'messages'));
    }

    /**
     * Create a new conversation (client side)
     */
    public function create()
    {
        $admins = User::where('email', 'admin@gmail.com')->get();

        return view('messages.create', compact('admins'));
    }

    /**
     * Show form to create conversation from admin
     */
    public function createFromAdmin()
    {
        if (Auth::user()->email !== 'admin@gmail.com') {
            abort(403);
        }

        $clients = User::where('email', '!=', 'admin@gmail.com')->get();

        return view('messages.create-admin', compact('clients'));
    }

    /**
     * Store a new conversation
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'priority' => 'nullable|in:low,medium,high',
            'client_id' => 'nullable|exists:users,id', // For admin creating conversation
        ]);

        try {
            // Determine who is the user and who is the admin
            $isAdmin = Auth::user()->email === 'admin@gmail.com';
            $userId = $request->filled('client_id') ? $request->client_id : Auth::id();
            $adminId = $isAdmin ? Auth::id() : null;

            // Create conversation
            $conversation = Conversation::create([
                'user_id' => $userId,
                'admin_id' => $adminId,
                'subject' => $request->subject,
                'priority' => $request->priority ?? 'medium',
                'status' => $isAdmin ? 'open' : 'pending',
            ]);

            // Create first message
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'body' => $request->message,
            ]);

            $routeName = $isAdmin ? 'admin.messages.show' : 'messages.show';
            
            return redirect()->route($routeName, $conversation)
                ->with('success', 'Conversation created successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error creating conversation: ' . $e->getMessage()]);
        }
    }

    /**
     * Store a new message in conversation
     */
    public function storeMessage(Request $request, Conversation $conversation)
    {
        // Check if user is participant
        if (!$conversation->isParticipant(Auth::id())) {
            abort(403);
        }

        $request->validate([
            'body' => 'required|string|min:1',
        ]);

        try {
            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'body' => $request->body,
            ]);

            $conversation->touch(); // Update updated_at

            return redirect()->route('messages.show', $conversation)
                ->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error sending message: ' . $e->getMessage()]);
        }
    }

    /**
     * Assign conversation to admin
     */
    public function assignToAdmin(Request $request, Conversation $conversation)
    {
        if (Auth::user()->email !== 'admin@gmail.com') {
            abort(403);
        }

        $request->validate([
            'admin_id' => 'required|exists:users,id',
        ]);

        try {
            $conversation->update([
                'admin_id' => $request->admin_id,
                'status' => 'open',
            ]);

            return redirect()->route('messages.show', $conversation)
                ->with('success', 'Conversation assigned successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error assigning conversation: ' . $e->getMessage()]);
        }
    }

    /**
     * Close conversation
     */
    public function close(Conversation $conversation)
    {
        // Check if user is participant
        if (!$conversation->isParticipant(Auth::id())) {
            abort(403);
        }

        $conversation->update(['status' => 'closed']);

        return redirect()->route('messages.index')
            ->with('success', 'Conversation closed successfully!');
    }

    /**
     * Reopen conversation
     */
    public function reopen(Conversation $conversation)
    {
        // Check if user is participant
        if (!$conversation->isParticipant(Auth::id())) {
            abort(403);
        }

        $conversation->update(['status' => 'open']);

        return redirect()->route('messages.show', $conversation)
            ->with('success', 'Conversation reopened successfully!');
    }

    /**
     * Delete conversation (admin only)
     */
    public function destroy(Conversation $conversation)
    {
        if (Auth::user()->email !== 'admin@gmail.com') {
            abort(403);
        }

        $conversation->delete();

        return redirect()->route('messages.admin-conversations')
            ->with('success', 'Conversation deleted successfully!');
    }
}
