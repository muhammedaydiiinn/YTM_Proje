<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use App\Repositories\PlayerProfileRepo;

class PlayerAnalysisController extends Controller
{
    protected $playerRepository;
    protected $geminiService;

    // Constructor injection
    public function __construct(PlayerProfileRepo $playerRepository, GeminiService $geminiService)
    {
        $this->playerRepository = $playerRepository;
        $this->geminiService = $geminiService;
    }

    // Player Analysis method
    public function analyzePlayer($id)
    {

        // Player details by id
        $playerDetails = $this->playerRepository->getPlayerDetailsById($id);
        // Check if player details are found
        if (!$playerDetails) {
            return response()->json(['error' => 'Player not found'], 404);
        }

        // Send player details to Gemini API for analysis
        $analysisResult = $this->geminiService->analyzePlayer($playerDetails);

        // Eğer yanıt başarılıysa, veriyi döndür
        return response()->json($analysisResult, 200);
    }

    // Button trigger for analysis (optional for frontend interaction)
    public function triggerAnalysisButton($id)
    {
        return $this->analyzePlayer($id);
    }
}

