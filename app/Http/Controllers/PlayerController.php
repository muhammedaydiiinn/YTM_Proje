<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Players;
use App\Models\PlayerViewCount;
use App\Models\User;
use App\Repositories\PlayerProfileRepoInt;
use Illuminate\Http\Request;
use App\Models\Like;


class PlayerController extends Controller
{
    protected $playerRepository;

    // Dependency Injection PageController sınıfına, PlayerProfileRepoInt bağımlılığı constructor üzerinden enjekte ediliyor:
    //Bu sayede, PageController doğrudan bir PlayerProfileRepoInt sınıfına bağlı kalmaz, sadece arayüzü tanır.

    public function __construct(PlayerProfileRepoInt $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    public function getPlayerProfilesById(Request $request)
    {
        $id = $request->input('id'); // İstekten id'yi al
        $profile = $this->playerRepository->getPlayerDetailsById($id);

        if (!$profile) {
            return response()->json(['error' => 'Player not found'], 404);
        }

        return response()->json($profile);

    }
    public function getPlayerProfilesByName(Request $request)
    {
        $name = $request->input('name');

        // Adına göre ilk 10 profili alıyoruz
        $profiles = $this->playerRepository->getPlayerProfilesByName($name);

        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }

        return response()->json($profiles);
    }

    public function getPlayerProfilesByAgeRange(Request $request)
    {
        $minAge = $request->input('min_age'); // Minimum yaş verisini al
        $maxAge = $request->input('max_age'); // Maksimum yaş verisini al

        // Belirtilen yaş aralığındaki oyuncuları alıyoruz
        $profiles = $this->playerRepository->getPlayerProfilesByAgeRange($minAge, $maxAge);

        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }

