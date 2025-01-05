<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Players;
use App\Models\PlayerViewCount;
use App\Models\User;
use App\Repositories\PlayerProfileRepoInt;
use Illuminate\Http\Request;
use App\Models\Like;
use App\Services\PlayerService;


class PlayerController extends Controller
{
    protected $playerRepository;
    protected $playerService;

    public function __construct(PlayerProfileRepoInt $playerRepository, PlayerService $playerService)
    {
        $this->playerRepository = $playerRepository;
        $this->playerService = $playerService;
    }

    public function getPlayerProfilesById(Request $request)
    {
        $profile = $this->playerService->getPlayerById($request->input('id'));
        
        if (!$profile) {
            return response()->json(['error' => 'Player not found'], 404);
        }
        return response()->json($profile);
    }
    
    public function getPlayerProfilesByName(Request $request)
    {
        $profiles = $this->playerService->searchPlayersByName($request->input('name'));
        
        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($profiles);
    }

    public function getPlayerProfilesByAgeRange(Request $request)
    {
        $profiles = $this->playerService->searchPlayersByAgeRange(
            $request->input('min_age'),
            $request->input('max_age')
        );
        
        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($profiles);
    }

    public function getPlayerProfileByMainPosition(Request $request)
    {
        $profile = $this->playerService->searchPlayersByPosition($request->input('position'));
        
        if (!$profile) {
            return response()->json(['error' => 'Player not found'], 404);
        }
        return response()->json($profile);
    }

    public function getPlayerProfilesByNationality(Request $request)
    {
        $profiles = $this->playerService->searchPlayersByNationality($request->input('nationality'));
        
        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($profiles);
    }

    public function getPlayerProfilesByClub(Request $request)
    {
        $profiles = $this->playerService->searchPlayersByClub($request->input('club'));
        
        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($profiles);
    }

    public function getPlayerProfilesByFoot(Request $request)
    {
        $profiles = $this->playerService->searchPlayersByFoot($request->input('foot'));
        
        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($profiles);
    }

    public function getPlayerProfiles(Request $request)
    {
        $filters = $request->only([
            'name', 'min_age', 'max_age', 'position', 
            'nationality', 'club', 'foot', 
            'min_marketvalue', 'max_marketvalue'
        ]);

        $profiles = $this->playerService->searchPlayersByFilters($filters);
        
        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'Hiç oyuncu bulunamadı.']);
        }
        return response()->json($profiles);
    }

    public function getPlayerProfilesByMarketValue(Request $request)
    {
        $profiles = $this->playerService->searchPlayersByMarketValue(
            floatval($request->input('min_marketvalue')),
            floatval($request->input('max_marketvalue'))
        );
        
        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($profiles);
    }

    public function player_detail($id)
    {
        $this->playerService->increaseViewCount($id);
        $playerDetails = $this->playerService->getPlayerById($id);

        if (!$playerDetails) {
            abort(404, 'Player not found');
        }

        return view('pages.player_detail', compact('playerDetails'));
    }

    public function live_search(Request $request)
    {
        return response()->json(
            $this->playerService->searchPlayersByName($request->input('query'))
        );
    }

    public function getPlayerView()
    {
        $profiles = $this->playerService->getPlayerProfilesView();
        
        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($profiles);
    }

    public function getPlayerLike()
    {
        $topPlayer = $this->playerService->getTopLikedPlayer();
        
        if (!$topPlayer) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($topPlayer);
    }

    public function getLikeCount($playerId)
    {
        return response()->json([
            'likeCount' => $this->playerService->getPlayerLikeCount($playerId)
        ]);
    }

    public function getTopPlayers()
    {
        $topPlayer = $this->playerService->getTopPlayer();
        
        if (!$topPlayer) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($topPlayer);
    }

    public function storeComment($playerId, Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Yorum yapmak için giriş yapmalısınız!'
            ]);
        }

        $result = $this->playerService->handleComment(
            $playerId,
            auth()->id(),
            $request->input('content'),
            $request->input('parent_id')
        );

        return response()->json($result);
    }

    public function deleteComment($commentId)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Bu işlem için giriş yapmalısınız!'
            ]);
        }

        $result = $this->playerService->deleteComment($commentId, auth()->id());
        return response()->json($result);
    }

    public function getPlayerComments($playerId)
    {
        $result = $this->playerService->getPlayerComments($playerId);
        return response()->json($result);
    }

    public function likePlayer($playerId)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false, 
                'message' => 'Giriş yapmanız gerekiyor!'
            ]);
        }

        $result = $this->playerService->handlePlayerLike($playerId, auth()->id());
        return response()->json($result);
    }
}


