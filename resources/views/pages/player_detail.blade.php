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
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 10px;
        }


        .comments {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }

        .comment {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #1E2739;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
        }

        .comment p {
            margin: 0;
            font-size: 14px;
        }

        .comment-card {
            background-color: #1E2739;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }


        .comment-card-content {
            display: flex;
            flex-direction: column;
        }

        .comment-text {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .comment-time {
            font-size: 12px;
            color: #777;
        }

        .delete-comment {
            max-width: 110px;
            align-self: flex-end;
        }

    </style>
    <style>
        .comments-section {
            background-color: #1E2739;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }

        .comment-form textarea {
            background-color: #1f2d44;
            color: #ffffff;
            border: 1px solid #1ef876;
            border-radius: 5px;
        }

        .comment-form textarea:focus {
            background-color: #1f2d44;
            color: #ffffff;
            border-color: #1ef876;
            box-shadow: 0 0 0 0.2rem rgba(30, 248, 118, 0.25);
        }

        .comment-card {
            background-color: #1f2d44;
            border: none;
            border-left: 3px solid #1ef876;
            margin-bottom: 15px;
            transition: transform 0.2s;
        }

        .comment-card:hover {
            transform: translateX(5px);
        }

        .reply-card {
            background-color: #1E2739;
            border-left: 3px solid #1ef876;
            margin-left: 30px;
            padding: 10px;
            border-radius: 0 8px 8px 0;
        }

        .comment-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .comment-actions button {
            font-size: 0.9rem;
            padding: 3px 8px;
            border-radius: 4px;
        }

        .reply-form {
            margin-left: 30px;
            margin-top: 10px;
            padding: 10px;
            background-color: #1E2739;
            border-radius: 5px;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .comment-user {
            color: #1ef876;
            font-weight: bold;
        }

        .comment-date {
            color: #6c757d;
            font-size: 0.9rem;
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
                                    <img src="https://tmssl.akamaized.net//images/logo/medium/{{ strtolower($season['competitionID']) }}.png" alt="Competition Logo" style="height: 24px; background-color: #FFFFFF; border-radius: 3px; padding: 2px">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $season['seasonID'] ?? '-' }}</td>
                            <td>
                                @if(!empty($season['clubID']))
                                    <img src="https://tmssl.akamaized.net/images/wappen/head/{{ $season['clubID'] }}.png" alt="Club Logo" style="height: 24px; background-color: #FFFFFF; border-radius: 3px; padding: 2px">
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

        <div class="col-12">
            <!-- Beğeni Bölümü -->
            <div class="like-section">
                @if(Auth::check())
                    <button id="like-button"  onclick="toggleLike({{ $playerDetails['profile']['id'] }})">
                        <i class="bx bx-like"></i>
                        <span id="like-count">0</span>
                    </button>
                @else
                    <button disabled>
                        <i class="bx bx-like"></i>
                        <span id="like-count">0</span>
                    </button>
                    <small class="text-muted">Beğenmek için giriş yapın</small>
                @endif
            </div>

            <!-- Yorum Bölümü -->
            <div class="comments-section">
                <h4 class="text-white mb-4">Yorumlar</h4>

                @if(Auth::check())
                    <div class="comment-form mb-4">
                        <textarea id="comment-input"
                                 class="form-control mb-2"
                                 rows="3"
                                 placeholder="Yorumunuzu yazın..."></textarea>
                        <button onclick="submitComment()">
                            <i class="fas fa-paper-plane me-2"></i>Yorum Yap
                        </button>
                    </div>
                @else
                    <div class="alert alert-info">
                        Yorum yapabilmek için <a href="{{ route('login') }}" class="text-primary">giriş</a> yapmalısınız.
                    </div>
                @endif

                <div id="comments-container">
                    <!-- Yorumlar dinamik olarak buraya yüklenecek -->
                </div>
            </div>
        </div>




        <button onclick="analyzePlayer(<?php echo $playerDetails['profile']['id']; ?>)">Analyze Player</button>
        <div id="analyse-player"></div>
    </div>

    <script>
        const currentUserId = '{{ Auth::id() ?? 'null' }}';
        const playerId = '{{ $playerDetails['profile']['id'] }}';

        // Sayfa yüklendiğinde çalışacak fonksiyonlar
        document.addEventListener('DOMContentLoaded', function() {
            loadComments();
            updateLikeCount();
        });

        // Yorumları yükleme fonksiyonu
        function loadComments() {
            fetch(`/player/${playerId}/getComments`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const commentsContainer = document.getElementById('comments-container');
                        commentsContainer.innerHTML = '';

                        data.comments.forEach(comment => {
                            const commentElement = createCommentElement(comment);
                            commentsContainer.appendChild(commentElement);
                        });
                    }
                })
                .catch(error => console.error('Error loading comments:', error));
        }

        // Yorum elementi oluşturma fonksiyonu
        function createCommentElement(comment) {
            const div = document.createElement('div');
            div.className = 'comment-card';
            div.innerHTML = `
                <div class="comment-card-content p-3">
                    <div class="comment-header">
                        <span class="comment-user">${comment.user_name}</span>
                        <span class="comment-date">${comment.created_at}</span>
                    </div>
                    <p class="comment-text text-white">${comment.content}</p>
                    <div class="comment-actions">
                        ${currentUserId ? `
                            <button class="btn btn-sm btn-outline-light"
                                    onclick="showReplyForm('${comment.id}')">
                                <i class="fas fa-reply me-1"></i>Yanıtla
                            </button>
                        ` : ''}
                        ${comment.user_id === currentUserId ? `
                            <button class="btn btn-sm btn-outline-danger"
                                    onclick="deleteComment('${comment.id}')">
                                <i class="fas fa-trash-alt me-1"></i>Sil
                            </button>
                        ` : ''}
                    </div>
                    <div id="reply-form-${comment.id}" class="reply-form" style="display: none;">
                        <textarea class="form-control mb-2" rows="2" placeholder="Yanıtınızı yazın..."></textarea>
                        <button class="btn-sm" onclick="submitReply('${comment.id}')">
                            <i class="fas fa-paper-plane me-1"></i>Yanıtla
                        </button>
                    </div>
                    <div class="replies mt-3">
                        ${comment.replies ? comment.replies.map(reply => `
                            <div class="reply-card mb-1">
                                <div class="comment-header">
                                    <span class="comment-user">${reply.user_name}</span>
                                    <span class="comment-date">${reply.created_at}</span>
                                </div>
                                <p class="comment-text text-white">${reply.content}</p>
                                ${reply.user_id === currentUserId ? `
                                    <button class="btn btn-sm btn-outline-danger mt-2"
                                            onclick="deleteComment('${reply.id}')">
                                        <i class="fas fa-trash-alt me-1"></i>Sil
                                    </button>
                                ` : ''}
                            </div>
                        `).join('') : ''}
                    </div>
                </div>
            `;
            return div;
        }

        // Yorum gönderme fonksiyonu
        function submitComment() {
            const content = document.getElementById('comment-input').value.trim();

            if (!content) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Uyarı',
                    text: 'Lütfen bir yorum yazın!'
                });
                return;
            }

            fetch(`/player/${playerId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ content: content })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('comment-input').value = '';
                    loadComments();
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı',
                        text: 'Yorumunuz eklendi!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: 'Bir hata oluştu!'
                });
            });
        }

        // Yanıt formunu gösterme/gizleme fonksiyonu
        function showReplyForm(commentId) {
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        }

        // Yanıt gönderme fonksiyonu
        function submitReply(commentId) {
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            const content = replyForm.querySelector('textarea').value.trim();

            if (!content) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Uyarı',
                    text: 'Lütfen bir yanıt yazın!'
                });
                return;
            }

            fetch(`/player/${playerId}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    content: content,
                    parent_id: commentId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    replyForm.querySelector('textarea').value = '';
                    replyForm.style.display = 'none';
                    loadComments();
                    Swal.fire({
                        icon: 'success',
                        title: 'Başarılı',
                        text: 'Yanıtınız eklendi!',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: 'Bir hata oluştu!'
                });
            });
        }

        // Yorum silme fonksiyonu
        function deleteComment(commentId) {
            Swal.fire({
                title: 'Emin misiniz?',
                text: 'Bu yorumu silmek istediğinizden emin misiniz?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Evet, sil',
                cancelButtonText: 'İptal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/player/comment/${commentId}/delete`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            loadComments();
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı',
                                text: 'Yorum silindi!',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                text: data.message
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata',
                            text: 'Bir hata oluştu!'
                        });
                    });
                }
            });
        }

        // Beğeni sayısını güncelleme fonksiyonu
        function updateLikeCount() {
            fetch(`/like-count/${playerId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('like-count').textContent = data.likeCount;
                })
                .catch(error => console.error('Error updating like count:', error));
        }

        // Beğeni toggle fonksiyonu
        function toggleLike(playerId) {
            fetch(`/player/${playerId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateLikeCount();
                    const likeButton = document.getElementById('like-button');
                    likeButton.classList.toggle('liked', data.liked);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Hata',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Hata',
                    text: 'Bir hata oluştu!'
                });
            });
        }
    </script>




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
                url: `/player/${playerId}/like`,
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
                    type: 'area', // Grafik türü 'area'
                    parentHeightOffset: 0,
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    },
                    dropShadow: {
                        enabled: true,
                        top: 35,
                        left: 0,
                        blur: 30,
                        color: '#1ef876',
                        opacity: 0.4 // Gölge opaklık
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
                    colors: ['#1ef876'],
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
                    curve: 'smooth',
                    colors: ['#1ef876'], // Çizgi rengi
                    width: 2
                },
                fill: {
                    type: 'gradient', // Alt dolgu için degrade efekti
                    gradient: {
                        shade: 'dark',
                        type: 'vertical',
                        shadeIntensity: 0.5,
                        gradientToColors: ['#1ef876'], // Alt alan rengi
                        inverseColors: false,
                        opacityFrom: 0.4, // Çizgiye yakın alan opaklığı
                        opacityTo: 0, // Alt kısımda tamamen şeffaf
                        stops: [0, 100]
                    }
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
