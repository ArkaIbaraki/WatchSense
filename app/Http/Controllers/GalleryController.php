<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GalleryController extends Controller
{
    private $languageMap = [
        'aa' => 'Afar',
        'ab' => 'Abkhazian',
        'af' => 'Afrikaans',
        'ak' => 'Akan',
        'sq' => 'Albanian',
        'am' => 'Amharic',
        'an' => 'Aragonese',
        'ar' => 'Arabic',
        'hy' => 'Armenian',
        'as' => 'Assamese',
        'av' => 'Avaric',
        'ae' => 'Avestan',
        'ay' => 'Aymara',
        'az' => 'Azerbaijani',
        'ba' => 'Bashkir',
        'bm' => 'Bambara',
        'eu' => 'Basque',
        'be' => 'Belarusian',
        'bn' => 'Bengali',
        'bh' => 'Bihari',
        'bi' => 'Bislama',
        'bo' => 'Tibetan',
        'bs' => 'Bosnian',
        'br' => 'Breton',
        'bg' => 'Bulgarian',
        'my' => 'Burmese',
        'ca' => 'Catalan',
        'ch' => 'Chamorro',
        'ce' => 'Chechen',
        'zh' => 'Mandarin Chinese',
        'zh-Hans' => 'Simplified Chinese',
        'zh-Hant' => 'Traditional Chinese',
        'yue' => 'Cantonese',
        'wuu' => 'Wu Chinese',
        'cv' => 'Chuvash',
        'kw' => 'Cornish',
        'co' => 'Corsican',
        'cr' => 'Cree',
        'cs' => 'Czech',
        'da' => 'Danish',
        'dv' => 'Maldivian',
        'nl' => 'Dutch',
        'dz' => 'Dzongkha',
        'en' => 'English',
        'eo' => 'Esperanto',
        'et' => 'Estonian',
        'ee' => 'Ewe',
        'fo' => 'Faroese',
        'fj' => 'Fijian',
        'fi' => 'Finnish',
        'fr' => 'French',
        'fy' => 'Western Frisian',
        'ff' => 'Fulah',
        'ka' => 'Georgian',
        'de' => 'German',
        'gd' => 'Scottish Gaelic',
        'ga' => 'Irish',
        'gl' => 'Galician',
        'gv' => 'Manx',
        'el' => 'Greek',
        'gn' => 'Guarani',
        'gu' => 'Gujarati',
        'ht' => 'Haitian Creole',
        'ha' => 'Hausa',
        'he' => 'Hebrew',
        'hz' => 'Herero',
        'hi' => 'Hindi',
        'ho' => 'Hiri Motu',
        'hu' => 'Hungarian',
        'ig' => 'Igbo',
        'is' => 'Icelandic',
        'io' => 'Ido',
        'id' => 'Indonesian',
        'ia' => 'Interlingua',
        'ie' => 'Interlingue',
        'iu' => 'Inuktitut',
        'ik' => 'Inupiaq',
        'it' => 'Italian',
        'jv' => 'Javanese',
        'ja' => 'Japanese',
        'kl' => 'Kalaallisut',
        'kn' => 'Kannada',
        'ks' => 'Kashmiri',
        'kr' => 'Kanuri',
        'kk' => 'Kazakh',
        'km' => 'Central Khmer',
        'ki' => 'Kikuyu',
        'rw' => 'Kinyarwanda',
        'ky' => 'Kirghiz',
        'kv' => 'Komi',
        'kg' => 'Kongo',
        'ko' => 'Korean',
        'kj' => 'Kuanyama',
        'ku' => 'Kurdish',
        'lo' => 'Lao',
        'la' => 'Latin',
        'lv' => 'Latvian',
        'li' => 'Limburgish',
        'ln' => 'Lingala',
        'lt' => 'Lithuanian',
        'lb' => 'Luxembourgish',
        'lu' => 'Luba-Katanga',
        'lg' => 'Ganda',
        'mk' => 'Macedonian',
        'mh' => 'Marshallese',
        'ml' => 'Malayalam',
        'mi' => 'Maori',
        'mr' => 'Marathi',
        'ms' => 'Malay',
        'mg' => 'Malagasy',
        'mt' => 'Maltese',
        'mn' => 'Mongolian',
        'na' => 'Nauru',
        'nv' => 'Navajo',
        'nr' => 'South Ndebele',
        'nd' => 'North Ndebele',
        'ne' => 'Nepali',
        'ng' => 'Ndonga',
        'nn' => 'Norwegian Nynorsk',
        'nb' => 'Norwegian Bokmål',
        'no' => 'Norwegian',
        'ny' => 'Chichewa',
        'oc' => 'Occitan',
        'oj' => 'Ojibwa',
        'or' => 'Odia',
        'om' => 'Oromo',
        'os' => 'Ossetian',
        'pa' => 'Panjabi',
        'fa' => 'Persian',
        'pi' => 'Pali',
        'pl' => 'Polish',
        'pt' => 'Portuguese',
        'ps' => 'Pushto',
        'qu' => 'Quechua',
        'rm' => 'Romansh',
        'ro' => 'Romanian',
        'rn' => 'Rundi',
        'ru' => 'Russian',
        'sg' => 'Sango',
        'sa' => 'Sanskrit',
        'sc' => 'Sardinian',
        'sr' => 'Serbian',
        'sn' => 'Shona',
        'sd' => 'Sindhi',
        'si' => 'Sinhala',
        'sk' => 'Slovak',
        'sl' => 'Slovenian',
        'se' => 'Northern Sami',
        'sm' => 'Samoan',
        'sh' => 'Serbo-Croatian',
        'so' => 'Somali',
        'st' => 'Southern Sotho',
        'es' => 'Spanish',
        'su' => 'Sundanese',
        'sw' => 'Swahili',
        'ss' => 'Swati',
        'sv' => 'Swedish',
        'tl' => 'Tagalog',
        'ty' => 'Tahitian',
        'tg' => 'Tajik',
        'ta' => 'Tamil',
        'tt' => 'Tatar',
        'te' => 'Telugu',
        'th' => 'Thai',
        'ti' => 'Tigrinya',
        'to' => 'Tonga',
        'tn' => 'Tswana',
        'ts' => 'Tsonga',
        'tk' => 'Turkmen',
        'tr' => 'Turkish',
        'tw' => 'Twi',
        'ug' => 'Uighur',
        'uk' => 'Ukrainian',
        'ur' => 'Urdu',
        'uz' => 'Uzbek',
        've' => 'Venda',
        'vi' => 'Vietnamese',
        'vo' => 'Volapük',
        'cy' => 'Welsh',
        'wa' => 'Walloon',
        'wo' => 'Wolof',
        'xh' => 'Xhosa',
        'yi' => 'Yiddish',
        'yo' => 'Yoruba',
        'za' => 'Zhuang',
        'zu' => 'Zulu',
        'cn' => 'Cantonese',
        'mul' => 'Multiple Languages',
        'xx' => 'No Language',
        'zxx' => 'No Linguistic Content',
    ];

    /**
     * Get and validate TMDB API key from environment
     *
     * @return string
     * @throws \Exception
     */
    private function getApiKey()
    {
        $apiKey = config('services.tmdb.api_key');
        if (!$apiKey) {
            \Log::error('TMDB_API_KEY not configured - check .env file');
            throw new \Exception('TMDB API key not configured. Please set TMDB_API_KEY in .env');
        }
        return $apiKey;
    }

    public function index(Request $request)
    {
        try {
            $apiKey = $this->getApiKey();

            $search = $request->input('search', '');
            $page = $request->input('page', 1);

            // Fetch genres
            $genresResponse = Http::timeout(10)
                ->withoutVerifying()
                ->get('https://api.themoviedb.org/3/genre/movie/list', [
                    'api_key' => $apiKey,
                ]);

            $genreData = $genresResponse->json();
            $genreMap = [];

            if (isset($genreData['genres'])) {
                foreach ($genreData['genres'] as $genre) {
                    $genreMap[$genre['id']] = $genre['name'];
                }
            }

            // Search or Discover
            if (!empty($search)) {
                $response = Http::timeout(10)
                    ->withoutVerifying()
                    ->get('https://api.themoviedb.org/3/search/movie', [
                        'api_key' => $apiKey,
                        'query' => $search,
                        'page' => $page,
                    ]);
            } else {
                $response = Http::timeout(10)
                    ->withoutVerifying()
                    ->get('https://api.themoviedb.org/3/discover/movie', [
                        'api_key' => $apiKey,
                        'sort_by' => 'popularity.desc',
                        'page' => $page,
                    ]);
            }

            if (!$response->successful()) {
                throw new \Exception('API returned status: ' . $response->status());
            }

            $data = $response->json();

            $movies = [];
            if (isset($data['results']) && !empty($data['results'])) {
                $movies = collect($data['results'])->map(function ($movie) use ($genreMap) {
                    $genres = [];
                    if (isset($movie['genre_ids'])) {
                        $genres = array_map(function ($genreId) use ($genreMap) {
                            return $genreMap[$genreId] ?? 'Unknown';
                        }, array_slice($movie['genre_ids'], 0));
                    }

                    $languageCode = $movie['original_language'] ?? 'unknown';
                    $languageName = $this->languageMap[$languageCode] ?? ucfirst($languageCode);

                    return [
                        'id' => $movie['id'] ?? null,
                        'title' => $movie['title'] ?? 'Unknown',
                        'original_title' => $movie['original_title'] ?? $movie['title'] ?? 'Unknown',
                        'poster_url' => 'https://image.tmdb.org/t/p/w500' . ($movie['poster_path'] ?? ''),
                        'backdrop_url' => 'https://image.tmdb.org/t/p/w1280' . ($movie['backdrop_path'] ?? ''),
                        'rating' => $movie['vote_average'] ?? 0,
                        'overview' => $movie['overview'] ?? 'No overview available',
                        'release_date' => $movie['release_date'] ?? 'N/A',
                        'language' => $languageName,
                        'genres' => $genres,
                    ];
                })->toArray();
            }

            $totalPages = $data['total_pages'] ?? 1;
            $currentPage = $page;

            return view('gallery', [
                'movies' => $movies,
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'search' => $search,
            ]);

        } catch (\Exception $e) {
            \Log::error('Gallery Error: ' . $e->getMessage());
            return view('gallery', [
                'movies' => [],
                'currentPage' => 1,
                'totalPages' => 1,
                'search' => '',
                'error' => 'Failed to load movies',
            ]);
        }
    }

    public function searchPreview(Request $request)
    {
        try {
            $query = $request->input('q', '');

            if (strlen($query) < 1) {
                return response()->json([]);
            }

            $apiKey = $this->getApiKey();

            // Fetch genres for mapping
            $genresResponse = Http::timeout(10)
                ->withoutVerifying()
                ->get('https://api.themoviedb.org/3/genre/movie/list', [
                    'api_key' => $apiKey,
                ]);

            $genreData = $genresResponse->json();
            $genreMap = [];

            if (isset($genreData['genres'])) {
                foreach ($genreData['genres'] as $genre) {
                    $genreMap[$genre['id']] = $genre['name'];
                }
            }

            // Search movies
            $response = Http::timeout(10)
                ->withoutVerifying()
                ->get('https://api.themoviedb.org/3/search/movie', [
                    'api_key' => $apiKey,
                    'query' => $query,
                    'page' => 1,
                ]);

            if (!$response->successful()) {
                return response()->json([]);
            }

            $data = $response->json();
            $results = [];

            if (isset($data['results'])) {
                $results = collect($data['results'])->take(8)->map(function ($movie) use ($genreMap) {
                    $genres = [];
                    if (isset($movie['genre_ids'])) {
                        $genres = array_map(function ($genreId) use ($genreMap) {
                            return $genreMap[$genreId] ?? 'Unknown';
                        }, array_slice($movie['genre_ids'], 0, 3));
                    }

                    $languageCode = $movie['original_language'] ?? 'unknown';
                    $languageName = $this->languageMap[$languageCode] ?? ucfirst($languageCode);

                    return [
                        'id' => $movie['id'] ?? null,
                        'title' => $movie['title'] ?? 'Unknown',
                        'poster_url' => 'https://image.tmdb.org/t/p/w200' . ($movie['poster_path'] ?? ''),
                        'rating' => $movie['vote_average'] ?? 0,
                        'release_date' => $movie['release_date'] ?? 'N/A',
                        'language' => $languageName,
                        'genres' => $genres,
                    ];
                })->toArray();
            }

            return response()->json($results);

        } catch (\Exception $e) {
            \Log::error('Search Preview Error: ' . $e->getMessage());
            return response()->json([]);
        }
    }
}
