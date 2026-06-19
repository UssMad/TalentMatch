<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\JobOffer;
use App\Services\ConversationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function __construct(
        private readonly ConversationService $conversationService,
    ) {}

    public function globalIndex(): View
    {
        $conversations = request()->user()->conversations()
            ->with('candidate')
            ->latest('updated_at')
            ->paginate(20);

        return view('chat.global-index', compact('conversations'));
    }

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

        try {
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
        } catch (\Exception $e) {
            Log::error('Chat AI error: '.$e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->route('job-offers.candidates.chat.index', [$jobOffer, $candidate])
                ->with('error', 'AI service is temporarily unavailable. Please try again.');
        }

        return redirect()->route('job-offers.candidates.chat.show', [
            $jobOffer,
            $candidate,
            $result['conversation_id'],
        ]);
    }
}
