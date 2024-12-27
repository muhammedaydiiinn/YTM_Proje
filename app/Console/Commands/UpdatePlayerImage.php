<?php

namespace App\Console\Commands;

use App\Repositories\PlayerProfileRepo;
use Illuminate\Console\Command;
use App\Models\PlayerViewCount;
use App\Repositories\PlayerRepository;
use App\Models\TopPlayerImage; // Yeni tablo modelini ekleyin
use GuzzleHttp\Client;

class UpdatePlayerImage extends Command
{
    protected $signature = 'update:player-image';
    protected $description = 'En çok görüntülenen oyuncunun resmini günceller';

    public function __construct(PlayerProfileRepo $playerRepository)
    {
        parent::__construct();
        $this->playerRepository = $playerRepository;
    }

    public function handle()
    {
        // En çok görüntülenen oyuncuyu al
        $topPlayer = PlayerViewCount::orderBy('view_count', 'desc')->first();

        if (!$topPlayer) {
            $this->error('En çok görüntülenen oyuncu bulunamadı.');
            return;
        }

        // Oyuncu ID'sini al
        $playerId = $topPlayer->player_id;

        // Haftalık görüntülenme sayısını güncelle
        $topPlayer->weekly_view_count += $topPlayer->view_count;  // Haftalık sayaca ekle
        $topPlayer->view_count = 0;  // Günlük sayacı sıfırla
        $topPlayer->save();  // Değişiklikleri kaydet

        // Google API çağrısı
        $player = $this->playerRepository->getPlayerDetailsById($playerId);
        $playerName = $player['profile']['name'];

        // Google API için parametreler
        $apiKey = env('GOOGLE_API_KEY');
        $cx = env('GOOGLE_CX');

        $client = new Client();
        $response = $client->get('https://www.googleapis.com/customsearch/v1', [
            'query' => [
                'key' => $apiKey,
                'cx' => $cx,
                'q' => $playerName,
                'searchType' => 'image',
                'num' => 10, // Birkaç sonuç al
            ]
        ]);

        $result = json_decode($response->getBody(), true);

        // PNG formatındaki resimleri bulana kadar aramayı devam ettir
        $imageURL = null;
        if (!empty($result['items'])) {
            foreach ($result['items'] as $item) {
                if (isset($item['link']) && filter_var($item['link'], FILTER_VALIDATE_URL)) {
                    // URL'nin .png ile bitip bitmediğini kontrol et
                    if (strpos(strtolower($item['link']), '.png') !== false) {
                        $imageURL = $item['link'];
                        break; // İlk .png resmini bulduğunda döngüyü sonlandır
                    }
                }
            }
        }

        // Oyuncu resmi bulunduysa, resmi güncelle
        if ($imageURL) {
            PlayerViewCount::updateOrCreate(
                ['player_id' => $playerId],  // Player'ı id ile güncelle
                ['image_url' => $imageURL]   // Resim URL'sini ekle
            );

            $this->info("Oyuncunun resmi başarıyla güncellendi.");
        } else {
            $this->error('Google API ile .png formatında resim bulunamadı.');
        }
    }

}
