<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserDeleteController extends Controller
{
    /**
     * Show delete users page with filters
     */
    public function show(Request $request)
    {
        $query = User::query();

        // Filter by name
        if ($request->has('search_name') && $request->search_name) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }

        // Filter by email
        if ($request->has('search_email') && $request->search_email) {
            $query->where('email', 'like', '%' . $request->search_email . '%');
        }

        // Filter by date from
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // Filter by date to
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by time from
        if ($request->has('time_from') && $request->time_from && $request->has('date_from') && $request->date_from) {
            $fromDateTime = $request->date_from . ' ' . $request->time_from;
            $query->where('created_at', '>=', $fromDateTime);
        }

        // Filter by time to
        if ($request->has('time_to') && $request->time_to && $request->has('date_to') && $request->date_to) {
            $toDateTime = $request->date_to . ' ' . $request->time_to . ':59';
            $query->where('created_at', '<=', $toDateTime);
        }

        $users = $query->paginate(20);

        return view('admin.users-delete', compact('users'));
    }

    /**
     * Delete single user
     */
    public function destroy(User $user)
    {
        // Prevent deleting admin user with id 1
        if ($user->id === 1) {
            return back()->with('error', 'Impossible de supprimer l\'utilisateur administrateur principal.');
        }

        try {
            $userName = $user->name;
            $user->delete();

            return back()->with('success', "L'utilisateur '$userName' a été supprimé avec succès.");
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    /**
     * Delete multiple users (bulk delete)
     */
    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|string'
        ]);

        try {
            $userIds = json_decode($validated['user_ids'], true);

            if (!is_array($userIds) || empty($userIds)) {
                return back()->with('error', 'Aucun utilisateur sélectionné.');
            }

            // Filter out admin user (id 1)
            $userIds = array_filter($userIds, function($id) {
                return $id != 1;
            });

            if (empty($userIds)) {
                return back()->with('error', 'Impossible de supprimer l\'utilisateur administrateur principal.');
            }

            $deletedCount = User::whereIn('id', $userIds)->delete();

            return back()->with('success', "$deletedCount utilisateur(s) ont été supprimés avec succès.");
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression en masse: ' . $e->getMessage());
        }
    }
}
