<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;

class SerpController extends Controller
{
    public function index()
    {
        return view('serp');
    }

    public function search(Request $request)
    {
        $data = $request->validate([
            'keyword'  => 'required|string',
            'site'     => 'required|string',
            'location' => 'required|string',
            'language' => 'required|string',
        ]);

        // нормалізуємо домен
        $targetInput  = strtolower($data['site']);
        $targetDomain = parse_url($targetInput, PHP_URL_HOST) ?: $targetInput;
        $targetDomain = preg_replace('/^www\./', '', $targetDomain);

        $client = new Client([
            'base_uri'        => 'https://api.dataforseo.com/v3/',
            'auth'            => [env('DATAFORSEO_LOGIN'), env('DATAFORSEO_PASSWORD')],
            'timeout'         => 90,
            'connect_timeout' => 10,
            'headers'         => [
                'Accept' => 'application/json',
                'Expect' => ''
            ],
        ]);

        $payload = [[
            'keyword'       => $data['keyword'],
            'location_name' => $data['location'],
            'language_name' => $data['language'],
            'device'        => 'desktop',
            'se_domain' => env('SE_DOMAIN', 'google.com'),
            'depth'     => (int) env('SERP_DEPTH', 50), // можна повернути 100, коли все стабільно
        ]];

        // retry з бекофом
        $maxAttempts = 3;
        $attempt = 0;
        $response = null;

        while ($attempt < $maxAttempts) {
            try {
                $response = $client->post('serp/google/organic/live/advanced', ['json' => $payload]);
                break; // успіх
            } catch (ConnectException $e) {
                $attempt++;
                if ($attempt >= $maxAttempts) throw $e;
                usleep((int)(pow(2, $attempt) * 250000)); // 0.5s, 1s
            } catch (TransferException $e) {
                $attempt++;
                if ($attempt >= $maxAttempts) throw $e;
                usleep((int)(pow(2, $attempt) * 250000));
            }
        }

        if (!$response) {
            return view('serp', [
                'input' => $data,
                'error' => 'API timeout/retry failed. Try again or lower depth.',
            ]);
        }

        // парсимо відповідь ОДИН раз (без другого POST)
        $json  = json_decode((string) $response->getBody(), true) ?? [];
        $items = $json['tasks'][0]['result'][0]['items'] ?? [];

        $rank = null;
        $found = null;

        foreach ($items as $it) {
            $url = $it['url'] ?? '';
            $domain = strtolower(preg_replace('/^www\./', '', parse_url($url, PHP_URL_HOST) ?: $url));
            if ($domain === $targetDomain) {
                $rank  = $it['rank_absolute'] ?? $it['rank_group'] ?? null;
                $found = $it;
                break;
            }
        }

        return view('serp', [
            'input' => $data,
            'rank'  => $rank, // null => “не знайдено”
            'item'  => $found,
        ]);
    }



}
