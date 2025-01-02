@extends('layout.app')
@section('content')

    <style>
        /* Genel Ayarlamalar */
        .slider-container {
            margin-top: 20px;
        }

        .owl-carousel .card {
            background-color: #1f1f1f;
            border-radius: 16px;
            overflow: hidden;
            text-align: center;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .card .header {
            position: relative;
            height: 630px; /* Sabit yükseklik */
            background-size: cover;
            background-position: center;
        }

        .card .header img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Resmi karta tam oturt */
            border-bottom: 2px solid #282828;
        }

        .card .footer {
            background-color: #282828;
            padding: 16px;
        }

        .card .footer .label {
            font-size: 14px;
            color: #aaaaaa;
        }

        .card .footer .player-name {
            margin-top: 8px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>

    <!-- Slider -->
    <div class="container slider-container">
        <div class="owl-carousel owl-theme">
            <!-- Kart 1 -->
            <div class="card" onclick="window.location.href='{{ $topPlayer ? route('player_detail', ['id' => $topPlayer['profile']['id']]) : '#' }}';">
                <div class="header" style="background-image: url('{{ asset('assets/img/filter_img/background.jpg') }}');">
                    <img src="{{ $imageURLTopPlayer }}" alt="Player Image">
                </div>
                <div class="footer">
                    <div class="label">En Çok Ziyaret Edilen Oyuncu</div>
                    <div class="player-name">{{ $topPlayer ? $topPlayer['profile']['name'] : 'Bilgi Mevcut Değil' }}</div>
                </div>
            </div>

            <!-- Kart 2 -->
            <div class="card" onclick="window.location.href='{{ $apiData ? route('player_detail', ['id' => $apiData['player_id']]) : '#' }}';">
                <div class="header" style="background-image: url('{{ asset('assets/img/filter_img/background.jpg') }}');">
                    <img src="{{ $apiData['image_url'] }}" alt="API Player Image">
                </div>
                <div class="footer">
                    <div class="label">En Çok Beğenilen Oyuncu</div>
                    <div class="player-name">{{ $apiData ? $apiData['player_name'] : 'Bilgi Mevcut Değil' }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                loop: true, // Sonsuz döngü
                margin: 10,
                autoplay: true, // Otomatik kaydırma
                autoplayTimeout: 3000, // 3 saniyede bir geçiş
                autoplayHoverPause: true, // Üzerine gelince duraklama
                responsive: {
                    0: {
                        items: 1 // Mobil ve küçük ekranlarda 1 kart
                    },
                    600: {
                        items: 1 // Orta ekranlarda 1 kart
                    },
                    1000: {
                        items: 1 // Büyük ekranlarda 1 kart
                    }
                }
            });
        });
    </script>

@endsection
