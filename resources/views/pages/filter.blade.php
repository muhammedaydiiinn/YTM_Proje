@extends('layout.app')

@section('content')
    <style>
        .filter-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Varsayılan 3 sütun */
            gap: 45px;
            padding: 20px;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto; /* Yatayda ortalama */
            justify-content: center; /* Yatay ortalama */
        }

        .filter-item {
            background: #1E2739;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
            padding: 20px; /* Padding'i daha uygun hale getirdik */
            text-align: center;
            width: 100%; /* Esnek genişlik */
            max-width: 270px; /* Sabit genişlik ile esnekliği birleştirdik */
            height: 250px;
            font-size: 18px; /* Daha küçük font boyutu */
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
            cursor: pointer;
        }

        .filter-item img {
            margin-bottom: 10px;
            max-width: 100%; /* Görselin genişliğini sınırladık */
            height: auto; /* Görselin yüksekliğini oranına göre ayarladık */

        }

        .filter-item label {
            margin-top: 10px;
        }

        .filter-item select,
        .filter-item input {
            width: 80%;
            margin-top: 10px;
            padding: 5px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            max-height: 30px;
        }

        .filter-button {
            grid-column: span 3;
            padding: 15px;
            background-color: #1E2739;
            color: #fff;
            font-size: 18px;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
            cursor: pointer;
            margin: 20px 120px;
        }

        .filter-button:hover {
            background-color: #181f2e;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
        }

        .filter-item:hover {
            background-color: #181f2e;
            border: 3px #1ef876;
            border-bottom: 6px #1ef876;
            border-style: none solid solid solid;
            border-radius: 15px;
        }

        .filter-item .filter-item-content {
            display: none;
        }

        /* Medya sorgusu - Ekran genişliği 1200px'den küçükse */
        @media (max-width: 1200px) {
            .filter-container {
                display: flex;
                flex-direction: column; /* Sadece 1 sütun yap */
                gap: 20px;
            }

            .filter-item {
                width: 100%; /* Genişlik %100 olacak şekilde ayarlandı */
                height: 220px; /* Yükseklik biraz daha küçültüldü */
            }

            .filter-button {
                margin: 20px 50px; /* Buton kenar boşluğu küçültüldü */
            }
        }

        /* Medya sorgusu - Ekran genişliği 768px'den küçükse */
        @media (max-width: 768px) {
            .filter-container {
                display: flex;
                flex-direction: column; /* Sadece 1 sütun yap */
                gap: 20px;
            }

            .filter-item {
                width: 100%; /* Tam genişlik */
                height: 200px; /* Yükseklik küçültüldü */
                margin: 0 auto; /* Yatayda ortalama */
                justify-content: center; /* Yatay ortalama */
            }

            .filter-button {
                margin: 20px 20px; /* Buton kenar boşluğu daha da küçültüldü */
            }
        }

        /* Medya sorgusu - Ekran genişliği 480px'den küçükse */
        @media (max-width: 480px) {
            .filter-container {
                display: flex;
                flex-direction: column; /* Sadece 1 sütun yap */
                gap: 15px;

            }

            .filter-item {
                width: 100%; /* Tam genişlik */
                height: 180px; /* Yükseklik daha da küçültüldü */
                margin: 0 auto; /* Yatayda ortalama */
                align-items: center;
                justify-content: center; /* Yatay ortalama */
            }

            .filter-button {
                margin: 20px; /* Butonun kenar boşluğu minimuma indirildi */
            }
            .filter-item label {
                margin: 0;
                padding-bottom: 5px;
            }
        }
        #error-message {
            color: red;
            display: flex;
            margin-top: 10px;
            justify-content: space-around;
        }
        #warning-message {
            color: red;
            display: none;
            margin-top: 10px;
            justify-content: space-around;
        }
        .filter-container-form{
            display: contents;

        }

    </style>

    <div class="filter-container">
        <!-- Pozisyon Filtresi -->
        <form class="filter-container-form" action="/filter-result" method="POST">
            @csrf <!-- Laravel'de CSRF koruması için -->
            <div class="filter-item" id="position-item1">
                <img src="{{asset('assets/img/filter_img/football-pitch 1.png')}}" alt="">
                <label for="position"><br>Pozisyon</label>
                <div id="position-item2" class="filter-item-content">
                    <label for="position">Pozisyon</label>
                    <select id="position" name="position">
                        <option value="" disabled selected>Pozisyon Seç</option>
                    </select>
                </div>
            </div>

            <!-- Yaş Filtresi -->
            <div class="filter-item" id="age-item1">
                <img src="{{asset('assets/img/filter_img/age 1.png')}}" alt=""/>
                <label for="age"><br>Yaş</label>
                <div id="age-item2" class="filter-item-content">
                    <label for="age">Yaş Aralığı</label>
                    <input type="number" id="age-min" name="min_age" placeholder="Min Yaş">
                    <input type="number" id="age-max" name="max_age" placeholder="Max Yaş">
                </div>
            </div>

            <!-- Değer Filtresi -->
            <div class="filter-item" id="price-item1">
                <img src="{{asset('assets/img/filter_img/value 1.png')}}" alt="">
                <label for="filter"><br>Değer</label>
                <div id="price-item2" class="filter-item-content">
                    <label for="price">Değer Aralığı (€)</label>
                    <input type="number" id="price-min" name="min_marketvalue" placeholder="Min Değer">
                    <input type="number" id="price-max" name="max_marketvalue" placeholder="Max Değer">
                </div>
            </div>

            <!-- Uyruk Filtresi -->
            <div class="filter-item" id="nationality-item1">
                <img src="{{asset('assets/img/filter_img/united-nations 1.png')}}" alt="">
                <label for="nationality"><br>Uyruk</label>
                <div id="nationality-item2" class="filter-item-content">
                    <label for="nationality">Uyruk</label>
                    <select id="nationality" name="nationality">
                        <option value="" disabled selected>Uyruk Seç</option>
                    </select>
                </div>
            </div>

            <!-- Kulüp Filtresi -->
            <div class="filter-item" id="club-item1">
                <img src="{{asset('assets/img/filter_img/shoe 1.png')}}" alt="">
                <label for="foot"><br>Tercih Edilen Ayak</label>
                <div id="foot-item2" class="filter-item-content">
                    <label for="foot">Tercih Edilen Ayak</label>
                    <select id="foot" name="foot">
                        <option value="" disabled selected>Ayak Seç</option>

                        <option value="right">Sağ</option>
                        <option value="left">Sol</option>
                    </select>
                </div>
            </div>


            <!-- Filtreleme Butonu -->
            <button type="submit" class="filter-button">Filtrele</button>

            <div id="warning-message">
                Lütfen en az bir filtre seçiniz!
            </div>
            <div id="error-message" ></div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            localStorage.removeItem('filter-results');
            // Sunucudan verileri çek
            fetch('/get-option') // Route'a istek at
                .then(response => response.json())
                .then(data => {
                    // Pozisyon isimlerini değiştir
                    const positionTranslations = {
                        'Goalkeeper': 'Kaleci',
                        'Centre-Back': 'Stoper',
                        'Centre-Forward': 'Forvet',
                        'Defensive Midfield': 'Defansif Orta Saha',
                        'Attacking Midfield': 'Ofansif Orta Saha',
                        'Central Midfield': 'Merkez Orta Saha',
                        'Left Midfield': 'Sol Açık',
                        'Left Winger': 'Sol Kanat',
                        'Left-Back': 'Sol Bek',
                        'Right Midfield': 'Sağ Açık',
                        'Right Winger': 'Sağ Kanat',
                        'Right-Back': 'Sağ Bek',
                        'Second Striker': 'Forvet Arkası'
                    };

                    // Pozisyonları doldur
                    const positionSelect = document.getElementById('position');
                    data.positions.forEach(position => {
                        const option = document.createElement('option');
                        option.value = position; // Orijinal değeri kullan (backend için)
                        option.textContent = positionTranslations[position] || position; // Çevrilen ya da orijinal isim
                        positionSelect.appendChild(option);
                    });

                    // Uyrukları doldur
                    const citizenshipSelect = document.getElementById('nationality');
                    data.citizenships.forEach(citizenship => {
                        const option = document.createElement('option');
                        option.value = citizenship;
                        option.textContent = citizenship;
                        citizenshipSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Veri çekilirken hata oluştu:', error));
        });
    </script>

    <script>
        // Tüm filtre öğelerini seç
        const filters = document.querySelectorAll(".filter-item");

        filters.forEach(filter => {
            // Filtre öğesinin ilk ve ikinci kısmını al
            const item1 = filter.querySelector(":first-child");  // Görsel + Metin
            const label = filter.querySelector("label"); // Label öğesi
            const item2 = filter.querySelector(".filter-item-content");  // Input alanları

            // Filtre öğesine tıklandığında
            filter.addEventListener("click", () => {
                item1.style.display = "none"; // İlk kısmı gizle
                label.style.display = "none"; // Label'ı da gizle
                item2.style.display = "block"; // İkinci kısmı göster
            });

            // İkinci kısmı gösteren kısmın tıklanmasını engelle
            item2.addEventListener("click", (event) => {
                // Burada bir şey yapılmaz, ikinci kısmı gizlemek engellenir
                event.stopPropagation(); // Burada tıklamanın yukarıya gitmesini engelliyoruz
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.querySelector("form");
            const warningMessage = document.getElementById("warning-message");

            form.addEventListener("submit", (event) => {
                const filters = {
                    position: document.getElementById("position").value,
                    nationality: document.getElementById("nationality").value,
                    foot: document.getElementById("foot").value,
                    min_age: document.getElementById("age-min").value,
                    max_age: document.getElementById("age-max").value,
                    min_marketvalue: document.getElementById("price-min").value,
                    max_marketvalue: document.getElementById("price-max").value
                };

                const hasActiveFilters = Object.values(filters).some(value => value !== "");
                if (!hasActiveFilters) {
                    event.preventDefault(); // Formun gönderilmesini durdur
                    warningMessage.style.display = "block";
                    setTimeout(() => warningMessage.style.display = "none", 3000);
                }
            });
        });

        // Mesaj gösterme fonksiyonu
        function displayMessage(elementId, message = null) {
            const element = document.getElementById(elementId);
            if (message) element.textContent = message;
            element.style.display = 'flex';
            setTimeout(() => element.style.display = 'none', 3000);
        }
    </script>

@endsection
