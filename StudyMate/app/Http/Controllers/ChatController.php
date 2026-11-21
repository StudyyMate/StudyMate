<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $partnerIds = Chat::query()
            ->where('id_pengirim', $userId)
            ->orWhere('id_penerima', $userId)
            ->orderByDesc('waktu_kirim')
            ->get()
            ->map(fn (Chat $chat) => $chat->id_pengirim === $userId
                ? $chat->id_penerima
                : $chat->id_pengirim)
            ->unique()
            ->values();

        $threads = User::query()
            ->whereIn('id_user', $partnerIds)
            ->get()
            ->map(function (User $partner) use ($userId) {
                $lastMessage = Chat::query()
                    ->where(function ($query) use ($userId, $partner) {
                        $query->where('id_pengirim', $userId)->where('id_penerima', $partner->id_user);
                    })
                    ->orWhere(function ($query) use ($userId, $partner) {
                        $query->where('id_pengirim', $partner->id_user)->where('id_penerima', $userId);
                    })
                    ->latest('waktu_kirim')
                    ->first();

                $partner->last_message = $lastMessage;
                return $partner;
            })
            ->sortByDesc(fn (User $partner) => $partner->last_message?->waktu_kirim)
            ->values();

        return view('chat', compact('threads'));
    }

    public function room(User $partner): View
    {
        abort_if($partner->id_user === auth()->id(), 404);

        return view('chat-room', compact('partner'));
    }

    public function messages(User $partner): JsonResponse
    {
        abort_if($partner->id_user === auth()->id(), 404);

        $messages = Chat::query()
            ->where(function ($query) use ($partner) {
                $query->where('id_pengirim', auth()->id())
                    ->where('id_penerima', $partner->id_user);
            })
            ->orWhere(function ($query) use ($partner) {
                $query->where('id_pengirim', $partner->id_user)
                    ->where('id_penerima', auth()->id());
            })
            ->orderBy('waktu_kirim')
            ->get()
            ->map(fn (Chat $chat) => [
                'id' => $chat->id_chat,
                'message' => $chat->pesan,
                'outgoing' => $chat->id_pengirim === auth()->id(),
                'time' => $chat->waktu_kirim?->format('H.i'),
            ]);

        return response()->json(['messages' => $messages]);
    }

    public function send(Request $request, User $partner): JsonResponse
    {
        abort_if($partner->id_user === auth()->id(), 404);

        $data = $request->validate([
            'pesan' => ['required', 'string', 'max:2000'],
        ]);

        $chat = Chat::create([
            'id_pengirim' => auth()->id(),
            'id_penerima' => $partner->id_user,
            'pesan' => trim($data['pesan']),
        ]);

        return response()->json([
            'message' => [
                'id' => $chat->id_chat,
                'message' => $chat->pesan,
                'outgoing' => true,
                'time' => $chat->waktu_kirim?->format('H.i'),
            ],
        ], 201);
    }
}
