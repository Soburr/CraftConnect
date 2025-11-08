<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientManagementController extends Controller
{
    /**
     * Display list of all clients
     */
    public function index()
    {
        $clients = User::where('role', 'client')->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Display a single client details
     */
    public function show($id)
    {
        $client = User::with('client')->where('role', 'client')->findOrFail($id);

        // Paginate bookings & reviews
        $clientBookings = $client->client->bookings()->with('artisan.user')->paginate(5);
        $clientReviews = $client->client->reviews()->with('artisan.user')->paginate(5);

        return view('admin.clients.show', compact('client', 'clientBookings', 'clientReviews'));
    }

    /**
     * Delete a client
     */
    public function destroy($id)
    {
        $client = User::where('role', 'client')->findOrFail($id);
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully.');
    }


}
