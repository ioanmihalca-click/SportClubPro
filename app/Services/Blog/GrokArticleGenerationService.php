<?php

namespace App\Services\Blog;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GrokArticleGenerationService
{
    private string $apiKey;
    private string $baseUrl;
    private array $headers;

    public function __construct()
    {
        $this->apiKey = config('anthropic.api_key');
        $this->baseUrl = config('anthropic.base_url', 'https://api.x.ai');
        $this->headers = [
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function generateArticle(string $category, string $template, string $topic): array
    {
        try {
            $response = Http::withHeaders($this->headers)
                ->timeout(30)
                ->post("{$this->baseUrl}/v1/chat/completions", [
                    'model' => 'grok-beta',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $this->getSystemPrompt()
                        ],
                        [
                            'role' => 'user',
                            'content' => $this->buildPrompt($category, $template, $topic)
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 2048
                ]);

            if (!$response->successful()) {
                Log::error('API Response:', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                    'headers' => $response->headers()
                ]);
                throw new Exception($response->json('error.message', 'Unknown API error'));
            }

            $content = $response->json('choices.0.message.content');

            return [
                'success' => true,
                'content' => $content,
                'title' => $this->generateTitle($category, $template, $topic),
                'meta_description' => $this->generateMetaDescription($category, $template, $topic)
            ];
        } catch (Exception $e) {
            Log::error('Grok Article Generation failed:', [
                'error' => $e->getMessage(),
                'category' => $category,
                'template' => $template,
                'topic' => $topic
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function getSystemPrompt(): string
    {
        return "Ești un expert în management sportiv care scrie pentru SportClubPro.ro. " .
            "Scrie conținut informativ, profesional dar accesibil, optimizat pentru SEO. " .
            "Folosește exemple practice și date concrete când este posibil. " .
            "Scrie în limba română folosind diacritice. " .
            "Structurează conținutul cu subtitluri clare și pune accent pe valoarea practică pentru managerii de cluburi sportive.";
    }
    private function buildPrompt(string $category, string $template, string $topic): string
    {
        $prompts = [
            'management' => [
                'how_to' => [
                    "prompt" => "Creează un ghid pas cu pas despre {$topic} pentru managerii de cluburi sportive.",
                    "structure" => "
                       1. Introducere și importanța subiectului
                       2. Pași detaliați și acționabili
                       3. Exemple practice din cluburi sportive
                       4. Sfaturi de implementare
                       5. Rezultate așteptate și beneficii
                       6. Concluzii și următorii pași"
                ],
                'guide' => [
                    "prompt" => "Creează un ghid complet despre {$topic} în managementul cluburilor sportive.",
                    "structure" => "
                       1. Context și importanță
                       2. Concepte fundamentale
                       3. Strategii de implementare
                       4. Studii de caz
                       5. Provocări și soluții
                       6. Recomandări practice"
                ],
                'analysis' => [
                    "prompt" => "Analizează detaliat aspectele cheie ale {$topic} în managementul cluburilor sportive.",
                    "structure" => "
                       1. Prezentare generală
                       2. Analiza situației actuale
                       3. Puncte forte și vulnerabilități
                       4. Oportunități de îmbunătățire
                       5. Recomandări strategice
                       6. Concluzii și perspective"
                ]
            ],
            'marketing' => [
                'how_to' => [
                    "prompt" => "Creează un ghid practic de marketing despre {$topic} pentru cluburi sportive.",
                    "structure" => "
                       1. Introducere în contextul marketingului sportiv
                       2. Obiective și strategie
                       3. Tactici și canale de implementare
                       4. Măsurare și KPIs
                       5. Exemple de succes
                       6. Plan de acțiune"
                ],
                'strategy' => [
                    "prompt" => "Dezvoltă o strategie completă de marketing pentru {$topic} în cluburile sportive.",
                    "structure" => "
                       1. Analiza pieței și a competiției
                       2. Definirea obiectivelor
                       3. Segmentarea și targetarea
                       4. Strategii de poziționare
                       5. Plan de implementare
                       6. Buget și ROI"
                ],
                'trends' => [
                    "prompt" => "Analizează cele mai noi tendințe în {$topic} pentru marketingul cluburilor sportive.",
                    "structure" => "
                       1. Tendințe actuale în industrie
                       2. Tehnologii emergente
                       3. Comportamentul consumatorilor
                       4. Studii de caz relevante
                       5. Oportunități și provocări
                       6. Recomandări de implementare"
                ]
            ],
            'finance' => [
                'how_to' => [
                    "prompt" => "Oferă un ghid pas cu pas despre {$topic} în managementul financiar al cluburilor sportive.",
                    "structure" => "
                       1. Bazele managementului financiar
                       2. Analiza situației actuale
                       3. Strategii de optimizare
                       4. Implementare practică
                       5. Monitorizare și control
                       6. Indicatori de succes"
                ],
                'analysis' => [
                    "prompt" => "Analizează aspectele financiare ale {$topic} în cluburile sportive.",
                    "structure" => "
                       1. Context financiar
                       2. Analiza cost-beneficiu
                       3. Riscuri și oportunități
                       4. Strategii de optimizare
                       5. Recomandări practice
                       6. Plan de implementare"
                ],
                'planning' => [
                    "prompt" => "Creează un plan financiar pentru {$topic} în cluburile sportive.",
                    "structure" => "
                       1. Obiective financiare
                       2. Analiza resurselor
                       3. Strategii de finanțare
                       4. Bugetare și previziuni
                       5. Managementul riscurilor
                       6. Plan de monitorizare"
                ]
            ],
            'technology' => [
                'guide' => [
                    "prompt" => "Creează un ghid despre implementarea {$topic} în cluburile sportive.",
                    "structure" => "
                       1. Introducere în tehnologie
                       2. Beneficii și avantaje
                       3. Proces de implementare
                       4. Integrare cu sisteme existente
                       5. Training și adopție
                       6. Măsurarea succesului"
                ],
                'trends' => [
                    "prompt" => "Analizează tendințele tehnologice în {$topic} pentru cluburi sportive.",
                    "structure" => "
                       1. Tendințe actuale
                       2. Impactul în sport
                       3. Cazuri de utilizare
                       4. Beneficii și provocări
                       5. Costuri și ROI
                       6. Ghid de adoptare"
                ],
                'implementation' => [
                    "prompt" => "Oferă un plan de implementare pentru {$topic} în cluburile sportive.",
                    "structure" => "
                       1. Evaluarea necesităților
                       2. Selectarea soluției
                       3. Plan de implementare
                       4. Managementul schimbării
                       5. Training și suport
                       6. Monitorizare și optimizare"
                ]
            ],
            'youth_development' => [
                'guide' => [
                    "prompt" => "Creează un ghid complet despre {$topic} în dezvoltarea tinerilor sportivi.",
                    "structure" => "
           1. Fundamentele dezvoltării juniorilor
           2. Strategii pedagogice
           3. Planificare și periodizare
           4. Monitorizarea progresului
           5. Colaborarea cu părinții
           6. Evaluare și ajustare"
                ],
                'best_practices' => [
                    "prompt" => "Prezintă cele mai bune practici pentru {$topic} în dezvoltarea juniorilor.",
                    "structure" => "
           1. Standarde internaționale
           2. Metodologii dovedite
           3. Studii de caz de succes
           4. Greșeli comune de evitat
           5. Implementare practică
           6. Măsurarea rezultatelor"
                ],
                'program' => [
                    "prompt" => "Dezvoltă un program structurat pentru {$topic} în dezvoltarea tinerilor.",
                    "structure" => "
           1. Obiective și scop
           2. Structura programului
           3. Metodologie de antrenament
           4. Resurse necesare
           5. Implementare și monitorizare
           6. Evaluare și feedback"
                ]
            ],

            'coaching' => [
                'guide' => [
                    "prompt" => "Creează un ghid pentru antrenori despre {$topic}.",
                    "structure" => "
           1. Principii fundamentale
           2. Metodologie de coaching
           3. Tehnici practice
           4. Dezvoltarea sportivilor
           5. Managementul echipei
           6. Evaluare și îmbunătățire"
                ],
                'techniques' => [
                    "prompt" => "Prezintă tehnici și metode pentru {$topic} în coaching.",
                    "structure" => "
           1. Fundamentele tehnicii
           2. Metodologie de antrenament
           3. Progresie și dezvoltare
           4. Corectarea greșelilor
           5. Exemple practice
           6. Plan de implementare"
                ],
                'best_practices' => [
                    "prompt" => "Descrie cele mai bune practici pentru {$topic} în coaching.",
                    "structure" => "
           1. Standarde profesionale
           2. Metode dovedite
           3. Exemple din sport
           4. Implementare practică
           5. Provocări și soluții
           6. Dezvoltare continuă"
                ]
            ],

            'case_studies' => [
                'success_story' => [
                    "prompt" => "Prezintă un studiu de caz despre cum {$topic} a dus la succes.",
                    "structure" => "
           1. Context și provocări
           2. Obiective stabilite
           3. Strategii implementate
           4. Rezultate obținute
           5. Lecții învățate
           6. Recomandări practice"
                ],
                'analysis' => [
                    "prompt" => "Analizează detaliat cazul {$topic} și lecțiile învățate.",
                    "structure" => "
           1. Prezentarea situației
           2. Analiza factorilor
           3. Decizii cheie
           4. Implementare și rezultate
           5. Impact și beneficii
           6. Concluzii și recomandări"
                ],
                'implementation' => [
                    "prompt" => "Descrie implementarea și rezultatele {$topic} într-un club sportiv.",
                    "structure" => "
           1. Planificare inițială
           2. Proces de implementare
           3. Provocări întâmpinate
           4. Soluții aplicate
           5. Rezultate măsurate
           6. Lecții pentru viitor"
                ]
            ],

            'events' => [
                'planning' => [
                    "prompt" => "Creează un ghid de planificare pentru {$topic} în evenimente sportive.",
                    "structure" => "
           1. Conceptul evenimentului
           2. Planificare și logistică
           3. Resurse necesare
           4. Marketing și promovare
           5. Execuție și coordonare
           6. Evaluare post-eveniment"
                ],
                'management' => [
                    "prompt" => "Oferă strategii de management pentru {$topic} în organizarea evenimentelor.",
                    "structure" => "
           1. Fundamentele managementului
           2. Structura organizatorică
           3. Coordonare și control
           4. Gestionarea resurselor
           5. Managementul riscurilor
           6. Măsurarea succesului"
                ],
                'best_practices' => [
                    "prompt" => "Prezintă cele mai bune practici pentru {$topic} în evenimente sportive.",
                    "structure" => "
           1. Standarde în industrie
           2. Strategii dovedite
           3. Exemple de succes
           4. Implementare practică
           5. Evitarea greșelilor
           6. Optimizare continuă"
                ]
            ],

            'legal' => [
                'guide' => [
                    "prompt" => "Oferă un ghid despre aspectele legale ale {$topic} în sport.",
                    "structure" => "
           1. Cadrul legal
           2. Reglementări specifice
           3. Obligații și responsabilități
           4. Implementare practică
           5. Managementul riscurilor
           6. Resurse și suport"
                ],
                'compliance' => [
                    "prompt" => "Explică cerințele de conformitate pentru {$topic} în cluburile sportive.",
                    "structure" => "
           1. Cerințe legale
           2. Standarde de conformitate
           3. Proces de implementare
           4. Monitorizare și control
           5. Documentație necesară
           6. Plan de acțiune"
                ],
                'regulations' => [
                    "prompt" => "Prezintă reglementările importante pentru {$topic} în sport.",
                    "structure" => "
           1. Cadrul regulamentar
           2. Interpretare și aplicare
           3. Impact practic
           4. Conformitate și audit
           5. Exemple și cazuri
           6. Resurse utile"
                ]
            ],

            'health' => [
                'guide' => [
                    "prompt" => "Creează un ghid despre {$topic} în sănătatea și nutriția sportivilor.",
                    "structure" => "
           1. Fundamentele sănătății
           2. Principii de nutriție
           3. Implementare practică
           4. Monitorizare și evaluare
           5. Prevenție și recuperare
           6. Recomandări personalizate"
                ],
                'best_practices' => [
                    "prompt" => "Prezintă cele mai bune practici pentru {$topic} în sănătatea sportivă.",
                    "structure" => "
           1. Standarde medicale
           2. Protocoale dovedite
           3. Implementare în practică
           4. Monitorizare și ajustare
           5. Studii de caz
           6. Resurse și suport"
                ],
                'recommendations' => [
                    "prompt" => "Oferă recomandări pentru {$topic} în nutriția sportivă.",
                    "structure" => "
           1. Principii de bază
           2. Recomandări specifice
           3. Plan de implementare
           4. Monitorizare progres
           5. Ajustări și optimizare
           6. Resurse adiționale"
                ]
            ]
        ];

        $templateData = $prompts[$category][$template] ?? throw new Exception("Template invalid pentru categoria specificată");

        return $templateData['prompt'] . "\n\n" .
            "Folosește următoarea structură:\n" .
            $templateData['structure'] . "\n\n" .
            "Asigură-te că:\n" .
            "- Conținutul este optimizat SEO\n" .
            "- Folosești exemple concrete din industria sportivă\n" .
            "- Oferi valoare practică pentru managerii de cluburi sportive\n" .
            "- Incluzi date și statistici relevante când este posibil\n" .
            "- Menționezi cum SportClubPro.ro poate ajuta în implementare";
    }

    private function generateTitle(string $category, string $template, string $topic): string
    {
        $titleTemplates = [
            'management' => [
                'how_to' => "Cum să {$topic}: Ghid pentru Managerii de Cluburi Sportive",
                'guide' => "Ghid Complet: {$topic} în Managementul Cluburilor Sportive",
                'analysis' => "{$topic}: Analiză Detaliată pentru Cluburi Sportive",
            ],
            'marketing' => [
                'how_to' => "Strategii de Marketing: Cum să {$topic} în Clubul Tău Sportiv",
                'strategy' => "Plan de Marketing: {$topic} pentru Cluburi Sportive în 2024",
                'trends' => "Tendințe {$topic}: Strategii de Marketing pentru Cluburi Sportive",
            ],
            'finance' => [
                'how_to' => "Management Financiar: Cum să {$topic} în Clubul Tău Sportiv",
                'analysis' => "Analiza Financiară: {$topic} pentru Cluburi Sportive",
                'planning' => "Planificare Financiară: {$topic} în Cluburi Sportive",
            ],
            'technology' => [
                'guide' => "Tehnologie în Sport: Ghid pentru {$topic}",
                'trends' => "Inovație în Sport: {$topic} pentru Cluburi Moderne",
                'implementation' => "Implementare Tehnologică: {$topic} în Clubul Tău Sportiv",
            ],
            'youth_development' => [
                'guide' => "Dezvoltarea Juniorilor: Ghid Complet pentru {$topic}",
                'best_practices' => "Best Practices în {$topic} pentru Tinerii Sportivi",
                'program' => "Program de Dezvoltare: {$topic} pentru Juniori",
            ],
            'coaching' => [
                'guide' => "Ghidul Antrenorului: {$topic} în Clubul Sportiv",
                'techniques' => "Tehnici de Coaching: {$topic} pentru Performanță",
                'best_practices' => "Best Practices în Coaching: {$topic}",
            ],
            'case_studies' => [
                'success_story' => "Studiu de Caz: Cum {$topic} a Transformat un Club Sportiv",
                'analysis' => "Analiză de Succes: {$topic} în Cluburile Sportive",
                'implementation' => "De la Teorie la Practică: {$topic} în Clubul Sportiv",
            ],
            'events' => [
                'planning' => "Organizare Evenimente: {$topic} în Clubul Tău Sportiv",
                'management' => "Management de Evenimente: Ghid pentru {$topic}",
                'best_practices' => "Best Practices: {$topic} în Evenimente Sportive",
            ],
            'legal' => [
                'guide' => "Aspecte Legale: {$topic} în Cluburile Sportive",
                'compliance' => "Conformitate și Legislație: {$topic} în Sport",
                'regulations' => "Reglementări Sportive: Ghid pentru {$topic}",
            ],
            'health' => [
                'guide' => "Sănătate în Sport: Ghid Complet pentru {$topic}",
                'best_practices' => "Best Practices: {$topic} în Sănătatea Sportivă",
                'recommendations' => "Recomandări pentru {$topic} în Sport",
            ]
        ];

        return $titleTemplates[$category][$template] ?? throw new Exception("Template de titlu invalid");
    }

    private function generateMetaDescription(string $category, string $template, string $topic): string
    {
        $metaTemplates = [
            'management' => [
                'how_to' => "Descoperă cum să {$topic} în clubul tău sportiv. Ghid practic cu strategii verificate pentru management eficient și rezultate dovedite.",
                'guide' => "Ghid complet despre {$topic} pentru managerii de cluburi sportive. Strategii testate, sfaturi practice și instrumente esențiale pentru succes.",
                'analysis' => "Analiză detaliată a {$topic} în managementul sportiv. Insight-uri valoroase și strategii practice pentru clubul tău.",
            ],
            'marketing' => [
                'how_to' => "Află cum să implementezi {$topic} în strategia de marketing a clubului tău sportiv. Sfaturi practice și exemple concrete.",
                'strategy' => "Plan de marketing complet pentru {$topic}. Descoperă tendințe, strategii și tehnici dovedite pentru succes în sport.",
                'trends' => "Explorează tendințele actuale în {$topic} pentru cluburi sportive. Insight-uri și recomandări pentru succes în 2024.",
            ],
            'finance' => [
                'how_to' => "Cum să gestionezi eficient {$topic} în clubul tău sportiv. Sfaturi practice pentru un management financiar de succes.",
                'analysis' => "Analiză financiară detaliată: {$topic} pentru cluburi sportive. Insight-uri și strategii pentru performanță financiară.",
                'planning' => "Planificarea financiară pentru {$topic}. Descoperă strategii de succes pentru stabilitate și creștere economică.",
            ],
            'technology' => [
                'guide' => "Descoperă cum {$topic} poate transforma cluburile sportive. Ghid complet pentru inovație și tehnologie în sport.",
                'trends' => "Află tendințele tehnologice în {$topic} și cum să le implementezi în clubul tău sportiv.",
                'implementation' => "Cum să implementezi {$topic} în clubul tău sportiv. Pași practici și beneficii dovedite.",
            ],
            'youth_development' => [
                'guide' => "Ghid complet pentru dezvoltarea juniorilor: {$topic}. Strategii și bune practici pentru succes pe termen lung.",
                'best_practices' => "Explorează cele mai bune practici pentru {$topic} în dezvoltarea tinerilor sportivi.",
                'program' => "Cum să implementezi un program de dezvoltare pentru {$topic}. Ghid complet pentru antrenori și manageri.",
            ],
            'coaching' => [
                'guide' => "Tot ce trebuie să știi despre {$topic} în coaching sportiv. Ghid complet pentru antrenori profesioniști.",
                'techniques' => "Tehnici avansate pentru {$topic} în coaching. Sfaturi practice pentru a îmbunătăți performanța sportivă.",
                'best_practices' => "Cele mai bune practici în coaching: {$topic}. Sfaturi și strategii pentru succes pe teren.",
            ],
            'case_studies' => [
                'success_story' => "Studiu de caz: Cum {$topic} a influențat succesul unui club sportiv. Descoperă detalii și lecții învățate.",
                'analysis' => "Analiză aprofundată despre {$topic} în cluburile sportive. Exemple și insight-uri valoroase.",
                'implementation' => "Cum să implementezi {$topic} în clubul tău sportiv. Lecții din studiile de caz recente.",
            ],
            'events' => [
                'planning' => "Ghid complet pentru organizarea evenimentelor: {$topic}. Sfaturi practice pentru succes.",
                'management' => "Cum să gestionezi eficient {$topic} în evenimente sportive. Descoperă strategii esențiale.",
                'best_practices' => "Cele mai bune practici pentru {$topic} în evenimente sportive. Sfaturi pentru organizatori.",
            ],
            'legal' => [
                'guide' => "Aspectele legale esențiale despre {$topic} în cluburile sportive. Ghid complet pentru conformitate.",
                'compliance' => "Cum să asiguri conformitatea legală în {$topic}. Sfaturi practice și exemple relevante.",
                'regulations' => "Reglementări sportive despre {$topic}. Tot ce trebuie să știi pentru a respecta legislația.",
            ],
            'health' => [
                'guide' => "Cum să promovezi sănătatea în sport: {$topic}. Ghid complet pentru cluburi sportive.",
                'best_practices' => "Cele mai bune practici pentru {$topic} în sănătatea sportivilor. Strategii dovedite.",
                'recommendations' => "Recomandări cheie pentru {$topic} în sport. Sfaturi pentru sănătatea și performanța optimă.",
            ],
        ];

        $defaultMeta = "Află tot ce trebuie să știi despre {$topic} în managementul cluburilor sportive. Ghid complet cu exemple practice și strategii dovedite.";

        return $metaTemplates[$category][$template] ?? $defaultMeta;
    }

    public function generateArticleTitle(string $category, string $template, string $topic): string
    {
        try {
            return $this->generateTitle($category, $template, $topic);
        } catch (Exception $e) {
            Log::error('Title generation failed:', [
                'error' => $e->getMessage(),
                'category' => $category,
                'template' => $template
            ]);
            return "Ghid: {$topic} pentru Cluburi Sportive";
        }
    }

    public function generateArticleMetaDescription(string $category, string $template, string $topic): string
    {
        try {
            return $this->generateMetaDescription($category, $template, $topic);
        } catch (Exception $e) {
            Log::error('Meta description generation failed:', [
                'error' => $e->getMessage(),
                'category' => $category,
                'template' => $template
            ]);
            return "Descoperă strategii și sfaturi practice despre {$topic} pentru clubul tău sportiv. Ghid complet cu exemple și studii de caz.";
        }
    }

    // public function testConnection(): array
    // {
    //     try {
    //         $response = Http::withHeaders($this->headers)
    //             ->get("{$this->baseUrl}/v1/models");

    //         if (!$response->successful()) {
    //             throw new Exception($response->json('error.message', 'Connection test failed'));
    //         }

    //         return [
    //             'success' => true,
    //             'models' => $response->json('data', [])
    //         ];
    //     } catch (Exception $e) {
    //         return [
    //             'success' => false,
    //             'error' => $e->getMessage()
    //         ];
    //     }
    // }
}
