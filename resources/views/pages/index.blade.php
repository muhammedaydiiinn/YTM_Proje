@extends('layout.app')
@section('content')

    <style>
        /* Genel Ayarlamalar */
        .carousel {
            max-width: 100%; /* Görsellerin genişliğini sınırlamak için */
            height: auto; /* Yükseklik içeriğe göre ayarlanacak */
            margin: 0 auto; /* Ortalamak için */
        }

        /* Carousel İndikatörleri */
        .carousel-indicators button {
            background-color: #1ef876; /* İndikatör rengi */
        }

        /* Carousel İçerikleri */
        .carousel-item img {
            width: 100%;


        }

        .carousel-caption {
            color: #fff; /* Yazı rengi */
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .carousel-caption h3 {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .carousel-caption p {
            font-size: 1rem;
        }

        @media (min-width: 1400px) {
            .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
                max-width: 1200px;
            }
        /* Mobil ve Küçük Ekranlar İçin */
        @media (max-width: 768px) {
            .carousel {
                max-width: 100%;
            }

            .carousel-caption h3 {
                font-size: 1.2rem; /* Daha küçük ekranlarda başlık font boyutunu küçült */
            }

            .carousel-caption p {
                font-size: 0.9rem; /* Daha küçük ekranlarda açıklama font boyutunu küçült */
            }
        }

        /* Çok Küçük Ekranlar İçin (örneğin telefonlar) */
        @media (max-width: 480px) {
            .carousel-caption h3 {
                font-size: 1rem; /* Başlık fontunu daha da küçült */
            }

            .carousel-caption p {
                font-size: 0.8rem; /* Açıklama fontunu daha da küçült */
            }
        }
    </style>

    <div id="carouselExample" class="carousel slide col-md-6 offset-md-2" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ $imageURLTopPlayer }}" alt="First slide" />
                <div class="carousel-caption d-none d-md-block">
                    <h3>
                        <a href="{{ $topPlayer ? route('player_detail', ['id' => $topPlayer['profile']['id']]) : '#' }}">
                            {{ $topPlayer ? $topPlayer['profile']['name'] : 'First slide' }}
                        </a>
                    </h3>
                    <p>En Çok Ziyaret Edilen Oyuncu</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>

@endsection
