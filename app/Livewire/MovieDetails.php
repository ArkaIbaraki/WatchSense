<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserMovieLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MovieDetails extends Component
{
    public $movieId;
    public $movie = null;
    public $loading = true;
    public $cast = [];
    public $crew = [];

    public $isLiked = false;

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

    public function mount($movieId)
    {
        $this->movieId = $movieId;

        if (Auth::check()) {

            $this->isLiked = UserMovieLike::where('user_id', Auth::id())
                ->where('film_id', $this->movieId)
                ->where('is_liked', true)
                ->exists();
        }

        $this->fetchMovieDetails();
    }

    public function fetchMovieDetails()
    {
        try {

            $apiKey = config('services.tmdb.api_key');

            if (!$apiKey) {
                throw new \Exception('TMDB API KEY missing');
            }

            $cacheTtl = 60 * 60 * 12;

            /*
            |--------------------------------------------------------------------------
            | MOVIE DETAILS
            |--------------------------------------------------------------------------
            */

            $movieData = Cache::remember(
                "movie_details_{$this->movieId}",
                $cacheTtl,
                function () use ($apiKey) {

                    $response = Http::retry(3, 1000)
                        ->timeout(20)
                        ->withoutVerifying()
                        ->get(
                            "https://api.themoviedb.org/3/movie/{$this->movieId}",
                            [
                                'api_key' => $apiKey,
                            ]
                        );

                    if (!$response->successful()) {
                        throw new \Exception('Failed fetch movie');
                    }

                    return $response->json();
                }
            );

            $this->movie = [
                'id' => $movieData['id'] ?? null,

                'title' => $movieData['title'] ?? 'Unknown Movie',

                'poster_url' => !empty($movieData['poster_path'])
                    ? 'https://image.tmdb.org/t/p/w500' . $movieData['poster_path']
                    : null,

                'backdrop_url' => !empty($movieData['backdrop_path'])
                    ? 'https://image.tmdb.org/t/p/w1280' . $movieData['backdrop_path']
                    : null,

                'rating' => $movieData['vote_average'] ?? 0,

                'overview' => $movieData['overview'] ?? 'No overview available',

                'release_date' => $movieData['release_date'] ?? 'Unknown',

                'runtime' => $movieData['runtime'] ?? 0,

                'genres' => collect($movieData['genres'] ?? [])
                    ->pluck('name')
                    ->toArray(),

                'status' => $movieData['status'] ?? 'Unknown',

                'budget' => $movieData['budget'] ?? 0,

                'revenue' => $movieData['revenue'] ?? 0,

                'language' => $this->languageMap[
                    $movieData['original_language'] ?? 'en'
                ] ?? 'Unknown',

                'vote_count' => $movieData['vote_count'] ?? 0,
            ];

            /*
            |--------------------------------------------------------------------------
            | MOVIE CREDITS
            |--------------------------------------------------------------------------
            */

            try {

                $credits = Cache::remember(
                    "movie_credits_{$this->movieId}",
                    $cacheTtl,
                    function () use ($apiKey) {

                        $response = Http::retry(2, 1000)
                            ->timeout(15)
                            ->withoutVerifying()
                            ->get(
                                "https://api.themoviedb.org/3/movie/{$this->movieId}/credits",
                                [
                                    'api_key' => $apiKey,
                                ]
                            );

                        if (!$response->successful()) {
                            return [
                                'cast' => [],
                                'crew' => [],
                            ];
                        }

                        return $response->json();
                    }
                );

                /*
                |--------------------------------------------------------------------------
                | CAST
                |--------------------------------------------------------------------------
                */

                $this->cast = collect($credits['cast'] ?? [])
                    ->take(8)
                    ->map(function ($actor) {

                        return [
                            'id' => $actor['id'] ?? null,

                            'name' => $actor['name'] ?? 'Unknown',

                            'character' => $actor['character'] ?? 'Unknown',

                            'profile_path' => !empty($actor['profile_path'])
                                ? 'https://image.tmdb.org/t/p/w300' . $actor['profile_path']
                                : null,
                        ];
                    })
                    ->toArray();

                /*
                |--------------------------------------------------------------------------
                | CREW
                |--------------------------------------------------------------------------
                */

                $this->crew = collect($credits['crew'] ?? [])
                    ->filter(function ($member) {

                        return in_array(
                            $member['job'] ?? '',
                            [
                                'Director',
                                'Writer',
                                'Screenplay',
                                'Producer',
                                'Original Music Composer',
                            ]
                        );
                    })
                    ->take(6)
                    ->values()
                    ->toArray();

            } catch (\Exception $e) {

                \Log::warning(
                    'Credits fetch failed: ' . $e->getMessage()
                );

                $this->cast = [];
                $this->crew = [];
            }

            $this->loading = false;

        } catch (\Exception $e) {

            \Log::error(
                'MovieDetails Error: ' . $e->getMessage()
            );

            $this->loading = false;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Like
    |--------------------------------------------------------------------------
    */

    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();

        /*
        |--------------------------------------------------------------------------
        | FIND EXISTING LIKE
        |--------------------------------------------------------------------------
        */

        $like = UserMovieLike::where('user_id', $userId)
            ->where('film_id', $this->movieId)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | TOGGLE LIKE
        |--------------------------------------------------------------------------
        */

        if ($like) {

            $like->update([
                'is_liked' => !$like->is_liked
            ]);

            $this->isLiked = !$like->is_liked;

        } else {

            UserMovieLike::create([
                'user_id' => $userId,
                'film_id' => $this->movieId,
                'is_liked' => true,
            ]);

            $this->isLiked = true;
        }

        /*
        |--------------------------------------------------------------------------
        | CLEAR GRAPH CACHE
        |--------------------------------------------------------------------------
        */

        Cache::forget(
            "recommendations.user.{$userId}"
        );

        /*
        |--------------------------------------------------------------------------
        | OPTIONAL:
        | CLEAR MOVIE GRAPH CACHE
        |--------------------------------------------------------------------------
        */

        Cache::forget(
            "graph.user.likes.{$userId}"
        );

        /*
        |--------------------------------------------------------------------------
        | REFRESH RECOMMENDATION COMPONENT
        |--------------------------------------------------------------------------
        */

        $this->dispatch(
            'likeToggled',
            movieId: $this->movieId
        );
    }

    public function render()
    {
        return view('livewire.movie-details');
    }
}