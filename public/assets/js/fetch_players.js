document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    let debounceTimeout;

    // Türkçe karakteri kontrol eden fonksiyon

    // İlk Türkçe karakteri silme fonksiyonu
    function removeFirstTurkishCharacter(str) {

            return str.slice(1); // İlk karakteri çıkar

    }

    if (searchInput) {
        searchInput.addEventListener('keyup', function (e) {
            if (e.key === 'Enter') {
                let searchQuery = this.value.trim();

                if (searchQuery !== '') {
                    // İlk Türkçe karakteri çıkar
                    // searchQuery = removeFirstTurkishCharacter(searchQuery);

                    $.ajax({
                        url: `/players/by-name?name=${encodeURIComponent(searchQuery)}`,
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        success: function (data) {
                            if (data.error) {
                                alert(data.error); // Show error message
                            } else {
                                // Save results to Local Storage
                                localStorage.setItem('searchResults', JSON.stringify(data));
                                localStorage.setItem('searchQuery', searchQuery);

                                // Redirect to results page
                                window.location.href = '/search-result';
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                } else {
                    alert('Please enter a search term.');
                }
            }
        });

        // Input event listener with debounce for live search
        searchInput.addEventListener('input', function () {
            clearTimeout(debounceTimeout); // Clear previous timeout
            let query = this.value;

            // İlk Türkçe karakteri çıkar
            // query = removeFirstTurkishCharacter(query);

            debounceTimeout = setTimeout(() => {
                let resultsContainer = document.getElementById('search-results');

                if (resultsContainer) {
                    if (query.length > 2) {
                        $.ajax({
                            url: `/live-search?query=${encodeURIComponent(query)}`,
                            method: 'GET',
                            success: function (data) {
                                resultsContainer.innerHTML = '';
                                if (data.length > 0) {
                                    data.forEach(player => {
                                        let div = document.createElement('div');
                                        div.textContent = player.profile.name;
                                        div.classList.add('search-result-item');
                                        div.addEventListener('click', function () {
                                            window.location.href = `/player/${player.profile.id}`;
                                        });
                                        resultsContainer.appendChild(div);
                                    });
                                    resultsContainer.style.display = 'block';
                                } else {
                                    resultsContainer.style.display = 'none';
                                }
                            },
                            error: function (xhr, status, error) {
                                console.error('Error:', error);
                            }
                        });
                    } else if (query.length === 0) {
                        // Clear results when input is cleared
                        resultsContainer.innerHTML = '';
                        resultsContainer.style.display = 'none';
                    }
                } else {
                    console.warn('search-results element not found.');
                }
            }, 1000); // Wait 1 second after the last input
        });

        // Set the width and position of the results container
        searchInput.addEventListener('focus', function () {
            let resultsContainer = document.getElementById('search-results');
            if (resultsContainer) {
                resultsContainer.style.width = `${searchInput.offsetWidth}px`;
            }
        });
    }
});
