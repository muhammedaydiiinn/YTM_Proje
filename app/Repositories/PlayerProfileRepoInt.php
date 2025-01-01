<?php

namespace App\Repositories;

interface PlayerProfileRepoInt
{
    // buradaki yapı sayesinde veri erişim mantığını (data access logic) iş mantığından (business logic)
    // ayırmayı amaçlar. Bu desen, veriyle çalışan katmanlar arasında bir soyutlama sağlar.
    public function getPlayerProfilesByName(string $name);
    public function getPlayerProfilesByAgeRange(string $minAge, string $maxAge);

    public function getPlayerProfileByMainPosition(string $position);

    public function getPlayerProfilesByNationality(string $nationality);
    public function getPlayerProfilesByClub(string $clubName);

    public function getPlayerProfilesByFoot(string $foot);

    public function getPlayerProfilesByMarketValueRange(float $minMarketValue, float $maxMarketValue);

    public function getPlayerProfiles(array $filters);

    public function getPlayerDetailsById(string $id);

}
