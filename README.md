# Gymbro

- [Introduzione](#introduzione)
- [Idea](#idea)
- [Screenshots](#screenshots)
- [Requisiti](#requisiti)
- [Installazione requisiti su macchina Ubuntu 24.04](#installazione-requisiti-su-macchina-ubuntu-2404)
- [Installazione Gymbro](#installazione-gymbro)
- [Creare utente admin](#creare-utente-admin)


## Introduzione

Gymbro è un gestionale pensato per le palestre, con l'obiettivo di semplificare il lavoro quotidiano del personale e migliorare l’esperienza degli utenti che si allenano.

Nelle palestre tradizionali la gestione dei clienti è spesso manuale: un nuovo iscritto deve rivolgersi allo staff per ricevere una scheda di allenamento, generalmente fornita su carta, e se desidera monitorare i propri progressi deve farlo autonomamente.

**Gymbro vuole semplificare l’interazione tra allenatore e cliente.** Offre al personale e agli allenatori della palestra un gestionale completo, che consente di registrare nuovi clienti, creare loro schede di allenamento personalizzate e monitorarne i progressi. I clienti avranno accesso a una interfaccia semplice e accessibile da mobile, tramite la quale si può consultare la propria scheda durante l’allenamento, registrare i dati delle sessioni (ripetizioni, carichi, note) e visualizzare l’evoluzione dei propri risultati nel tempo.

Gymbro migliora l’esperienza sia per i clienti che per gli allenatori: i primi hanno sempre a disposizione uno strumento immediato che li accompagna durante i propri allenamenti; i secondi possono monitorare facilmente i progressi dei propri clienti, valutare l’efficacia dei programmi proposti e apportare modifiche alle schede, adattandole agli obiettivi raggiunti.

## Idea

Gymbro è stato sviluppato come progetto per il corso di Tecnologie Web del corso di laurea in Informatica presso l’Università di Ferrara; l'obiettivo era di ideare una propria startup da vendere come prodotto commerciale. L’applicazione adotta un modello SaaS (Software as a Service): viene venduta in abbonamento alle palestre, che possono così semplificare la gestione dei propri clienti e offrire loro un’esperienza moderna e coinvolgente.

A supporto di quanto detto la piattaforma include un’interfaccia di amministrazione globale, destinata a chi vende il servizio. Un amministratore ha accesso completo a tutte le palestre e clienti registrati, può aggiungerne di nuove e aggiornare il database degli esercizi disponibili, che potranno poi essere proposti nelle schede.

## Screenshots

### Amministrazione - Visualizza utenti

![Screenshot della sezione di amministrazione nella pagina per visualizzare gli utenti registrati](/docs/images/admin_users.png?raw=true)

### Amministrazione - Modifica scheda di allenamento

![Screenshot della sezione di amministrazione nella pagina per modificare la scheda di allenamento di un utente](/docs/images/admin_edit_workout_plan.png?raw=true)

### Utente - Allenamento

![Screenshot della schermata per tracciare gli allenamenti mostrata agli utenti](/docs/images/users_training.png?raw=true)


## Requisiti
- Laravel 11
- PHP 8.3
- Node 23 per compilare TailwindCSS
- Server MySQL o MariaDB

> Per quanto Laravel supporti SQLite abbiamo riscontrato problemi quando si effettuano query complesse, è quindi necessario un database SQL.

## Installazione requisiti su macchina Ubuntu 24.04
### PHP
Al momento della scrittura la versione di PHP presente nelle repo di Ubuntu ufficiali è la 8.2, ma Laravel 11 richiede PHP >= 8.3.

```bash
# Aggiungi repo
sudo add-apt-repository ppa:ondrej/php

# Installa PHP e i moduli aggiuntivi richiesti da Composer e Laravel
sudo apt install php8.3 php8.3-curl php8.3-mbstring php8.3-mysql php8.3-sqlite3 php8.3-xml php8.3-zip
```

### Composer
Per evitare di allegare una guida che può diventare obsoleta vi rimandiamo alla [documentazione ufficiale](https://getcomposer.org/download) di Composer.

### Node
Simile a quanto detto con PHP la versione distribuita nella repository ufficiale è obsoleta, usiamo quindi l'installer di [NodeSource](https://github.com/nodesource/distributions).

```bash
# Configura la repo di NodeSource
curl -fsSL https://deb.nodesource.com/setup_23.x | sudo -E bash -

# Installa Node
sudo apt install nodejs
```

### MariaDB
```bash
# Installa MariaDB
sudo apt install mariadb-server

# Configura il server
sudo mysql_secure_installation
```

La maggior parte dei parametri possono essere lasciati a default, ma è importante configurare una password per l'utente root; questa andrà poi inserita nel file .env al passaggio successivo.

> Non è ideale usare l'utente root in un ambiente production, ma diamo per scontato di essere in fase di testing.

## Installazione Gymbro
```bash
# Clona repo
git clone https://github.com/leonardogovoni/gymbro.git
cd gymbro
    
# Installa dipendenze
composer update
npm install

# Copia il file di configurazione (modifica i parametri di collegamento con il database)
cp .env.example .env

# Genera chiave
php artisan key:generate

# Costruisci il database
php artisan migrate

# Popola il database con esercizi
php artisan db:seed ExercisesSeeder

# Compila CSS
npm run build

# Avvia l'applicazione
php artisan serve
```

## Creare utente admin
Essendo software venduto alle palestre la registrazione diretta da parte degli utenti finali è disattivata. L'utente deve essere registrato da parte della palestra che ha acquistato Gymbro, il software invierà automaticamente le credenziali di accesso all'utente per mail.

A causa di ciò al primo avvio non sarà presente alcun utente ed è necessario crearne uno tramite la console di Laravel. Di seguito sono allegati i comandi per fare ciò; modificate i parametri dell'utente a vostro piacimento.

```php
# Per entrare nella console di Laravel
php artisan tinker

# Questo inserito nella console
$admin = new App\Models\User();
$admin->first_name = "Nome";
$admin->last_name = "Cognome";
$admin->email = "admin@admin.com";
$admin->password = Hash::make('password');
$admin->gender = "M";
$admin->date_of_birth = "2000-12-30";
$admin->is_admin = true;
$admin->save();
```

Dopo aver salvato si potrà accedere alla applicazione; l'utente creato essendo amministratore può accedere alla interfaccia dedicata per poter creare gli accessi delle palestre che aderiscono al servizio.