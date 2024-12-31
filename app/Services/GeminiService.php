<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{

    private $apiKey;

    public function __construct()
    {
        $this->apiKey = env('GOOGLE_API_KEY');  // API Key'inizi .env dosyasından alıyoruz
    }

    // Analyzing player details
    public function analyzePlayer($playerDetails)
    {
        // API request to Gemini with player details
        $response = $this->sendApiRequest($playerDetails);
        // Check if response contains error and is an array
        if (is_array($response) && isset($response['error'])) {
            // return error and message
            return ['success' => false, 'error' => $response['error'], 'message' => $response['message']];
        }
        // Return the response data
        return ['success' => true, 'data' => $response];
    }

    // Sending request to Gemini API
    private function sendApiRequest($playerDetails)
    {
        // Get the API key from environment
        $apiKey = getenv('GEMINI_API_KEY'); // API key goes here
        $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key='.$apiKey;
        // Check if $playerDetails is an array and ensure proper conversion to string
        function convertArrayToString($value)
        {
            // Eğer değer bir dizi ise, dizinin elemanlarını virgülle ayırarak birleştir
            if (is_array($value)) {
                // Dizi elemanlarını kontrol et ve gerektiğinde iç dizileri birleştir
                return implode(', ', array_map(function ($item) {
                    // Eğer eleman bir dizi ise, bu diziyi de birleştir
                    if (is_array($item)) {
                        // Eğer bu eleman bir dizi ise, iç içe diziler için tekrar fonksiyonu çağır
                        return convertArrayToString($item); // İç içe diziyi birleştir
                    }
                    return $item; // Eğer dizi değilse, öğeyi olduğu gibi döndür
                }, $value));
            }

            // Eğer değer bir dizi değilse, olduğu gibi döndür
            return $value;
        }


        $profile = isset($playerDetails['profile']) ? convertArrayToString($playerDetails['profile']) : '';
        $marketValue = isset($playerDetails['market_value']) ? convertArrayToString($playerDetails['market_value']) : '';
        $stats = isset($playerDetails['stats']) ? convertArrayToString($playerDetails['stats']) : '';

        // Prepare the prompt for Gemini API (this should be a string that instructs the model)
        $prompt = "Aşağıdaki futbolcu detaylarını analiz edin:\nAdı: {$profile}\nPiyasa Değeri: {$marketValue}\nİstatistikler: {$stats}\nFutbolcunun performansı ve gelecekteki potansiyel trendleri hakkında bir analiz sağlayın. Ayrıca, bu futbolcunun sana göre market değeri ne kadardıır ve oyuncu 5 yıl sonra ne duruma gelir. Rakip ismi kullanma bizim Sistemimizin adı Sahada";


        // API request to Gemini
        $response = Http::withHeaders([
            'Content-Type' => 'application/json', // Content-Type başlığını ayarla
        ])->post($apiUrl, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt] // Prompt burada yer alıyor
                    ]
                ]
            ]
        ]);
        $data = $response->json();

        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            // 'text' alanına eriş
            $text = $data['candidates'][0]['content']['parts'][0]['text'];
            // Veriyi döndür
            return $text;
        }
        else {
            // Hata durumunda hata mesajını döndür
            return ['error' => 'API Error', 'message' => 'API response does not contain expected data'];
        }

    }
}
