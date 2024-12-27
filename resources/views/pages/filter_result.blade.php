@extends('layout.app')
@section('content')
    <style>
        .player-card {
            display: flex;
            align-items: center;
            background-color: #1E2739;
            border-radius: 10px;
            padding: 10px 15px;
            width: 100%;
            height: 110px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            position: relative;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .player-card:hover {
            transform: scale(1.02);
        }

        .player-info {
            display: flex;
            align-items: center;
        }

        .player-image {
            width: 72px;
            height: 96px;
            border-radius: 10px;
            margin-right: 10px;
        }

        .details {
            display: flex;
            flex-direction: column;
        }

        .name-country {
            display: flex;
            align-items: center;
        }

        #player-name {
            color: white;
            font-size: 18px;
            margin: 0;
            margin-right: 10px;
        }

        .country-flag {
            width: 20px;
            height: 14px;
            border-radius: 2px;
        }

        .club-name {
            color: #a0a0b0;
            margin: 5px 0 0;
        }

        .value {
            background-color: #1ef876;
            color: #1E2739;
            height: 50px;
            font-size: 17px;
            border: 5px double #1E2739;
            border-radius: 10px;
            position: absolute;
            top: -10px;
            right: -10px;
            width: 120px;
            align-items: center;
            justify-items: center;
        }

    </style>
    <div class="container mt-5">
        <div id="results" class="row">
            @if ($message)
                <p>{{ $message }}</p>
            @else
                @foreach ($players as $player)
                    <div class="col-md-6 mb-4">
                        <div class="player-card" onclick="window.location.href='/player/{{ optional($player['profile'])['id'] }}'">
                            <div class="player-info">
                                <img id="player-image" class="player-image"
                                     src="{{ optional($player['profile'])['imageURL'] ?: asset('assets/img/player_detail_img/undefined_player.png') }}"
                                     alt="{{ optional($player['profile'])['name'] ?: '-' }}" style="background-color: #FFFFFF; border-radius: 10px">
                                <div class="details">
                                    <div class="name-country">
                                        <h2 id="player-name">{{ optional($player['profile'])['name'] ?: '-' }}</h2>
                                    </div>
                                    <p id="club-name" class="club-name">{{ isset($player['profile']['club']) ? $player['profile']['club']['name'] : '-' }}</p>
                                </div>
                            </div>
                            <div class="value">
                                <p id="market-value">{{ optional($player['market_value'])['marketValue'] ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

@endsection
