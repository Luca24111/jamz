# Messa online

Il progetto è pronto per un server con PHP 8.1+, Composer 2, MySQL 8 e document root impostata sulla cartella `public/`. Il file `deploy/apache-vhost.conf.example` contiene una configurazione Apache di partenza; su hosting condiviso le regole `.htaccess` inoltrano comunque il traffico a `public/`.

## 1. Variabili online

Sul server copia il template senza commetterlo:

```bash
cp .env.example .env
cp .env.prod.example .env.prod
```

Imposta nel pannello hosting o nel virtual host:

```text
APP_ENV=prod
APP_DEBUG=0
```

Poi completa `.env.prod` con un segreto generato e con le credenziali del database:

```bash
openssl rand -hex 32
```

I file ambiente reali sono esclusi da Git. Non caricare mai `.env.prod` in un repository o in un ticket.

## 2. Installazione

Esegui dalla root del progetto:

```bash
composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
APP_ENV=prod APP_DEBUG=0 php bin/console assets:install public
```

Assicurati che PHP possa scrivere in:

```text
var/cache/
var/log/
var/sessions/
public/assets/documents/
public/assets/images/board-members/
public/assets/images/events/covers/
public/assets/images/events/gallery/
```

Le cartelle degli upload devono essere persistenti tra un deploy e l'altro e incluse nei backup insieme al database.

## 3. Database

Dopo aver creato il database e compilato `DATABASE_URL`, inizializza lo schema:

```bash
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:schema:update --force --complete
```

Per una prima installazione con dati dimostrativi, importa facoltativamente `database/seeds/001_seed_data.sql`. Non importarlo su un database già popolato.

## 4. Controlli finali

```bash
APP_ENV=prod APP_DEBUG=0 php bin/console about
APP_ENV=prod APP_DEBUG=0 php bin/console doctrine:schema:validate
```

Configura HTTPS prima di aprire il sito: in produzione i cookie di sessione sono inviati solo su connessioni sicure. Verifica infine home, pagine eventi, invio del form e accesso `/admin/login`.
