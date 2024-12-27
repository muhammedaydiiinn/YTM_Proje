@extends('layout.app')

@section('content')
    <style>
        .player-card {
            display: flex;
            align-items: center;
            background-color: #1E2739;
            border-radius: 10px;
            padding: 10px 15px;
            width: 100%; /* Tam genişlik için */
            height: 110px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            position: relative;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
            cursor: pointer; /* Hover için el ikonu */
            transition: transform 0.2s ease; /* Hover efekti */
        }

        .player-card:hover {
            transform: scale(1.02); /* Hover olduğunda büyütme */
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
        <h3>Arama Sonuçları: <span id="search-query"></span></h3>

        <div id="results" class="row"> <!-- Kartlar burada grid sistemine yerleşecek -->
            <p>Sonuçlar yükleniyor...</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const resultsContainer = document.getElementById('results');
            const searchQueryElement = document.getElementById('search-query');

            // Local Storage'dan veriyi al
            const searchResults = JSON.parse(localStorage.getItem('searchResults'));
            const searchQuery = localStorage.getItem('searchQuery');

            if (searchResults && searchQuery) {
                searchQueryElement.textContent = searchQuery;

                if (searchResults.length > 0) {
                    let resultsHTML = '';
                    searchResults.forEach(player => {
                        // Kontroller: Eğer değer yoksa "-" yazalım
                        const playerName = player.profile.name || "-";
                        const playerClubName = player.profile.club.name || "-";
                        const playerImageURL = player.profile.imageURL && player.profile.imageURL.trim() !== ""
                            ? player.profile.imageURL
                            : "{{ asset('assets/img/player_detail_img/undefined_player.png') }}";
                        const marketValue = player.market_value.marketValue || "-";

                        resultsHTML += `
                <div class="col-md-6 mb-4">
                    <div class="player-card" onclick="window.location.href='/player/${player.profile.id}'">
                        <div class="player-info">
                            <img id="player-image" class="player-image" src="${playerImageURL}" alt="${playerName}" style="background-color: #FFFFFF; border-radius: 10px">
                            <div class="details">
                                <div class="name-country">
                                    <h2 id="player-name">${playerName}</h2>
                                </div>
                                <p id="club-name" class="club-name">${playerClubName}</p>
                            </div>
                        </div>
                        <div class="value">
                            <p id="market-value">${marketValue}</p>
                        </div>
                    </div>
                </div>`;
                    });
                    resultsContainer.innerHTML = resultsHTML;
                } else {
                    resultsContainer.innerHTML = '<p>Hiçbir sonuç bulunamadı.</p>';
                }
            } else {
                resultsContainer.innerHTML = '<p>Sonuç bulunamadı veya oturum sona erdi.</p>';
            }
        });
    </script>

@endsection