        return response()->json($profiles);
    }

    public function getPlayerProfileByMainPosition(Request $request)
    {
        $position = $request->input('position'); // Pozisyon verisini istekten al
        $profile = $this->playerRepository->getPlayerProfileByMainPosition($position);

        if (!$profile) {
            return response()->json(['error' => 'Player not found'], 404);
        }

        return response()->json($profile);
    }

    public function getPlayerProfilesByNationality(Request $request)
    {
        $nationality = $request->input('nationality'); // Milliyeti istekten al
        $profiles = $this->playerRepository->getPlayerProfilesByNationality($nationality);

        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }

        return response()->json($profiles);
    }

    public function getPlayerProfilesByClub(Request $request)
    {
        $clubName = $request->input('club'); // İstekten takım adını al

        $profiles = $this->playerRepository->getPlayerProfilesByClub($clubName);

        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }

        return response()->json($profiles);
    }


    public function getPlayerProfilesByFoot(Request $request)
    {
        $foot = $request->input('foot'); // Oyuncunun kullandığı ayağı istekten al
        $profiles = $this->playerRepository->getPlayerProfilesByFoot($foot);

        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }

        return response()->json($profiles);
    }

    public function getPlayerProfiles(Request $request)
    {
        $filters = $request->only(['name', 'min_age', 'max_age', 'position', 'nationality', 'club', 'foot', 'min_marketvalue', 'max_marketvalue']);

        $profiles = $this->playerRepository->getPlayerProfiles($filters);

        if (!$profiles || $profiles->isEmpty()) {
            // 404 yerine error mesajı gönder
            return response()->json(['error' => 'Hiç oyuncu bulunamadı.']);
        }

        return response()->json($profiles);
    }

    public function getPlayerProfilesByMarketValue(Request $request)
    {
        $minMarketValue = floatval($request->input('min_marketvalue'));
        $maxMarketValue = floatval($request->input('max_marketvalue'));

        $profiles = $this->playerRepository->getPlayerProfilesByMarketValueRange($minMarketValue, $maxMarketValue);

        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($profiles);
    }

    function increase_view_count($id)
    {
        $viewCountEntry = PlayerViewCount::where('player_id', $id)->first();

        if ($viewCountEntry) {
            $viewCountEntry->increment('view_count');
        } else {
            PlayerViewCount::create(['player_id' => $id, 'view_count' => 1]);
        }
    }
    public function player_detail($id)
    {
        $this->increase_view_count($id);
        // Örnek olarak bir repository'den verileri alıyoruz.
        $playerDetails = $this->playerRepository->getPlayerDetailsById($id);

        if (!$playerDetails) {
            abort(404, 'Player not found');
        }

        return view('pages.player_detail', compact('playerDetails'));
    }

    public function live_search(Request $request)
    {
        $query = $request->input('query');
        $players = $this->playerRepository->getPlayerProfilesByName($query);
        return response()->json($players);
    }

    public function getPlayerView()
    {
        $profiles = $this->playerRepository->getPlayerProfilesView();
        if (!$profiles || $profiles->isEmpty()) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($profiles);
    }

    public function likePlayer($playerId, Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();

            // Futbolcuyu bul
            $player = $this->playerRepository->getPlayerDetailsById($playerId);
            if ($player) {
                // Kullanıcı daha önce beğenip beğenmediğini kontrol et

                $existingLike = Like::where('user_id', $user->id)
                    ->where('player_id', $player['profile']['id'])
                    ->first();
                if ($existingLike) {
                    $existingLike->delete();

                    return response()->json(['success' => true, 'message' => 'Beğeni geri alındı!']);
                }

                // Beğeni kaydını veritabanına ekle
                Like::create([
                    'user_id' => $user->id,
                    'player_id' => $player['profile']['id']
                ]);

                return response()->json(['success' => true, 'message' => 'Beğeni başarıyla kaydedildi!']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Giriş yapmanız gerekiyor!']);
    }

    public function getPlayerLike()
    {
        $topPlayer = $this->playerRepository->getPlayerProfilesLikes();
        $topPlayer = $topPlayer->first();
        $topPlayerGet = $this->playerRepository->getPlayerDetailsById($topPlayer->id);
        $apiData = [
            'player_id' => $topPlayerGet['profile']['id'],
            'image_url' => $topPlayerGet['profile']['imageURL'],
            'player_name' => $topPlayerGet['profile']['name']
        ];
        if (!$topPlayer) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($apiData);

    }
    public function getLikeCount($playerId)
    {
        $likeCount = Like::where('player_id', $playerId)->count();
        return response()->json(['likeCount' => $likeCount]);
    }
    public function getTopPlayers()
    {
        $topPlayer = $this->playerRepository->getTopPlayers();
        $topPlayerGet = $this->playerRepository->getPlayerDetailsById($topPlayer->player_id);
        $apiData = [
            'player_id' => $topPlayer->player_id,
            'image_url' => $topPlayer->image_url,
            'player_name' => $topPlayerGet['profile']['name']
        ];
        if (!$topPlayer) {
            return response()->json(['error' => 'No players found'], 404);
        }
        return response()->json($apiData);
    }

    public function storeComment($playerId, Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            // Futbolcuyu bul
            $player = $this->playerRepository->getPlayerDetailsById($playerId);
            if ($player) {
                // Yorum içeriğini al
                $content = $request->input('content');
                if (!empty($content)) {

                    // Yorum oluştur ve kaydet
                    Comment::create([
                        'user_id' => $user->id,
                        'player_id' => $player['profile']['id'],
                        'content' => $content
                    ]);
                    // Başarılı mesajı
                    return response()->json(['success' => true, 'message' => 'Yorum başarıyla kaydedildi!']);

                }
            }
        }

        return response()->json(['success' => false, 'message' => 'Giriş yapmanız gerekiyor!']);
    }

    public function deleteComment($commentId)
    {
        if (auth()->check()) {
            $user = auth()->user();
            // Yorumu bul
            $comment = Comment::find($commentId);
            if ($comment) {
                // Yorumu sadece yorumu yapan kullanıcı silebilir
                if ($comment->user_id === $user->id) {
                    $comment->delete();
                    return response()->json(['success' => true, 'message' => 'Yorum başarıyla silindi!']);
                }
            }
        }

        return response()->json(['success' => false, 'message' => 'Yorumu silemezsiniz!']);
    }
    public function getPlayerComments($playerId)
    {
        // Yorumları ve kullanıcıları çek
        $comments = Comment::where('player_id', $playerId)->get();
        $users = User::whereIn('id', $comments->pluck('user_id'))->get()->keyBy('id');

        // Her bir yoruma user_name ekle
        $commentsWithUserName = $comments->map(function ($comment) use ($users) {
            $comment->user_name = $users[$comment->user_id]->name ?? 'Unknown';
            return $comment;
        });

        // JSON olarak geri döndür
        return response()->json($commentsWithUserName);
    }

}


