-- Seed MySQL di sviluppo completo e ri-eseguibile.
-- Pulisce le tabelle e inserisce almeno 5 record per entità, tranne admin_users
-- che contiene un solo amministratore.
-- Login sviluppo: admin@jamz.com / JamzAdmin2026!
-- Non usare queste credenziali in produzione.

SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE admin_users;
TRUNCATE TABLE evento_immagini;
TRUNCATE TABLE richieste_musicisti;
TRUNCATE TABLE documenti;
TRUNCATE TABLE associati;
TRUNCATE TABLE eventi;
TRUNCATE TABLE membri_consiglio;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO admin_users (email, roles, password) VALUES
('admin@jamz.com', '["ROLE_ADMIN"]', '$2y$12$YzCNQgxY2Gjcv9GgkrDeUuurEqRCN2nd0H4UktQYX/bC2dnZ.HWfm');

INSERT INTO membri_consiglio (nome, cognome, ruolo, bio, email, foto, ordine_visualizzazione) VALUES
('Alba', 'Rossi', 'Presidente', 'Coordina visione artistica, partnership e relazioni con il territorio. Segue i format speciali e la direzione culturale.', 'alba.rossi@jamz.local', 'assets/images/board-alba.svg', 1),
('Giulio', 'Berti', 'Vicepresidente e produzione', 'Presidia logistica, rapporti con venue e produzione tecnica degli eventi live.', 'giulio.berti@jamz.local', 'assets/images/board-giulio.svg', 2),
('Marta', 'Leoni', 'Tesoriere e fundraising', 'Gestisce budget, bandi e sostenibilità dei progetti associativi.', 'marta.leoni@jamz.local', 'assets/images/board-marta.svg', 3),
('Youssef', 'Amrani', 'Segreteria e community', 'Cura onboarding soci, comunicazione operativa e relazioni con volontari e musicisti.', 'youssef.amrani@jamz.local', 'assets/images/board-youssef.svg', 4),
('Claudia', 'Ferretti', 'Comunicazione e social media', 'Segue piano editoriale, coordinamento visuale e comunicazione delle iniziative online e offline.', 'claudia.ferretti@jamz.local', 'assets/images/board-alba.svg', 5);

