-- Schema MySQL iniziale per il portale associativo Jamz.

CREATE TABLE IF NOT EXISTS membri_consiglio (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    ruolo VARCHAR(150) NOT NULL,
    bio TEXT NOT NULL,
    email VARCHAR(190) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    ordine_visualizzazione INT UNSIGNED NOT NULL DEFAULT 0,
    INDEX idx_membri_consiglio_ordine (ordine_visualizzazione, cognome, nome)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS eventi (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titolo VARCHAR(180) NOT NULL,
    descrizione TEXT NOT NULL,
    report_evento TEXT NULL,
    data_evento DATETIME NOT NULL,
    created_at DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    luogo VARCHAR(180) NOT NULL,
    immagine_copertina VARCHAR(255) NOT NULL,
    link_partecipazione VARCHAR(255) NULL,
    INDEX idx_eventi_data_evento (data_evento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS evento_immagini (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    evento_id INT UNSIGNED NOT NULL,
    url_immagine VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NULL,
    ordine_visualizzazione INT UNSIGNED NOT NULL DEFAULT 0,
    INDEX idx_evento_immagini_ordine (evento_id, ordine_visualizzazione),
    CONSTRAINT fk_evento_immagini_evento
        FOREIGN KEY (evento_id) REFERENCES eventi (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS associati (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    numero_tessera VARCHAR(50) NOT NULL UNIQUE,
    data_iscrizione DATE NOT NULL,
    citta VARCHAR(120) NOT NULL,
    strumento VARCHAR(120) NOT NULL,
    bio_breve TEXT NOT NULL,
    email VARCHAR(190) NULL,
    visibile_albo TINYINT(1) NOT NULL DEFAULT 1,
    INDEX idx_associati_albo_ordine (visibile_albo, cognome, nome)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS richieste_musicisti (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL,
    telefono VARCHAR(50) NOT NULL,
    descrizione_progetto TEXT NOT NULL,
    genere_musicale VARCHAR(120) NOT NULL,
    link_materiale VARCHAR(255) NULL,
    disponibilita VARCHAR(190) NOT NULL,
    data_richiesta DATETIME NOT NULL,
    stato ENUM('in_attesa', 'accettata', 'rifiutata') NOT NULL DEFAULT 'in_attesa',
    INDEX idx_richieste_musicisti_stato (stato)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS documenti (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('statuto', 'atto_costitutivo', 'altro') NOT NULL,
    titolo VARCHAR(190) NOT NULL,
    nome_file VARCHAR(190) NOT NULL,
    path VARCHAR(255) NOT NULL,
    data_caricamento DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    email VARCHAR(190) NOT NULL UNIQUE,
    roles JSON NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
