<?php

namespace App\Models;

class Documentation
{
    public static function manual()
    {
        return [
            'title' => 'Manual de Utilizare SportClubPro',
            'version' => '1.0',
            'last_updated' => '2024',
            'sections' => self::getSections()
        ];
    }

    private static function getSections()
    {
        return [
            [
                'title' => '1. INTRODUCERE',
                'content' => [
                    'Despre SportClubPro' => 'SportClubPro este o platformă gratuită de management pentru cluburi sportive care oferă instrumente complete pentru gestionarea membrilor, prezențelor, plăților și evenimentelor.',
                    'Cerințe Sistem' => [
                        'Browser web modern (Chrome, Firefox, Safari, Edge)',
                        'Conexiune la internet',
                        'Dispozitiv: Desktop, Laptop, Tabletă sau Smartphone'
                    ],
                    'Acces și Autentificare' => [
                        'Accesați www.sportclubpro.ro',
                        'Click pe "Înregistrare" pentru cont nou',
                        'Sau "Login" pentru conturi existente'
                    ]
                ]
            ],
            [
                'title' => '2. PRIMII PAȘI',
                'content' => [
                    'Înregistrare Cont Nou' => [
                        'Accesați pagina de înregistrare',
                        'Completați datele personale',
                        'Confirmați emailul prin link-ul primit'
                    ],
                    'Configurare Club' => [
                        'După prima autentificare, completați datele clubului:',
                        '- Numele clubului',
                        '- Adresa',
                        '- Contact',
                        '- CIF/CUI (opțional)',
                        '- Adaugati logo-ul clubului (poza de profil) in sectiunea Profil.'
                    ],
                    'Setarea Grupelor' => [
                        'Accesați secțiunea "Grupe"',
                        'Click pe "Adaugă Grupă"',
                        'Completați numele și descrierea grupei',
                        'Salvați noua grupă'
                    ],
                    'Configurare Cotizații' => [
                        'Accesați secțiunea "Tipuri Cotizații"',
                        'Adăugați diferite tipuri de cotizații (standard, elevi etc.)',
                        'Setați suma pentru fiecare tip'
                    ]
                ]
            ],
            [
                'title' => '3. MANAGEMENT MEMBRI',
                'content' => [
                    'Adăugare Membri' => [
                        'Click pe "Adaugă Membru"',
                        'Completați datele obligatorii:',
                        '- Nume complet',
                        '- Date contact',
                        '- Grupă',
                        '- Tip cotizație',
                        'Opțional: date medicale, adresă etc.'
                    ],
                    'Gestionare Membri' => [
                        'Vizualizare listă membri',
                        'Filtrare după:',
                        '- Status (activ/inactiv)',
                        '- Grupă',
                        'Căutare după nume/email/telefon',
                        'Editare date membru',
                        'Activare/dezactivare membru',
                        'Ștergere membru (doar dacă nu are istoric)'
                    ],
                    'Export Date' => [
                        'Export listă membri în PDF',
                        'Rapoarte personalizate'
                    ]
                ]
            ],
            [
                'title' => '4. PREZENȚE',
                'content' => [
                    'Marcare Prezențe' => [
                        'Accesați secțiunea "Prezențe"',
                        'Selectați data și grupa',
                        'Bifați membrii prezenți',
                        'Salvați prezențele'
                    ],
                    'Vizualizare Prezențe' => [
                        'Filtrare după dată/perioadă',
                        'Filtrare după grupă',
                        'Vizualizare per membru'
                    ],
                    'Rapoarte Prezențe' => [
                        'Generare raport prezențe',
                        'Export în PDF',
                        'Statistici prezențe'
                    ]
                ]
            ],
            [
                'title' => '5. PLĂȚI ȘI COTIZAȚII',
                'content' => [
                    'Înregistrare Plăți' => [
                        'Selectați membrul',
                        'Alegeți tipul cotizației',
                        'Introduceți suma',
                        'Setați data plății',
                        'Adăugați note (opțional)',
                        'Salvați plata'
                    ],
                    'Gestionare Plăți' => [
                        'Vizualizare istoric plăți',
                        'Filtrare după perioadă',
                        'Filtrare după membru',
                        'Evidență restanțe'
                    ],
                    'Rapoarte Financiare' => [
                        'Raport lunar',
                        'Situație plăți per membru',
                        'Export rapoarte în PDF'
                    ]
                ]
            ],
            [
                'title' => '6. EVENIMENTE',
                'content' => [
                    'Creare Evenimente' => [
                        'Click pe "Adaugă Eveniment"',
                        'Completați:',
                        '- Nume eveniment',
                        '- Data',
                        '- Tip (competiție, examen etc.)',
                        '- Detalii'
                    ],
                    'Gestionare Participanți' => [
                        'Adăugare participanți',
                        'Înregistrare rezultate',
                        'Export liste participanți'
                    ]
                ]
            ],
            [
                'title' => '7. SFATURI ȘI RECOMANDĂRI',
                'content' => [
                    'Organizare Eficientă' => [
                        'Creați grupe clare și bine definite',
                        'Mențineți datele membrilor actualizate',
                        'Faceți backup periodic exportând datele'
                    ],
                    'Bune Practici' => [
                        'Marcați prezențele în ziua respectivă',
                        'Verificați periodic restanțele',
                        'Folosiți notițele pentru informații importante',
                        'Exportați rapoarte lunar pentru evidență'
                    ]
                ]
            ],
            [
                'title' => '8. SUPORT',
                'content' => [
                    'Contact' => [
                        'Email: contact@sportclubpro.ro',
                        'Website: www.sportclubpro.ro'
                    ],
                    'Dezvoltator' => [
                        'Click Studios Digital' => [
                            'text' => 'Click Studios Digital',
                            'url' => 'https://clickstudios-digital.com'
                        ]
                    ]
                ]
            ]
        ];
    }
}
