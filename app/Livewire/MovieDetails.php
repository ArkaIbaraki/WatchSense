<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserMovieLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MovieDetails extends Component
{
    public $movieId;
    public $movie = null;
    public $loading = true;
    public $cast = [];
    public $crew = [];

    // LIKE STATUS
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

        // CHECK LIKE STATUS
        if (Auth::check()) {
            $this->isLiked = UserMovieLike::where('user_id', Auth::id())
                ->where('film_id', $this->movieId)
                ->exists();
        }

        $this->fetchMovieDetails();
    }

    public function fetchMovieDetails()
    {
        try {
            $apiKey = config('services.tmdb.api_key');

            if (!$apiKey) {
                throw new \Exception('TMDB_API_KEY not configured');
            }

            $response = Http::timeout(10)
                ->withoutVerifying()
                ->get("https://api.themoviedb.org/3/movie/{$this->movieId}", [
                    'api_key' => $apiKey,
                ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to fetch movie details');
            }

            $data = $response->json();

            $this->movie = [
                'id' => $data['id'] ?? null,
                'title' => $data['title'] ?? 'Unknown',
                'poster_url' => 'https://image.tmdb.org/t/p/w500' . ($data['poster_path'] ?? ''),
                'backdrop_url' => 'https://image.tmdb.org/t/p/w1280' . ($data['backdrop_path'] ?? ''),
                'rating' => $data['vote_average'] ?? 0,
                'overview' => $data['overview'] ?? 'No overview available',
                'release_date' => $data['release_date'] ?? 'N/A',
                'runtime' => $data['runtime'] ?? 0,
                'genres' => collect($data['genres'] ?? [])->pluck('name')->toArray(),
                'status' => $data['status'] ?? 'Unknown',
                'budget' => $data['budget'] ?? 0,
                'revenue' => $data['revenue'] ?? 0,
                'language' => $this->languageMap[$data['original_language'] ?? 'en'] ?? ucfirst($data['original_language'] ?? 'Unknown'),
                'vote_count' => $data['vote_count'] ?? 0,
            ];

            $creditsResponse = Http::timeout(10)
                ->withoutVerifying()
                ->get("https://api.themoviedb.org/3/movie/{$this->movieId}/credits", [
                    'api_key' => $apiKey,
                ]);

            if ($creditsResponse->successful()) {
                $creditsData = $creditsResponse->json();

                $this->cast = collect($creditsData['cast'] ?? [])->take(8)->map(function ($actor) {
                    return [
                        'id' => $actor['id'] ?? null,
                        'name' => $actor['name'] ?? 'Unknown',
                        'character' => $actor['character'] ?? 'Unknown',
                        'profile_path' => $actor['profile_path']
                            ? 'https://image.tmdb.org/t/p/w300' . $actor['profile_path']
                            : null,
                    ];
                })->toArray();

                $this->crew = collect($creditsData['crew'] ?? [])->filter(function ($member) {
                    return in_array($member['job'], [
                        'Director',
                        'Writer',
                        'Screenplay',
                        'Producer',
                        'Cinematography',
                        'Original Music Composer'
                    ]);
                })->take(6)->toArray();
            }

            $this->loading = false;

        } catch (\Exception $e) {
            \Log::error('Failed to fetch movie details: ' . $e->getMessage());
            $this->loading = false;
        }
    }

    // LIKE / UNLIKE MOVIE
    public function toggleLike()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $like = UserMovieLike::where('user_id', Auth::id())
            ->where('film_id', $this->movieId)
            ->first();

        if ($like) {
            $like->delete();
            $this->isLiked = false;
        } else {
            UserMovieLike::create([
                'user_id' => Auth::id(),
                'film_id' => $this->movieId,
                'is_liked' => true,
            ]);

            $this->isLiked = true;
        }
    }

    public function render()
    {
        return view('livewire.movie-details');
    }
}