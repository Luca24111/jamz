# Jamz

Portale per associazione culturale e musicale basato su Symfony 6.4, Twig, Doctrine ORM e MySQL.

## Scelta architetturale

Ho riallineato il progetto a Symfony perché volevi gestire lo schema dal terminale con `php bin/console doctrine:schema:update --force`. La struttura applicativa resta separata per responsabilità:

- `src/Controller` per gli endpoint HTTP
- `src/Service` per logica applicativa e contenuti editoriali
- `src/Repository` per query e accesso al dato
- `src/Entity` per il mapping Doctrine verso MySQL
- `templates` per le view Twig

I contenuti editoriali stabili sono serviti da `PageContentService`, mentre eventi, consiglio, associati, documenti e richieste musicisti sono mappati come entità Doctrine.

## Requisiti

- PHP 8.1+
- estensioni `pdo_mysql`, `mbstring`, `json`
- Composer 2
- MySQL 8+

## Installazione

1. Installa le dipendenze:

```bash
composer install
```

2. Crea il file ambiente:

```bash
cp .env.example .env
cp .env.dev.example .env.dev
```

3. Aggiorna `DATABASE_URL` in `.env.dev`. I file ambiente reali sono ignorati da Git; i file `*.example` sono gli unici template versionati.

Su Ubuntu evita `root` come utente applicativo: spesso `root@localhost` usa `auth_socket` e non accetta login password da PDO o `mysql -p`.

4. Crea il database:

```bash
sudo mysql <<'SQL'
CREATE DATABASE IF NOT EXISTS jamz CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'jamz'@'localhost' IDENTIFIED BY 'jamzpass';
CREATE USER IF NOT EXISTS 'jamz'@'127.0.0.1' IDENTIFIED BY 'jamzpass';
GRANT ALL PRIVILEGES ON jamz.* TO 'jamz'@'localhost';
GRANT ALL PRIVILEGES ON jamz.* TO 'jamz'@'127.0.0.1';
FLUSH PRIVILEGES;
SQL
```

5. Genera o aggiorna lo schema dal mapping Doctrine:

```bash
php bin/console doctrine:schema:update --force --complete
```

6. Popola dati demo:

```bash
mysql -h 127.0.0.1 -u jamz -p jamz < database/seeds/001_seed_data.sql
```

7. Avvia il server locale:

```bash
symfony server:start
```

Oppure:

```bash
php -S localhost:8000 -t public
```

## Comandi utili

Validare mapping e schema:

```bash
php bin/console doctrine:schema:validate
```

Aggiornare lo schema dopo modifiche alle entity:

```bash
php bin/console doctrine:schema:update --force --complete
```

## Messa online

La guida completa e la configurazione Apache di esempio sono in [DEPLOYMENT.md](DEPLOYMENT.md). In sintesi:

```bash
cp .env.prod.example .env.prod
composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
```

Compila `.env.prod` solo sul server, dopo aver creato il database, e imposta la document root su `public/`.

## Dati gestiti da database

- `membri_consiglio`
- `eventi`
- `evento_immagini`
- `associati`
- `richieste_musicisti`
- `documenti`

## Note implementative

- I 500 su molte pagine erano causati dall’architettura custom precedente e dall’assenza del runtime Symfony/Doctrine richiesto.
- Le entity Doctrine espongono getter compatibili con Twig, così le view non vanno più in errore durante il rendering.
- Il form `Suona con noi` valida lato server, persiste tramite Doctrine e scrive la notifica su `var/log/mail.log` quando `MAIL_TRANSPORT=log`.
- Il form pubblico è protetto da token CSRF; in produzione le sessioni usano cookie `Secure`, `HttpOnly` e `SameSite=Lax`.
- Il CSS condiviso resta in `public/css/base/app.css`; ogni pagina ha il proprio CSS/JS dedicato.

## Punti da confermare

- L’albo associati è pubblico solo per i record con `visibile_albo = 1`.
- I PDF in `public/assets/documents` sono placeholder tecnici.
- Le immagini demo sono segnaposto locali e possono essere sostituite da asset reali senza toccare le view.
