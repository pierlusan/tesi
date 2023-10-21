# Guida all'installazione

***IMPORTANTE:** Prima di iniziare, assicurati di avere i seguenti requisiti installati sul tuo computer:*
1. **Git**: Se non hai Git installato, puoi scaricarlo da [questo link](https://git-scm.com/downloads).
2. **Node.js** & **npm**: Node.js è un runtime JavaScript e npm è il gestore di pacchetti di Node.js. Puoi scaricarli da [questo link](https://nodejs.org/). Assicurati di avere npm incluso nell'installazione di Node.js.
3. **Composer**: Composer è un gestore di dipendenze per PHP. Puoi scaricarlo da [questo link](https://getcomposer.org/).
4. **MySQL**: Il nostro progetto utilizza MySQL come sistema di gestione del database. Assicurati di avere MySQL installato e configurato sul tuo sistema. Puoi scaricare MySQL da [questo link](https://dev.mysql.com/downloads/).



### Setup dell'applicazione:

1. **Clona il repository**: Apri il tuo terminale o prompt dei comandi e esegui il seguente comando per clonare il repository da GitHub:
   ```bash
   git clone https://github.com/cianf4/test.git
   ```

2. **Entra nella directory del progetto**: Vai nella directory del progetto appena clonato con il comando:
   ```bash
   cd test
   ```

3. **Installazione delle dipendenze PHP**: Esegui il seguente comando per installare le dipendenze PHP del progetto utilizzando Composer:
   ```bash
   composer install
   ```

4. **Installazione delle dipendenze JavaScript**: Esegui il seguente comando per installare le dipendenze JavaScript del progetto utilizzando npm:
   ```bash
   npm install
   ```

5. **Crea il file di ambiente**: Crea un file di ambiente `.env` per configurare le variabili d'ambiente del progetto. Copia il file `.env.example` tramite il seguente comando:
   ```bash
   cp .env.example .env
   ```

6. **Configura il file di ambiente**: Modifica il file di ambiente `.env` secondo le tue esigenze. In particolare le linee di codice associate all'accesso al database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=test
   DB_USERNAME=root
   DB_PASSWORD=
   ```

7. **Genera la chiave dell'app**: Esegui il seguente comando per generare una chiave segreta per l'applicazione:
   ```bash
   php artisan key:generate
   ```
   
8. **Esegui le Migrazioni del Database**: Per creare le tabelle del database, esegui:
   ```bash
   php artisan migrate
   ```
<small>

9. ***Setup minori:** nel file php/php.ini dell'interprete (es: XAMMP), Sono state modificate le seguenti righe di codice:*
   ```php
   upload_max_filesize=128M
   max_post_size=128M
   max_execution_time = 300
   memory_limit = 1024M
   ```

</small>


### Run dell'applicazione:

1. **Compila le risorse front-end**: Esegui il seguente comando per avviare il processo di compilazione delle risorse front-end del progetto:
   ```bash
   npm run dev
   ```

2. **Avvia il Server**: Ora puoi avviare il server locale:
   ```bash
   php artisan serve
   ```
3. **Accedi al progetto**: Una volta eseguiti tutti i passi, sarà possibile accedere al progetto tramite browser dall'indirizzo `http://127.0.0.1:8000`.
