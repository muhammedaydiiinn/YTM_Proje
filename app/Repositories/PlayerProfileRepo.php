<?php

namespace App\Repositories;

use App\Models\Players;
use Illuminate\Support\Facades\DB;
use App\Models\PlayerViewCount;
use Transliterator;

class PlayerProfileRepo implements PlayerProfileRepoInt
{




    public function getPlayerProfilesByName(string $name)
    {

       $name = strtr($name, [
           'i' => 'İ', 'ı' => 'I', 'ş' => 'Ş',
           'ç' => 'Ç', 'ğ' => 'Ğ', 'ö' => 'Ö',
           'ü' => 'Ü',
       ]);
       $normalizedName = mb_strtoupper($name, 'UTF-8');
       $players = Players::where('profile.name', 'LIKE', '%' . $normalizedName . '%')->get();;

        if ($players->isEmpty()) {
            return null;
        }

        return $players;
    }

    public function getPlayerProfilesByAgeRange(string $minAge, string $maxAge)
    {
        $players = Players::whereBetween('profile.age', [$minAge, $maxAge])
            ->get();
        if ($players->isEmpty()) {
            return null;
        }

        return $players;
    }


    public function getPlayerProfileByMainPosition(string $position)
    {
        $players = Players::where('profile.position.main', $position)
            ->get();
        if ($players->isEmpty()) {
            return null;
        }

        return $players;
    }


    public function getPlayerProfilesByNationality(string $nationality)
    {
        $players = Players::where('profile.citizenship', $nationality) // Burada doğrudan JSON yolunu kullanıyoruz
        ->get();

        if ($players->isEmpty()) {
            return null;
        }

        return $players;
    }


    public function getPlayerProfilesByClub(string $clubName)
    {
        // Takım adına göre oyuncuları arıyoruz
        $players = Players::where('profile.club.name', 'LIKE', '%' . $clubName . '%') // Esnek arama için LIKE
        ->get();

        // Sonuç varsa profil bilgilerini döndür, yoksa null döndür
        return $players;
    }


    public function getPlayerProfilesByFoot(string $foot)
    {
        $players = Players::where('profile.foot', $foot)
            ->get();

        return $players;
    }


    public function getPlayerProfilesByMarketValueRange(float $minMarketValue, float $maxMarketValue)
    {
        $players = Players::whereBetween('profile.marketValue', [$minMarketValue, $maxMarketValue])->get();
        if ($players->isEmpty()) {
            return null;
        }
        return $players;
    }


    public function getPlayerProfiles(array $filters)
    {
        $query = Players::query();

        // Dinamik filtreleme
        $this->applyFilters($query, $filters);

        // Filtrelere göre sıralama
        $players = $query->orderBy('profile.marketValue', 'desc')
            ->limit(100)
            ->get();

        if ($players->isEmpty()) {
            return null;
        }

        return $players;
    }

    private function applyFilters($query, $filters)
    {
        // İsim filtresi
        if (!empty($filters['name'])) {
            $name = strtr($filters['name'], [
                'i' => 'İ', 'ı' => 'I', 'ş' => 'Ş',
                'ç' => 'Ç', 'ğ' => 'Ğ', 'ö' => 'Ö',
                'ü' => 'Ü',
            ]);
            $normalizedName = mb_strtoupper($name, 'UTF-8');
            $query->where('profile.name', 'LIKE', '%' . $normalizedName . '%');
        }

        if (isset($filters['min_age']) && isset($filters['max_age'])) {
            $query->whereBetween('profile->age', [$filters['min_age'], $filters['max_age']]);
        }

        // Pozisyon filtresi
        if (!empty($filters['position'])) {
            $query->where('profile.position.main', $filters['position']);
        }

        // Uyruk filtresi
        if (!empty($filters['nationality'])) {
            $query->where('profile->citizenship->0', $filters['nationality']);
        }

        // Kulüp filtresi
        if (!empty($filters['club'])) {
            $query->where('profile.club.name', 'LIKE', '%' . $filters['club'] . '%');
        }
        // Ayak filtresi
        if (!empty($filters['foot'])) {
            $query->where('profile.foot', $filters['foot']);
        }
        if (!empty($filters['min_marketvalue']) && !empty($filters['max_marketvalue'])) {
            $min_marketvalue = (int) $filters['min_marketvalue'];
            $max_marketvalue = (int) $filters['max_marketvalue'];
            $query->whereBetween('profile.marketValue', [$min_marketvalue, $max_marketvalue]);
        }

        return $query;
    }



    public function getPlayerDetailsById(string $id)
    {
        // Oyuncu bilgilerini al
        $player = Players::raw(function ($collection) use ($id) {
            return $collection->find(['profile.id' => $id]);
        });

        if (!$player || $player->isEmpty()) {
            return null;
        }

        $playerData = $player->first();

        return $this->replaceNullValues([
            'profile' => $playerData->profile,
            'market_value' => $playerData->market_value,
            'stats' => $playerData->stats,
            'transfers' => $playerData->transfers,
            'achievements' => $playerData->achievements,
            'injuries' => $playerData->injuries,
            'jersey_numbers' => $playerData->jersey_numbers
        ]);
    }

    private function replaceNullValues($data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->replaceNullValues($value);
            } else {
                $data[$key] = $value ?? '-';
            }
        }
        return $data;
    }

    public function getPlayerProfilesView()
    {
        $players = PlayerViewCount::orderBy('view_count', 'desc')
            ->limit(10)
            ->get();

        return $players->isNotEmpty() ? $players : null;
    }
}
