##Przygotowanie środowiska
1. Pobrać kod za pomocą komenty `git clone` z adresu https://github.com/kamilus67/users.git<br>
2. W katalogu projektu wykonać polecenie `composer install`<br>
3. Przejść do katalogu `frontend` i wykonać polecenie `npm install`<br>
4. W katalogu głównym utworzyć plik `.env` i wprowadzić do niego dane konfiguracyjne. Przykład:<br>
   `APP_ENV=dev`<br>
   `APP_SECRET=d252355a283bddb58f0f461cf9b94604`<br>
   `DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`<br>
   `PHPMAILER_HOST=email.host.pl`<br>
   `PHPMAILER_USERNAME=sample@gmail.com`<br>
   `PHPMAILER_PASSWORD=samplepassword`<br>
   `PHPMAILER_SMTPSECURE=tls`<br>
   `PHPMAILER_PORT=587`<br>
   `PHPMAILER_FROM_EMAIL=sample@gmail.com`<br>
   `PHPMAILER_FROM_NAME="Sample name"`<br>
5. W katalogu głównym wykonać polecenie `php bin/console doctrine:database:create`, następnie `php bin/console doctrine:migrations:migrate`
<p>Aplikacja po wykonaniu opisanych powyżej czynności powinna być gotowa do użycia w środowisku developerskim.</p>
<p>Aby uruchomić aplikację należy wykonać następujące czynności:</p>

1. W katalogu głównym wykonać polecenie `php bin/console server:run`<br>
2. W katalogu `frontend` wykonać polecenie `npm start`

Aplikacja uruchomi się pod adresem `http://localhost:3000`<br>
Domyślny adres serwera API to `http://127.0.0.1:8000`<br>
Adres serwera API znajduje się w ścieżce `/frontend/src/helpers/routes.js:1`