INSERT INTO eventi (titolo, descrizione, report_evento, data_evento, created_at, luogo, immagine_copertina, link_partecipazione) VALUES
('Urban Night Session', 'Una notte di live set e improvvisazione urbana con tre progetti emergenti della scena indipendente locale.', 'La serata ha aperto la stagione autunnale con un formato molto asciutto ma intenso: tre set consecutivi, pubblico raccolto e una regia luci minimale che ha valorizzato lo spazio senza appesantirlo.

La risposta del pubblico e stata molto forte nella seconda parte della notte, quando il format ha lasciato spazio a una jam finale che ha coinvolto artisti e ospiti fuori programma. Dal punto di vista organizzativo l evento ha confermato la tenuta del format in venue non convenzionali.', '2025-11-14 21:00:00', '2026-01-12 10:00:00', 'Cortile Off, Trento', 'assets/images/event-urban-night.svg', NULL),
('Riverside Listening Lab', 'Ascolto guidato e talk con producer, visual artist e pubblico in formato intimo sul lungofiume.', 'Riverside Listening Lab e stato costruito come un incontro a meta tra talk curatoriale e sessione di ascolto condivisa. Il pubblico e rimasto in ascolto per tutta la prima parte, con interventi molto puntuali e una forte attenzione al processo creativo.

Nel report interno e emersa soprattutto la qualita del dialogo tra artisti e audience: il formato ridotto ha favorito domande migliori, una relazione piu diretta e una chiusura molto partecipata.', '2026-04-12 18:30:00', '2026-02-08 11:25:00', 'Spazio Riverside, Trento', 'assets/images/event-riverside-lab.svg', NULL),
('Open Stage Spring', 'Open stage dedicato a band e solisti con set brevi e confronto finale con il team curatoriale.', 'Open Stage Spring ha funzionato come piattaforma di scouting e primo contatto. Si sono alternati solisti, duo e una band completa, con tempi stretti ma una buona fluidita nei cambi palco.

Il momento piu utile e stato il confronto finale con i partecipanti: sono emerse richieste tecniche ricorrenti, aspettative sul booking e diversi spunti per rendere il format ancora piu chiaro nelle prossime call.', '2025-06-21 19:30:00', '2026-03-05 16:40:00', 'Ex Magazzino 52, Trento', 'assets/images/event-open-stage.svg', NULL),
('Sound Dialogues 02', 'Incontro tra elettronica, spoken word e arti visive con prenotazione online.', 'La seconda edizione di Sound Dialogues mette insieme live elettronico, spoken word e una componente visuale piu strutturata. La serata e progettata per una fruizione seduta, con un ritmo piu narrativo e tempi tecnici calibrati.

L obiettivo di questa edizione e consolidare un pubblico interessato ai formati ibridi e verificare la sostenibilita di un format replicabile in rassegna.', '2026-09-19 20:45:00', '2026-04-18 09:30:00', 'Auditorium Sanbapolis, Trento', 'assets/images/event-sound-dialogues.svg', 'https://example.com/sound-dialogues'),
('Winter Session Market', 'Una serata con live, micro market creativo e dj set di chiusura.', 'Winter Session Market e pensato come evento di attraversamento: si arriva per ascoltare, ma si resta per incontrare artigiani, artisti e comunita locale in un contesto informale.

Il report progettuale mette al centro la capacita del format di allungare il tempo di permanenza del pubblico e generare una relazione piu ampia tra musica e micro-economie creative.', '2026-12-05 19:00:00', '2026-05-03 14:10:00', 'Officina Jam, Rovereto', 'assets/images/event-winter-session.svg', 'https://example.com/winter-session'),
('Atelier Residency Showcase', 'Restituzione pubblica della residenza artistica con presentazione dei progetti sviluppati nel laboratorio.', 'Atelier Residency Showcase nasce come momento finale di restituzione dopo giorni di lavoro in residenza. Il focus non e solo il risultato, ma il percorso: prove aperte, confronto tra artisti e condivisione dei materiali sviluppati.

La pagina dettaglio serve qui anche a raccontare il contesto della residenza, le collaborazioni attivate e le intenzioni di sviluppo futuro dei progetti emersi.', '2027-02-07 18:00:00', '2026-06-12 18:00:00', 'Atelier San Martino, Trento', 'assets/images/event-atelier-showcase.svg', 'https://example.com/atelier-showcase');

INSERT INTO evento_immagini (evento_id, url_immagine, alt_text, ordine_visualizzazione) VALUES
(1, 'assets/images/gallery-stage.svg', 'Live set e pubblico raccolto', 1),
(1, 'assets/images/gallery-crowd.svg', 'Dettaglio pubblico e luci di sala', 2),
(2, 'assets/images/gallery-room.svg', 'Laboratorio di ascolto riverside', 1),
(2, 'assets/images/gallery-stage.svg', 'Panel e discussione con artisti', 2),
(3, 'assets/images/gallery-crowd.svg', 'Open stage con performer e pubblico', 1),
(3, 'assets/images/gallery-room.svg', 'Backstage e preparazione palco', 2),
(4, 'assets/images/gallery-stage.svg', 'Visual e palco durante Sound Dialogues', 1),
(4, 'assets/images/gallery-crowd.svg', 'Pubblico durante il talk serale', 2),
(5, 'assets/images/gallery-room.svg', 'Area market e live set', 1),
(6, 'assets/images/gallery-stage.svg', 'Restituzione finale della residenza', 1);

INSERT INTO associati (nome, cognome, numero_tessera, data_iscrizione, citta, strumento, bio_breve, email, visibile_albo) VALUES
('Elena', 'Fabbri', 'JAMZ-001', '2024-02-12', 'Trento', 'Voce / songwriting', 'Lavora tra voce, scrittura e set acustici in piccolo formato.', 'elena.fabbri@example.com', 1),
('Tommaso', 'Rinaldi', 'JAMZ-002', '2024-03-08', 'Rovereto', 'Batteria', 'Segue i progetti live dell’associazione come musicista e volontario tecnico.', 'tommaso.rinaldi@example.com', 1),
('Sara', 'Benetti', 'JAMZ-003', '2024-05-17', 'Pergine', 'Visual design', 'Collabora alla direzione visiva di eventi e contenuti digitali.', 'sara.benetti@example.com', 1),
('Luca', 'Neri', 'JAMZ-004', '2025-01-11', 'Trento', 'Basso elettrico', 'Suona in contesti funk e neo-soul, con attenzione alla didattica.', 'luca.neri@example.com', 1),
('Chiara', 'Pasin', 'JAMZ-005', '2025-04-02', 'Levico', 'Booking / hospitality', 'Supporta l’accoglienza artisti e la relazione con i partner di rete.', 'chiara.pasin@example.com', 1),
('Nicolo', 'Marin', 'JAMZ-006', '2025-09-21', 'Ala', 'Synth / produzione', 'Sperimenta con elettronica modulare e performance site-specific.', 'nicolo.marin@example.com', 0);

INSERT INTO richieste_musicisti (nome, cognome, email, telefono, descrizione_progetto, genere_musicale, link_materiale, disponibilita, data_richiesta, stato) VALUES
('Andrea', 'Bassi', 'andrea.bassi@example.com', '+39 333 1001001', 'Trio funk-jazz con repertorio originale, set da 45 o 75 minuti e scheda tecnica gia definita. Cerchiamo date indoor tra autunno e inverno.', 'Funk / Jazz', 'https://example.com/andrea-bassi-live', 'Weekend e venerdi sera', '2026-01-18 10:15:00', 'in_attesa'),
('Micol', 'Parisi', 'micol.parisi@example.com', '+39 333 1001002', 'Progetto cantautorale elettronico in solo con voce, synth e visual minimali. Adatto a listening session e opening act.', 'Elettronica / Songwriting', 'https://example.com/micol-parisi', 'Giovedi e sabato', '2026-02-03 14:40:00', 'accettata'),
('Davide', 'Greco', 'davide.greco@example.com', '+39 333 1001003', 'Quartetto strumentale che lavora tra post-rock e improvvisazione. Necessita di palco medio e line check anticipato.', 'Post-rock / Impro', 'https://example.com/davide-greco-band', 'Date in primavera', '2026-02-19 09:20:00', 'in_attesa'),
('Noemi', 'Villa', 'noemi.villa@example.com', '+39 333 1001004', 'DJ set ibrido con selezione bass, garage e house, pensato per aftershow e chiusure di serata.', 'DJ set / Bass music', 'https://example.com/noemi-villa-dj', 'Venerdi notte', '2026-03-02 18:05:00', 'rifiutata'),
('Karim', 'Lahmar', 'karim.lahmar@example.com', '+39 333 1001005', 'Live set electro-world con percussioni e macchine. Disponibile anche per workshop introduttivo con giovani musicisti.', 'Electro-world', 'https://example.com/karim-lahmar', 'Weekend e laboratori pomeridiani', '2026-03-11 11:55:00', 'in_attesa');

INSERT INTO documenti (tipo, titolo, nome_file, path, data_caricamento) VALUES
('statuto', 'Statuto dell’associazione Jamz', 'statuto-jamz.pdf', 'assets/documents/statuto-jamz.pdf', '2026-01-20'),
('atto_costitutivo', 'Atto costitutivo Jamz', 'atto-costitutivo-jamz.pdf', 'assets/documents/atto-costitutivo-jamz.pdf', '2026-01-20'),
('altro', 'Regolamento interno volontari', 'regolamento-volontari-jamz.pdf', 'assets/documents/statuto-jamz.pdf', '2026-02-10'),
('altro', 'Codice etico eventi e ospitalita', 'codice-etico-jamz.pdf', 'assets/documents/atto-costitutivo-jamz.pdf', '2026-02-18'),
('altro', 'Informativa soci e trattamento dati', 'informativa-soci-jamz.pdf', 'assets/documents/statuto-jamz.pdf', '2026-03-01');

-- Verifica finale: i conteggi attesi sono 1 admin e almeno 5 record per le altre entità.
SELECT 'admin_users' AS entita, COUNT(*) AS numero_record FROM admin_users
UNION ALL SELECT 'membri_consiglio', COUNT(*) FROM membri_consiglio
UNION ALL SELECT 'eventi', COUNT(*) FROM eventi
UNION ALL SELECT 'evento_immagini', COUNT(*) FROM evento_immagini
UNION ALL SELECT 'associati', COUNT(*) FROM associati
UNION ALL SELECT 'richieste_musicisti', COUNT(*) FROM richieste_musicisti
UNION ALL SELECT 'documenti', COUNT(*) FROM documenti;
