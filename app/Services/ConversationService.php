<?php

namespace App\Services;

use App\Ai\Agents\RecruitmentAgent;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Ai\Models\Conversation;
use Laravel\Ai\Models\ConversationMessage;

class ConversationService
{
    public function listForCandidate(User $user, Candidate $candidate): LengthAwarePaginator
    {
        return $user->conversations()
            ->where('candidate_id', $candidate->id)
            ->latest('updated_at')
            ->paginate(20);
    }

    public function startConversation(User $user, Candidate $candidate, string $message): array
    {
        $agent = (new RecruitmentAgent)->forUser($user);

        $title = 'Chat about '.$candidate->name;

        $response = $agent->prompt($message);

        $conversationId = $agent->currentConversation();

        if ($conversationId) {
            Conversation::where('id', $conversationId)->update([
                'candidate_id' => $candidate->id,
                'title' => $title,
            ]);
        }

        return [
            'conversation_id' => $conversationId,
            'response' => $response->text,
        ];
    }

    public function sendMessage(string $conversationId, User $user, string $message): array
    {
        $agent = (new RecruitmentAgent)->continue($conversationId, as: $user);

        $response = $agent->prompt($message);

        return [
            'conversation_id' => $conversationId,
            'response' => $response->text,
        ];
    }

    public function getMessages(string $conversationId): array
    {
        return ConversationMessage::where('conversation_id', $conversationId)
            ->orderBy('created_at')
            ->get()
            ->toArray();
    }

    public function findConversation(string $conversationId): ?Conversation
    {
        return Conversation::find($conversationId);
    }
}
