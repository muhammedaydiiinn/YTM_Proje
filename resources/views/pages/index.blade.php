@extends('layout.app')
@section('content')

    <style>
        /* Genel Ayarlamalar */
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .card {
            background-color: #1f1f1f;
            border-radius: 16px;
            overflow: hidden;
            width: 100%; /* Ekran genişliğine uyumlu */
            max-width: 800px; /* Maksimum genişlik */
            text-align: center;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .card .header {
            position: relative;
            background-size: cover;
            background-position: center;
            height: 50vh; /* Ekranın %40'ı kadar yükseklik */
            min-height: 300px; /* Minimum yükseklik */
        }

        .card .header img {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            object-fit: contain;
        }

        .card .header::before {
            content: "";
            position: absolute;

            bottom: 10px;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('<?php echo e($imageURLTopPlayer); ?>');
            background-size: cover;
            background-position: center;
            opacity: 0.3;
            z-index: 0;
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

    <!-- Player Card Display -->
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 card-container">
                <div class="card" onclick="window.location.href='<?php echo e($topPlayer ? route('player_detail', ['id' => $topPlayer['profile']['id']]) : '#'); ?>';">
                    <div class="header" style="background-image: url('<?php echo e(asset('assets/img/filter_img/background.jpg')); ?>');">
                        <img src="<?php echo e($imageURLTopPlayer); ?>" alt="Player Image">
                    </div>
                    <div class="footer">
                        <div class="label">En Çok Ziyaret Edilen Oyuncu</div>
                        <div class="player-name"><?php echo e($topPlayer ? $topPlayer['profile']['name'] : 'Bilgi Mevcut Değil'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
