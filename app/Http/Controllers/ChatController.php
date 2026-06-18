<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\JobOffer;
use App\Services\ConversationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function __construct(
        private readonly ConversationService $conversationService,
    ) {}

    public function index(JobOffer $jobOffer, Candidate $candidate): View
    {
        $this->authorize('view', $candidate);

        $conversations = $this->conversationService->listForCandidate(
            request()->user(),
            $candidate,
        );

        return view('chat.index', compact('jobOffer', 'candidate', 'conversations'));
    }

    public function show(JobOffer $jobOffer, Candidate $candidate, string $conversation): View
    {
        $this->authorize('view', $candidate);

        $conversationModel = $this->conversationService->findConversation($conversation);

        abort_unless($conversationModel, 404);

        $messages = $this->conversationService->getMessages($conversation);

        return view('chat.show', compact('jobOffer', 'candidate', 'conversationModel', 'messages'));
    }

    public function store(Request $request, JobOffer $jobOffer, Candidate $candidate): RedirectResponse
    {
        $this->authorize('view', $candidate);

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        if ($request->has('conversation_id')) {
            $result = $this->conversationService->sendMessage(
                $request->input('conversation_id'),
                $request->user(),
                $validated['message'],
            );
        } else {
            $result = $this->conversationService->startConversation(
                $request->user(),
                $candidate,
                $validated['message'],
            );
        }

        return redirect()->route('job-offers.candidates.chat.show', [
            $jobOffer,
            $candidate,
            $result['conversation_id'],
        ]);
    }
}
