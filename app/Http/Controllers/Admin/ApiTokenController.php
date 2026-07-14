<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    /**
     * List every token in the system (grouped by owner) plus the issue form.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();

        $tokens = \Laravel\Sanctum\PersonalAccessToken::with('tokenable')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.tokens.index', compact('users', 'tokens'));
    }

    /**
     * Issue a new token, e.g. for the Python scraper hitting the Laravel API.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'name'       => 'required|string|max:255',
            'abilities'  => 'nullable|string|max:255',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $user = User::findOrFail($data['user_id']);

        $abilities = ! empty($data['abilities'])
            ? array_map('trim', explode(',', $data['abilities']))
            : ['*'];

        $expiresAt = ! empty($data['expires_at'])
            ? \Illuminate\Support\Carbon::parse($data['expires_at'])
            : null;

        $newToken = $user->createToken($data['name'], $abilities, $expiresAt);

        // Plaintext token is only ever available right after creation.
        return redirect()->route('admin.tokens.index')
            ->with('success', 'Token API berhasil dibuat. Salin sekarang — token tidak akan ditampilkan lagi.')
            ->with('plainTextToken', $newToken->plainTextToken)
            ->with('plainTextTokenName', $data['name']);
    }

    public function destroy(\Laravel\Sanctum\PersonalAccessToken $token)
    {
        $token->delete();

        return redirect()->route('admin.tokens.index')
            ->with('success', 'Token API berhasil dicabut.');
    }
}
