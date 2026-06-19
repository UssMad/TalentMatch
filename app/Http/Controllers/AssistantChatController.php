<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssistantChatController extends Controller
{
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'candidate_id' => ['nullable', 'integer', 'exists:candidates,id'],
            'history' => ['nullable', 'array'],
            'history.*.role' => ['string', 'in:user,assistant'],
            'history.*.content' => ['string'],
        ]);

        $message = $validated['message'];

        $reply = $this->generateReply($message, $validated['candidate_id'] ?? null);

        return response()->json(['reply' => $reply]);
    }

    private function generateReply(string $message, ?int $candidateId): string
    {
        $context = '';

        if ($candidateId) {
            $candidate = Candidate::with(['analyses', 'jobOffer'])->find($candidateId);

            if ($candidate) {
                $analysis = $candidate->analyses->where('job_offer_id', $candidate->job_offer_id)->first();

                $context = "Contexte : Candidat {$candidate->name}";

                if ($analysis && $analysis->matching_score > 0) {
                    $sd = $analysis->structured_data;
                    $context .= ", score {$analysis->matching_score}/100, recommandation {$analysis->recommendation?->value}";
                    $context .= ', forces : '.implode(', ', $sd['strengths'] ?? []);
                    $context .= ', faiblesses : '.implode(', ', $sd['weaknesses'] ?? []);
                }
            }
        }

        $prompt = $context ? "$context\n\nQuestion : $message" : $message;

        return $this->getAIResponse($prompt);
    }

    private function getAIResponse(string $prompt): string
    {
        $knowledge = [
            'score' => 'Le score de correspondance est calculé en comparant les compétences extraites du CV avec les compétences requises dans l\'offre d\'emploi. Il prend en compte l\'expérience, la formation et les compétences techniques.',
            'entretien' => 'Voici des suggestions de questions d\'entretien adaptées à ce profil : 1. Parlez-moi d\'un projet complexe que vous avez mené. 2. Comment gérez-vous les priorités concurrentes ? 3. Quelle est votre approche pour apprendre une nouvelle technologie ? 4. Décrivez une situation où vous avez dû convaincre une équipe.',
            'comparer' => 'Pour comparer efficacement deux candidats, examinez : leur score de correspondance, leurs points forts respectifs, leurs lacunes, leur niveau d\'expérience et leurs compétences spécifiques par rapport aux exigences du poste.',
        ];

        $promptLower = mb_strtolower($prompt);

        if (str_contains($promptLower, 'score') || str_contains($promptLower, 'note')) {
            return $knowledge['score'];
        }

        if (str_contains($promptLower, 'entretien') || str_contains($promptLower, 'question')) {
            return $knowledge['entretien'];
        }

        if (str_contains($promptLower, 'compar') || str_contains($promptLower, 'autre')) {
            return $knowledge['comparer'];
        }

        return "Merci pour votre question. Pour vous fournir une réponse précise, je peux vous aider à analyser le score de correspondance, préparer des questions d'entretien, ou comparer des profils. Que souhaitez-vous savoir ?";
    }
}
