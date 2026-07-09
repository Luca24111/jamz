<?php

declare(strict_types=1);

namespace App\Service;

final class PageContentService
{
    /**
     * @return array<string, mixed>
     */
    public function aboutPage(): array
    {
        return [
            'hero' => [
                'eyebrow' => 'Associazione culturale e musicale',
                'title' => 'Uno [[spazio]] per progettare [[musica]], comunità e [[occasioni]] di incontro.',
                'intro' => 'Jamz nasce per tenere insieme produzione artistica, cura del territorio e occasioni di crescita condivisa per musicisti, pubblico e realtà culturali locali.',
            ],
            'sections' => [
                [
                    'title' => 'Chi siamo',
                    'body' => 'Siamo un collettivo organizzativo che unisce musicisti, curatori e volontari. Progettiamo rassegne, jam session, laboratori e momenti di formazione con un linguaggio contemporaneo ma accessibile.',
                ],
                [
                    'title' => 'Come lavoriamo',
                    'body' => 'Ogni attività nasce da un confronto con artisti, spazi e associazioni partner. Privilegiamo formati leggeri, produzione sostenibile e una relazione diretta con il pubblico.',
                ],
                [
                    'title' => 'Perché Jamz',
                    'body' => 'L’obiettivo è costruire una casa comune per chi suona, ascolta, programma e sostiene la musica dal vivo, con particolare attenzione alla scena emergente e alle reti locali.',
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function objectivesPage(): array
    {
        return [
            'hero' => [
                'eyebrow' => 'Missione e visione',
                'title' => 'Una programmazione [[culturale]] che mette al centro [[persone]], processi e qualità [[artistica]].',
                'intro' => 'La filosofia dell’associazione integra inclusione, sperimentazione e radicamento territoriale.',
            ],
            'pillars' => [
                [
                    'title' => 'Accesso',
                    'body' => 'Creiamo occasioni di ascolto e partecipazione con prezzi sostenibili, linguaggio chiaro e format capaci di accogliere pubblici diversi.',
                ],
                [
                    'title' => 'Crescita artistica',
                    'body' => 'Supportiamo musicisti emergenti con spazi di esibizione, networking e confronto con professionisti della programmazione culturale.',
                ],
                [
                    'title' => 'Relazione con il territorio',
                    'body' => 'Costruiamo reti con scuole, spazi indipendenti, enti culturali e comunità locali per generare valore oltre il singolo evento.',
                ],
                [
                    'title' => 'Produzione responsabile',
                    'body' => 'Organizziamo eventi con attenzione a logistica, tempi, cura dei volontari e sostenibilità economica dei progetti.',
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function homeContent(): array
    {
        return [
            'hero' => [
                'eyebrow' => 'Jamz / cultura musicale',
                'title' => '[[Programmiamo]] eventi, [[costruiamo]] relazioni, apriamo spazi a chi vuole [[suonare con noi]].',
                'intro' => 'Una piattaforma associativa per eventi live, progettazione culturale e networking tra musicisti, pubblico e territorio.',
                'primary_cta' => ['label' => 'Suona con noi', 'path' => '/suona-con-noi'],
                'secondary_cta' => ['label' => 'Scopri i prossimi eventi', 'path' => '/eventi-futuri'],
            ],
            'cards' => [
                [
                    'title' => 'Consiglio direttivo',
                    'body' => 'Persone, ruoli e contatti del gruppo che guida l’associazione.',
                    'path' => '/consiglio-direttivo',
                ],
                [
                    'title' => 'Archivio eventi',
                    'body' => 'Racconti, immagini e memoria delle attività già realizzate.',
                    'path' => '/eventi-passati',
                ],
                [
                    'title' => 'Obiettivi e filosofia',
                    'body' => 'Missione culturale, valori e metodo di lavoro del progetto.',
                    'path' => '/obiettivi-filosofia',
                ],
                [
                    'title' => 'Albo associati',
                    'body' => 'Una panoramica dei soci che hanno scelto di comparire pubblicamente.',
                    'path' => '/albo-associati',
                ],
            ],
        ];
    }

    /**
     * @return list<array{label: string, path: string}>
     */
    public function navigation(): array
    {
        return [
            ['label' => 'Home', 'path' => '/'],
            ['label' => 'Chi siamo', 'path' => '/chi-siamo'],
            ['label' => 'Consiglio', 'path' => '/consiglio-direttivo'],
            ['label' => 'Eventi passati', 'path' => '/eventi-passati'],
            ['label' => 'Eventi futuri', 'path' => '/eventi-futuri'],
            ['label' => 'Obiettivi', 'path' => '/obiettivi-filosofia'],
            ['label' => 'Statuto', 'path' => '/statuto'],
            ['label' => 'Albo associati', 'path' => '/albo-associati'],
            ['label' => 'Suona con noi', 'path' => '/suona-con-noi'],
        ];
    }
}
