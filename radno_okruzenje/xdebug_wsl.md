Instalacija i konfiguracija Xdebug-a na WSL2 Ubuntu i povezivanje s VSCode

Korak 1: Instalirajte Xdebug na WSL2 Ubuntu

    Ažurirajte popis paketa:

sudo apt update

    Instalirajte PHP i potrebne alate za razvoj:

sudo apt install php php-dev php-pear

    Instalirajte Xdebug:

sudo pecl install xdebug

Korak 2: Konfigurirajte PHP za korištenje Xdebug-a

    Pronađite put do instalacije Xdebug-a:

find /usr/lib/php -name 'xdebug.so'

Zabilježite put, koji je obično nešto poput /usr/lib/php/20210902/xdebug.so.

    Konfigurirajte PHP za korištenje Xdebug-a: Otvorite vaš php.ini datoteku. Možda imate odvojene php.ini datoteke za CLI i web poslužitelj (npr. /etc/php/7.x/cli/php.ini i /etc/php/7.x/apache2/php.ini). Dodajte sljedeće retke na kraj:

[Xdebug]
zend_extension=/usr/lib/php/20210902/xdebug.so
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.client_host=127.0.0.1
xdebug.client_port=9003
xdebug.log=/tmp/xdebug.log

Korak 3: Provjerite instalaciju PECL-a

Da biste provjerili je li pecl ispravno instaliran, možete pokrenuti:

pecl version

Ovo bi trebalo vratiti verziju pecl instaliranu na vašem sustavu.
Korak 4: Konfigurirajte VSCode

    Instalirajte PHP Debug ekstenziju: Otvorite VSCode, idite na pregled ekstenzija klikom na ikonu kvadrata u bočnoj traci ili pritiskom Ctrl+Shift+X, i potražite "PHP Debug". Instalirajte ekstenziju autora Felix Becker.

    Kreirajte konfiguraciju za pokretanje: U VSCode, idite na pregled Debug klikom na ikonu za pokretanje u bočnoj traci ili pritiskom Ctrl+Shift+D. Kliknite na ikonu zupčanika za otvaranje launch.json datoteke. Dodajte sljedeću konfiguraciju:

{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003
        }
    ]
}

Korak 5: Ponovno pokrenite vaš web poslužitelj ili PHP

Ovisno o tome koristite li PHP CLI ili web poslužitelj kao što je Apache ili Nginx, ponovno pokrenite odgovarajuću uslugu. Za Apache, možete koristiti:

sudo service apache2 restart

Korak 6: Testirajte Xdebug

    Postavite breakpoint: Otvorite PHP datoteku u VSCode, kliknite u lijevi rub pored broja retka kako biste postavili breakpoint.

    Pokrenite debugger: Idite na pregled Debug u VSCode i kliknite na zeleni gumb za pokretanje pored "Listen for Xdebug".

    Pokrenite kod: Pokrenite vaš PHP skriptu ili učitajte web stranicu koju poslužuje vaš web poslužitelj. Xdebug bi trebao zaustaviti izvršenje na vašem breakpointu, omogućujući vam pregledavanje varijabli, korak po korak praćenje koda, itd.
