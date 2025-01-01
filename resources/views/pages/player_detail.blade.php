@extends('layout.app')

@section('content')
    <style>
        /* Genel Konteyner */
        .container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 20px;
            flex-wrap: wrap; /* Ekran küçükse elemanları alt alta koyar */
        }

        /* Sol Taraf: Oyuncu Bilgileri */
        .player-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
            flex: 1;
            width: 100%; /* Mobilde tüm alanı kaplaması için */
        }

        .card {
            width: 100%;
            border: 3px #1ef876;
            background: linear-gradient(45deg, #1bdf6a, #15ae53); /* Renk geçişi */
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
            display: flex;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.3);
            padding: 15px;
        }

        .card-content {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .player-img {
            width: 65px;
            height: 80px;
        }

        .player-name {
            color: #1E2739;
            font-size: 20px;
            padding-top: 5px;
        }

        .player-number {
            background-color: #1ef876;
            color: #1E2739;
            font-size: 25px;
            border: 2px solid #18c65e;
            border-radius: 10px;
            width: 65px;
            margin-left: auto;
            justify-items: center;
            padding: 15px;
            white-space: nowrap;
        }
        #player-shirt-number{
            margin: 0;
        }

        .value-box {
            background-color: #1E2739;
            color: #ffffff;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            padding: 15px 30px;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
            width: 100%;
        }

        .info-box {
            background-color: #1E2739;
            padding: 42px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
            width: 100%;
            justify-items: center;
            align-items: center;
        }

        .info-item {
            text-align: center;
        }

        /* Sağ Taraf: Tablo */
        .stats-table {
            flex: 1.5;
            background-color: #1E2739;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
            padding: 15px;
            color: white;
            width: 100%; /* Mobilde tüm alanı kaplaması için */
        }

        #stats-container {
            max-height: fit-content;
        }

        #slider-navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        button {
            padding: 10px 20px;
            border: none;
            background-color: #1ef876;
            color: #1E2739;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }

        button:disabled {
            background-color: gray;
            cursor: not-allowed;
        }

        .stats-table table {
            width: 100%;
            border-collapse: initial;
        }

        .stats-table th, .stats-table td {
            /*border: 1px solid #15ae53;*/
            padding: 8px;
            text-align: center;
        }

        .stats-table th {
            background-color: #1f2d44;
            color: #1ef876;
            font-weight: bold;
        }

        .stats-table tr:nth-child(even) {
            background-color: #1f2d44;
        }

        .stats-table tr:hover {
            background-color: #1f2d44;
        }

        /* Mobil ve Küçük Ekranlar İçin */
        @media (max-width: 768px) {
            .container {
                flex-direction: column; /* Ekran küçüldüğünde dikey sırala */
            }

            .stats-table {
                margin-top: 20px; /* Tabloyu oyuncu bilgileri kutusundan aşağıya yerleştir */
            }
        }
        /* Custom Scrollbar Styles */
        .table-responsive::-webkit-scrollbar {
            width: 8px; /* Width of the scrollbar */
            height: 8px; /* Height of the scrollbar */
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #1ef876; /* Color of the scrollbar thumb */
            border-radius: 10px; /* Rounded corners for the scrollbar thumb */
        }

        .table-responsive::-webkit-scrollbar-track {
            background-color: #1E2739; /* Color of the scrollbar track */
        }
        /* Chart Card */
        .chart-card {
            background-color: #1E2739;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
            padding: 15px;
            color: white;
            width: 100%; /* Full width */
            margin-top: 20px; /* Add some space from the previous element */
        }
    </style>
    <style>
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .fadeIn {
            animation: fadeIn 1s ease-in-out;
        }

        #analyse-player {
            font-size: 16px;
            background-color: #1E2739;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            padding: 15px;
            color: white;
            width: 100%; /* Full width */
            margin-top: 20px; /* Add some space from the previous element */
            display: none;
        }
    </style>
    <div class="container">
        <!-- Sol Kısım: Oyuncu Bilgileri -->
        <div class="player-details">
            <!-- Oyuncu Bilgi Kartı -->
            <div class="card">
                <div class="card-content">
                    <img id="player-img" src="{{ $playerDetails['profile']['imageURL'] ?? asset('assets/img/player_detail_img/undefined_player.png') }}" alt="Player" class="player-img " style="background-color: #FFFFFF; border-radius: 10px">
                    <div class="player-name">
                        <p id="player-first-name">{{ $playerDetails['profile']['name'] ?? '-' }}</p>
                    </div>
                    <div class="player-number">
                        <p id="player-shirt-number"> {{ $playerDetails['profile']['shirtNumber'] ?? '-' }} </p>
                    </div>
                </div>
            </div>

            <!-- Değer Kutusu -->
            <div class="value-box" id="player-value">
                {{ $playerDetails['market_value']['marketValue'] ?? '-' }}
            </div>

            <!-- Detaylı Bilgi Kutusu -->
            <div class="info-box">
                <div class="info-item">
                    <img src="{{ asset('assets/img/player_detail_img/birthday-cake 1.png') }}" alt="">
                    <br>
                    <span id="player-birthday">{{ $playerDetails['profile']['dateOfBirth'] ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <img src="{{ asset('assets/img/player_detail_img/house 1.png') }}" alt="">
                    <br>
                    <span id="player-birthplace">{{ $playerDetails['profile']['placeOfBirth']['city'] ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <img src="{{ asset('assets/img/player_detail_img/height 1.png') }}" alt="">
                    <br>
                    <span id="player-height">{{ $playerDetails['profile']['height'] ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <img src="{{ asset('assets/img/player_detail_img/shoe 1 (2).png') }}" alt="">
                    <br>
                    <span id="player-foot">
                        {{
                            isset($playerDetails['profile']['foot']) ?
                                ($playerDetails['profile']['foot'] === 'right' ? 'Sağ' :
                                ($playerDetails['profile']['foot'] === 'left' ? 'Sol' :
                                ($playerDetails['profile']['foot'] === 'both' ? 'Çift' : '-'))) : '-'
                        }}
                    </span>
                </div>
                <div class="info-item">
                    <img src="{{ asset('assets/img/player_detail_img/united-nations 2.png') }}" alt="">
                    <br>
                    <span id="player-nationality">{{ $playerDetails['profile']['placeOfBirth']['country'] ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <img src="{{ asset('assets/img/player_detail_img/football-court 1.png') }}" alt="">
                    <br>
                    <span id="player-position">{{ $playerDetails['profile']['position']['main'] ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <img src="{{ asset('assets/img/player_detail_img/football-club 2.png') }}" alt="">
                    <br>
                    <span id="player-club">{{ $playerDetails['profile']['club']['name'] ?? '-' }}</span>
                </div> <br>
                <div class="info-item">
                    <img src="{{ asset('assets/img/player_detail_img/collaboration 1.png') }}" alt="">
                    <br>
                    <span id="player-contract">{{ $playerDetails['profile']['club']['contractExpires'] ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Sağ Kısım: Geçmiş Sezon Tablosu -->
        <div class="stats-table">
            <h3>Oyuncu Sezon Performansı</h3>
            <div id="stats-container" class="table-responsive">
                <table id="stats-table" class="table-responsive">
                    <thead>
                    <tr>
                        <th>Lig</th>
                        <th>Sezon</th>
                        <th>Takım</th>
                        <th>Oynanan</th>
                        <th>Gol</th>
                        <th>Asist</th>
                        <th>Sarı Kart</th>
                        <th>Kırmızı Kart</th>
                        <th>Süre</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($playerDetails['stats']['stats'] as $season )
                        <tr>
                            <td>
                                @if(!empty($season['competitionID']))
                                    <img src="https://tmssl.akamaized.net//images/logo/medium/{{ strtolower($season['competitionID']) }}.png" alt="Competition Logo" style="height: 20px; background-color: #FFFFFF; border-radius: 3px;">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $season['seasonID'] ?? '-' }}</td>
                            <td>
                                @if(!empty($season['clubID']))
                                    <img src="https://tmssl.akamaized.net/images/wappen/head/{{ $season['clubID'] }}.png" alt="Club Logo" style="height: 20px; background-color: #FFFFFF; border-radius: 3px">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $season['appearances'] ?? '-' }}</td>
                            <td>{{ $season['goals'] ?? '-' }}</td>
                            <td>{{ $season['assists'] ?? '-' }}</td>
                            <td>{{ $season['yellowCards'] ?? '-' }}</td>
                            <td>{{ $season['redCards'] ?? '-' }}</td>
                            <td>{{ $season['minutesPlayed'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="slider-navigation">
                <button id="prev-page" disabled>&laquo; Önceki</button>
                <button id="next-page" style="color: #1E2739">&raquo; Sonraki</button>
            </div>
        </div>

        @if(isset($playerDetails['market_value']['marketValueHistory']))
            <div class="chart-card">
                <h3>Oyuncu Market Değeri Geçmişi</h3>
                <div id="lineChart"></div>
            </div>
        @endif

        <div class="like">
            @if(Auth::check()) <!-- Kullanıcı giriş yaptıysa -->
            <button id="like-button" onclick="toggleLike(<?php echo $playerDetails['profile']['id'] ?>)">
                <i class="bx bx-like">
                    <span id="like-count"></span>
                </i>
            </button>

            @else <!-- Kullanıcı giriş yapmadıysa -->
            <button disabled>
                <i class="bx bx-like">
                    <span id="like-count"></span>
                </i>
            </button>

            @endif
        </div>

        <!-- Hata mesajı -->
        <div id="error-message" style="display: none; color: red;">Giriş yapmadan beğeni yapamazsınız!</div>



        <button onclick="analyzePlayer(<?php echo $playerDetails['profile']['id']; ?>)">Analyze Player</button>
        <div id="analyse-player"></div>
    </div>





    <script>
        function analyzePlayer(playerId) {
            const analysePlayerDiv = document.getElementById('analyse-player');


            analysePlayerDiv.innerHTML = 'Piyasa değeri analiz ediliyor...';
            analysePlayerDiv.style.display = 'block';
            analysePlayerDiv.classList.add('fadeIn');

            // Show second message after 2 seconds
            setTimeout(() => {
                analysePlayerDiv.innerHTML = 'Performansı analiz ediliyor...';
                analysePlayerDiv.classList.remove('fadeIn');
                analysePlayerDiv.classList.add('fadeIn');
            }, 2000); // 2 seconds delay for second message

            // Show third message after 4 seconds
            setTimeout(() => {
                analysePlayerDiv.innerHTML = 'Analiz tamamlanıyor...';
                analysePlayerDiv.classList.remove('fadeIn');
                analysePlayerDiv.classList.add('fadeIn');
            }, 4000); // 4 seconds delay for third message

            // Fetch request in the background, will not block the messages
            fetch(`analyze-player/${playerId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Escape the special characters and preserve the text formatting
                        const escapedData = data.data
                            .replace(/\*\*([^\*]+)\*\*/g, '<strong>$1</strong>')  // Replace '**' with <strong> tags to show bold
                            .replace(/ /g, '&nbsp;')  // Replace spaces with non-breaking spaces to preserve formatting
                            .replace(/\n/g, '<br>'); // Replace newlines with <br> to preserve paragraph breaks

                        // Show the final analysis result after fetch has completed
                        setTimeout(() => {
                            analysePlayerDiv.innerHTML = `<pre>${escapedData}</pre>`;
                            analysePlayerDiv.classList.remove('fadeIn');
                            analysePlayerDiv.classList.add('fadeIn');
                        }, 4500); // Wait for final message (after 4.5 seconds)
                    } else {
                        analysePlayerDiv.innerHTML = 'Analysis failed';
                        analysePlayerDiv.classList.add('fadeIn');
                    }
                });
        }

    </script>

{{--    beğeni--}}
    <script>
        $(document).ready(function() {
            const playerId = {{ $playerDetails['profile']['id'] }};
            fetchLikeCount(playerId);
        });

        // Beğeni sayısını AJAX ile çekme
        function fetchLikeCount(playerId) {
            $.get(`/like-count/${playerId}`, function(response) {
                if (response.likeCount !== undefined) {
                    $('#like-count').text(response.likeCount);
                }
            });
        }

        // Beğeni işlemini başlatma veya geri alma
        function toggleLike(playerId) {
            $.ajax({
                url: `/like-player/${playerId}`,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    player_id: playerId
                },
                success: function(response) {
                    if (response.success) {
                        // Beğenildi, yeni beğeni sayısını al
                        fetchLikeCount(playerId);
                    } else {
                        showError(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    showError("Bir hata oluştu, lütfen tekrar deneyin.");
                }
            });
        }

        function showError(message) {
            const errorMessage = $("#error-message");
            errorMessage.text(message);
            errorMessage.show();
            setTimeout(function() {
                errorMessage.hide();
            }, 3000); // 3 saniye sonra mesaj kaybolur
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const rowsPerPage = 10;
            const table = document.querySelector("#stats-table tbody");
            const rows = Array.from(table.rows);
            let currentPage = 1;

            const renderPage = (page) => {
                const start = (page - 1) * rowsPerPage;
                const end = page * rowsPerPage;

                rows.forEach((row, index) => {
                    row.style.display = index >= start && index < end ? "" : "none";
                });

                document.getElementById("prev-page").disabled = page === 1;
                document.getElementById("next-page").disabled = end >= rows.length;
            };

            document.getElementById("prev-page").addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });

            document.getElementById("next-page").addEventListener("click", () => {
                if (currentPage * rowsPerPage < rows.length) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });

            renderPage(currentPage); // İlk sayfayı yükle
        });
    </script>
    @if(isset($playerDetails['market_value']['marketValueHistory']))
        <script>
            const marketValueHistory = <?php echo json_encode($playerDetails['market_value']['marketValueHistory']); ?>;
        </script>

        <script>
            const lineChartEl = document.querySelector('#lineChart');

            // Veriler

            const categories = marketValueHistory.map(item => {
                // Gelen tarihi `Date` nesnesine çevir
                const date = new Date(item.date);

                // Türkçe formatta tarihi döndür
                return new Intl.DateTimeFormat('tr-TR', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                }).format(date);
            });        const values = marketValueHistory.map(item => {
                const valueStr = item.value.replace('€', '').trim();

                if (valueStr.endsWith('k')) {
                    return parseInt(valueStr.replace('k', '')) * 1000; // 'k' için 3 sıfır
                } else if (valueStr.endsWith('m')) {
                    return parseFloat(valueStr.replace('m', '')) * 1000000; // 'm' için 6 sıfır
                }

                return parseFloat(valueStr); // Eğer 'k' veya 'm' yoksa, direkt sayı olarak kabul edilir
            });
            const clubIcons = marketValueHistory.map(
                item => `https://tmssl.akamaized.net/images/wappen/head/${item.clubID}.png`
            ); // Kulüp ikon URL'leri

            // Grafik Konfigürasyonu
            const lineChartConfig = {
                chart: {
                    height: 400,
                    type: 'line',
                    parentHeightOffset: 0,
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
                series: [
                    {
                        name: 'Market Value',
                        data: values
                    }
                ],
                markers: {
                    size: 5,
                    colors: ['#FFA500'],
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: {
                        size: 7
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            colors: 'white', // X ekseni yazı rengi
                            fontSize: '12px'
                        }
                    },
                    axisBorder: {
                        show: true,
                        color: 'white' // X ekseni çizgi rengi
                    },
                    axisTicks: {
                        show: true,
                        color: 'white' // X ekseni tick rengi
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: 'white', // Y ekseni yazı rengi
                            fontSize: '12px'
                        }
                    },
                    axisBorder: {
                        show: true,
                        color: 'white' // Y ekseni çizgi rengi
                    },
                    axisTicks: {
                        show: true,
                        color: 'white' // Y ekseni tick rengi
                    }
                },
                tooltip: {
                    custom: function({ series, seriesIndex, dataPointIndex }) {
                        return `
                        <div style="padding: 10px; text-align: center; background-color: #1a202c;">
                          <img src="${clubIcons[dataPointIndex]}" alt="Club Icon" style="width: 30px; height: 40px; margin-bottom: 5px;" />
                          <div><strong>${categories[dataPointIndex]}</strong></div>
                          <div>Market Değeri: €${series[seriesIndex][dataPointIndex].toLocaleString()}</div>
                        </div>
                      `;
                    }
                }
            };

            // Grafiği Oluşturma
            if (lineChartEl) {
                const lineChart = new ApexCharts(lineChartEl, lineChartConfig);
                lineChart.render();
            }

        </script>
    @endif
@endsection
