<?php

namespace App\Http\Controllers;

use App\Models\Players;
use App\Models\PlayerViewCount;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Repositories\PlayerProfileRepoInt;
use App\Models\TopPlayerImage;
use Illuminate\Support\Facades\Auth;


class PageController extends Controller
{
    protected $playerRepository;

    public function __construct(PlayerProfileRepoInt $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }
    public function index_home()
    {

        $topPlayer = PlayerViewCount::orderBy('weekly_view_count', 'desc')->first();


        $playerId = $topPlayer->player_id;
        $imageURLTopPlayer = $topPlayer->image_url;
        $topPlayer = $this->playerRepository->getPlayerDetailsById($playerId);

        return view('pages.index', compact('topPlayer', 'imageURLTopPlayer'));
    }


    public function get_option()
    {
        $citizenships = Players::pluck('profile.citizenship')
            ->flatten() // Çok boyutlu array'leri düz bir array'e indirger
            ->filter() // null veya boş olanları kaldırır
            ->unique() // Tekrar eden değerleri kaldırır
            ->sort() // A'dan Z'ye sıralar
            ->values(); // Anahtarları sıfırdan indeksler

        $positions = Players::pluck('profile.position.main')
            ->filter() // null veya boş olanları kaldırır
            ->unique() // Tekrar edenleri kaldırır
            ->sort() // A'dan Z'ye sıralar
            ->values(); // Düzgün bir şekilde sıfırdan indeksler

        return response()->json([
            'citizenships' => $citizenships,
            'positions' => $positions,
        ]);
    }

    public function filter_page()
    {


        return view('pages.filter');
    }

    public function search_result(Request $request)
    {
        return view('pages.search');
    }

    public function filter_result(Request $request)
    {
        // Gelen tüm filtreleri al
        $filters = $request->all();

        // Null olmayanları filtrele
        $filters = array_filter($filters, function ($value) {
            return $value !== null && $value !== ''; // Null ve boş stringleri kaldır
        });
        // Filtreleri repository'e gönder
        $players = $this->playerRepository->getPlayerProfiles($filters);

        if ($players === null) {
            return view('pages.filter_result', [
                'players' => [],
                'message' => 'Hiçbir oyuncu bulunamadı.'
            ]);
        }

        return view('pages.filter_result', [
            'players' => $players,
            'message' => null
        ]);
    }


}
