#### Spajanje xampp i vscode

- downloadajte najnoviji XAMPP i instalirajte ga (ako već ne postoji na sustavu)

- na localdisk C: pronađite xampp, i u njemu php direktorij te iskopirajte adresu iz putanje (desni klik na php i copy address)

- adresu (koja bi trebala ovako izgledati - C:\xampp\php) spremite u system environment path varijablu vaših Windowsa (upute kako doći do nje na linku)

 ```
 https://www.eukhost.com/kb/how-to-add-to-the-path-on-windows-10-and-windows-11/
 ```

 - nakon toga otvorite vaš VSCode, kliknite na Open Folder i dođite putanjom C:\xampp\htdocs do htdocs foldera u kojem kreirate direktorij za vaš projekt (nakon toga možete stvoriti .php stranicu i krenuti sa kodiranjem)



#### Instalacija wsl i ubuntu na virtualnim Windowsima

- upute za instalaciju wsl i ubuntu iz command prompta (windows+R, pa upišite cmd, te potom ctrl+shift+enter da bi ga otvorili sa administratorskim ovlastima)

 ```
https://learn.microsoft.com/en-us/windows/wsl/install
 ```

- nakon toga trebate spojiti wsl sa VS Code prema sljedećim uputama (koristite "from VS Code" dio)

 ```
https://code.visualstudio.com/docs/remote/wsl
 ```

- sljedeće pristupite Ubuntu putem terminala na VS Code, kopirajte .setup.sh sa gita (imate link dolje) i pohranite u setup.sh na Ubuntu (sa sudo nano)
- zatim mu dajte 777 ovlasti (sudo chmod 777), te ga pokrenite kako bi instalirali LAMP stack (php, mysql, apache, composer)

 ```
https://github.com/adobrini-algebra/radno_okruzenje/blob/master/setup.sh

sudo nano setup.sh
sudo chmod 777 setup.sh
setup.sh
 ```


#### Instaliranje Laravel projekta pomoću Composera

- s obzirom da već imamo instalirane php i composer, Laravel možemo instalirati ovom naredbom:

 ```
composer global require laravel/installer
 ```

- nakon toga kreiramo novu Laravel aplikaciju sa naredbom:

 ```
laravel new ime_aplikacije
 ```

- gdje ćete moći odabrati niz opcija, a po instalaciji trebate izmijeniti .env file, itd., detaljnije upute na linku (Laravel dokumentacija):

 ```
 https://laravel.com/docs/11.x/installation#installing-php
 ```


#### Laravel middleware

TODO


#### Kreiranje kontrolera i middlewarea pomoću Bearer tokena

TODO


#### API JSON response sa status kodom

TODO


#### Spajanje na bazu pomoću Mysqli funkcije

TODO


#### Spajanje na bazu pomoću PDO klase

TODO


#### Continuous integration

- CI uvodi stalnu automatizaciju i kontinuirani nadzor tokom čitavog životnog ciklusa aplikacije, od faza integracije i testiranja do isporuke i primjene
- obavezni koraci koje bi trebalo dodati u CI (Continuous Integration) pipeline:
    - izvrtiti testove i vidjeti da li prolaze
    - statički analizirati kod te validirati da nema nikakvih pogrešaka
    - napraviti cache konfiguracijskih datoteka projekta te provjeriti da nema pogrešaka


#### Programske petlje (foreach, for, while)

- programske petlje su strukture koje omogućavaju da se dijelovi programa/koda izvrše, odnosno iteriraju više puta (zadani broj ili sve dok je određeni uvjet ispunjen), te na taj način ubrzavaju/automatiziraju procesuiranje podataka, poput primjerice pretraživanja lista i polja


#### Git grananje
 
 ```
<!-- inicijalizacija -->
git init

<!-- postavljanje username i email u git konfiguracijsku datoteku -->
git config --global user.name <username>
git config --global user.email <mailaddress>

<!-- prikaz podataka iz git konfiguracijske datoteke -->
git config --global --list

<!-- postupak spajanja sa udaljenim repozitorijem -->
<!-- postavljanje promjena . označava da postavljamo sve, a možemo dodavati i zasebno fileove ili foldere -->
git add .
<!-- svaki commit mora biti označen sa porukom -->
git commit -m "prvi commit"
<!-- označavamo udaljeni repozitorij kao origin -->
git remote add origin adresa_repozitorija
<!-- šaljemo sa master grane lokalnog repozitorija na udaljeni origin repozitorij, -u (set upstream) konfigurira lokalnu granu da prati udaljeni repozitorij -->
git push -u origin master

<!-- kopiranje projekta sa nekog repozitorija -->
git clone git_repo_path

<!-- dohvat te spajanje podataka sa udaljenog repozitorija -->
git fetch
git merge

<!-- skraćeni način, automatski napravi i dohvat, i spajanje -->
git pull

<!-- skraćeni način slanja podataka sa lokalne grane na udaljeni repozitorij, nakon što smo prilikom prvog pusha sve konfigurirali, origin i set upstream -->
git push

<!-- trenutno stanje gita, grana, promjene, itd. -->
git status

<!-- undo svih promjena ako nismo napravili add-commit, . sve promjene, a mogu se i zasebno navesti pojedini folderi i fileovi -->
git checkout .

<!-- undo add -->
git reset

<!-- undo samo commita -->
git reset --soft HEAD^

<!-- undo commit i add -->
git reset HEAD^

<!-- undo commit, add i svih promjena -->
git reset --hard HEAD^

<!-- ispis grane na kojoj smo trenutno -->
git branch

<!-- kreiranje nove grane lokalno, ali ne i automatski prijelaz na nju -->
git branch nova

<!-- prijelaz na novu granu -->
git checkout nova

<!-- stavljanje novostvorene grane na udaljeni repozitorij -->
git push -u origin nova

<!-- dohvaćanje osvježenog popisa novih grana sa udaljenog repozitorija -->
git fetch

<!-- dohvaćanje najnovije verzije nove grane sa udaljenog repozitorija, te potom dohvaćanje izmjena sa master grane u novu granu -->
git fetch
git merge origin nova

<!-- uzastopno odrađene fetch i merge naredbe -->
git pull origin nova

<!-- prebacivanje na master granu -->
git checkout master

<!-- dohvat filea iz nove grane u master -->
git checkout nova ime_filea

<!-- spajanje podataka iz nove grane u master -->
git merge nova

<!-- brisanje nove grane na udaljenom repozitoriju -->
git push -d origin nova

<!-- brisanje nove grane lokalno, prije toga se sa checkout morate premjestiti na neku drugu granu -->
git branch -d nova
 ```


#### Prikaz sadržaja Linux datoteke

- ispis u Linux terminalu

 ```
cat ime_datoteke
 ```

- prikaz datoteke sa posebnim programima

 ```
nano ime_datoteke
vim ime_datoteke
 ```


#### Zapisivanje u file kroz Linux terminal

- sa operatorom >> i naredbom echo dodajemo tekst kao novu liniju na kraj datoteke

 ```
echo "Hello World" >> file.txt
 ```

- sa operatorom > dodajemo tekst i brišemo stari sadržaj datoteke

 ```
echo "Hello World" > file.txt
 ```

- dodatne opcije
 ```
https://www.baeldung.com/linux/file-append-text-no-redirection
 ```


#### Provjera PHP verzije u Linux terminalu

 ```
php -v
 ```


#### SQL pretvaranje entiteta u relacije

- zaposlenik može tokom vremena odraditi više poslova, a na svakom poslu može raditi više zaposlenika

 ```
    ZAPOSLENIK(id, ime, prezime, adresa)
    ODRAĐENI_POSLOVI (id_zaposlenik, id_posao, datum)
    POSAO (id, naziv)

    ZAPOSLENIK 1 - n ODRAĐENI_POSLOVI n - 1 POSAO
 ```


#### SQL procedura

- napraviti proceduru koja će u tablici proizvodi mijenjati količine ovisno o količini prodanih proizvoda
 
 ```
 https://www.dolthub.com/blog/2024-01-17-writing-mysql-procedures/
 <!-- mini tutorial za mysql procedure -->

DROP DATABASE IF EXISTS `algebra`;

CREATE DATABASE IF NOT EXISTS `algebra` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `algebra`;

CREATE TABLE IF NOT EXISTS `proizvodi` (
    `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
    `naziv` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
    `kolicina` int UNSIGNED NOT NULL,
);

INSERT INTO `proizvodi` (`naziv`, `kolicina`) VALUES
    ('kruh', '1000'),
    ('pecivo', '500'),
    ('burek', '500'),
    ('buhtla', '200'),
    ('sendvic', '100');

-- procedura za izmjenu količine
DROP PROCEDURE IF EXISTS `izmjena_kolicine`;

DELIMITER //

CREATE PROCEDURE IF NOT EXISTS `izmjena_kolicine`(
    IN prodan_proizvod_id INT UNSIGNED,
    IN prodana_kolicina INT UNSIGNED
)

BEGIN
    DECLARE stara_kolicina INT UNSIGNED;

    START TRANSACTION;

    IF prodana_kolicina = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Izmjena nije potrebna';
    END IF;

    IF prodan_proizvod_id NOT IN (SELECT proizvod.id FROM proizvod)
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Proizvod ne postoji';
    ELSE
        SELECT kolicina
            INTO stara_kolicina
            FROM proizvod
            WHERE id = prodan_proizvod_id
            FOR UPDATE; -- race condition (osigurava da nema stranih upisa u navedenu tablicu, zaključava je dok se ne izvrši naša transakcija)
    END IF;

    IF (stara_kolicina - prodana_kolicina) >= 0 THEN
        UPDATE proizvod
            SET kolicina = (stara_kolicina - prodana_kolicina)
            WHERE id = prodan_proizvod_id;

        COMMIT;
    ELSE
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nema dovoljno na zalihi';
    END IF;

END //

DELIMITER ;

 ```


#### PHP Unit config xml

- napraviti PHPUnit config xml koji će napraviti exclude određene datoteke (u našem slučaju config)
 
 ```
https://docs.phpunit.de/en/10.5/configuration.html#the-exclude-element

https://laraveldaily.com/lesson/testing-laravel/db-configuration-refreshdatabase-phpunit-xml-env-testing


<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true">
    <!-- testovi -->
    <testsuites>
        <testsuite name="Tests">
            <directory>./tests</directory>
        </testsuite>
        <!-- može se dodati više od jedne testne konfiguracije -->
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
    </testsuites>
    <!-- definiranje koji direktoriji će biti uključeni tokom izvođenja testova -->
    <source>
        <include>
            <directory>app</directory>
        </include>
        <exclude>
        <!-- primjer excludeanja direktorija -->
            <directory suffix=".php">app/Providers</directory> 
        <!-- primjer excludeanja filea -->
            <file suffix=".php">app/Providers/AppServiceProvider.php</file>
        </exclude>
    </source>
        <php>
        <env name="APP_ENV" value="testing"/>
        <env name="APP_MAINTENANCE_DRIVER" value="file"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_STORE" value="array"/> 
        <env name="DB_CONNECTION" value="mysql"/>
        <env name="DB_DATABASE" value="algebra"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="PULSE_ENABLED" value="false"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>
 ```


#### HTML forma

- napraviti formu koja će slati username i password sa POST metodom (potreban je i submit button)
 
 ```
<?php 

    <form action="/login" method="POST">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password"id="password" name="password" required>
        </div>
        <hr>
        <div>
            <button type="submit" value="Suubmit">Submit</button>
        </div>
    </form>

<!-- za file u form treba dodati enctype="multipart/form-data" te type="file" -->

 ```


#### Pretvaranje funkcije u klasu

- u klasi definiramo dvije privatne varijable, numberA i numberB, dvije public metode za dohvaćanje njihovih vrijednosti (settere), te public funkciju za zbrajanje
 
 ```
function sum(int a, int b): int
{
    return a + b;
}

class Sum 
{
    private int $numberA;
    private int $numberB;

    public function setA(int $a) 
    {
        $this->numberA = $a;
    }

    public function setB(int $b) 
    {
        $this->numberB = $b;
    }

    public function sum(int a = null, int b = null ); int
    {
         
        return (a ?? $this->numberA ?? 0) + (b ?? $this->numberB ?? 0);
    }
}

$zbroj = new Sum();

$zbroj->setA(7);
$zbroj->setB(10);

$zbroj->sum(4, 5)
<!-- vratit će 9 -->

$zbroj->sum(); 
<!-- vratit će 17 -->

 ```

#### array_map()

- funkcija array_map() kao prvi argument može primiti ili ime druge funkcije, ili anonimnu "callback" funkciju, a kao ostale argumente prima jedno ili više polja vrijednosti (koje onda redom koristi u funkciji danoj sa prvim argumentom)
 
 ```
function squares($n)
{
    return ($n * $n);
}
$squares = array_map('squares', [2, 3, 4, 5, 6]);
print_r($squares);

array(
    [0] => 4
    [1] => 9
    [2] => 16
    [3] => 25
    [4] => 36
)

https://www.php.net/manual/en/function.array-map.php
 ```


#### SQL migracije

- prijenos sheme (database schema migration) i podataka (sql data migration) iz jedne u drugu (odredišne u ciljnu) bazu


#### Laravel migracije

- služe za definiranje sheme baze podataka određene aplikacije (kreiranje i modificiranje tablica/entiteta i njenih atributa) sa ciljem olakšavanja prijenosa i rada u timu (primjerice laka dostupnost najnovije verzije i u slučaju promjena od strane drugog člana tima koji radi na istoj aplikaciji)
 
 ```
https://laravel.com/docs/11.x/migrations#introduction

 <!-- kreiranje nove baze prema shemi u database/migrations folderu -->
php artisan migrate

<!-- brisanje stare i kreiranje nove baze -->
php artisan migrate:fresh

<!-- brisanje stare, kreiranje nove baze te punjenje podacima prema shemi u database/seeders i database/factories folderima -->
php artisan migrate:fresh --seed
 ```


#### Postavljanje aplikacije na server

- ulogirajte se na udaljeni server sa danim podacima (username i password)

```
username@ip_adresa_servera
<!-- nakon čega će vas tražiti password -->
```

- na serveru najprije treba omogućiti OpenSSH (ako već nije), te dodati vlastiti SSH ključ prilikom spajanja sa desktop (u našem slučaju wsl) Linuxa na simulirani udaljeni Linux server (primjer za to, uključujući i kako stvoriti SSH ključ, te onemogućiti običan password login, možete vidjeti na linkovima dolje)

```
https://ubuntu.com/server/docs/openssh-server

https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu

https://www.youtube.com/watch?v=3FKsdbjzBcc
```

- nakon što ste se spojili sa vlastitog linuxa na udaljeni server, trebate instalirati PHP i Composer (eventualno još i Docker ili samostalno mysql/neku drugi database provider, te apache/nginx), nakon čega ćete imati potpuno spreman "udaljeni" Linux server za pokretanje vaših aplikacija

```
https://github.com/bozidar09/backend_developer/blob/master/radno_okruzenje/setup.sh

sudo apt install -y php libapache2-mod-php php-mysql php-pdo php-intl php-gd php-xml php-json php-mbstring php-tokenizer php-fileinfo php-opcache

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"
```

- opcija 1 - prebacivanje aplikacije na udaljeni server naredbom rsync -a

- prije prebacivanja trebate naredbom chown dobiti ovlast nad odredišnim direktorijem na serveru u kojeg želite spremiti aplikaciju (primjer slučaja ako aplikaciju želite prebaciti u odredišni direktorij /var/www/)

```
sudo chown -R algebra:algebra /var/www/
```

- nakon toga koristimo naredbu 'rsync -a' kako bi aplikaciju prebacili na udaljeni server (uz napomenu da nam trebaju sudo ovlasti ako na server želimo prebaciti i datoteke kojima vlasnik nije korisnik 'algebra')

```
sudo rsync -a /var/www/backend_developer/laravel-videoteka algebra@192.168.1.225:/var/www/
```

- opcija 2 - prebacivanje aplikacije na udaljeni server pomoću git clone

- prvo trebate kopirati link projekta sa githuba koji želite klonirati, te na serveru napraviti git clone

- nakon toga, treba prekopirati .env.example file u .env te dodati APP_KEY

```
echo $UID
cp .env.example .env
php artisan key:generate
```

- zatim sa composer install treba dodati vendor folder koji nedostaje (eventualno instalirati i zip, te unzip ako fale)

```
sudo apt-get install zip && sudo apt-get install unzip
composer install
```

- pokretanje aplikacije na udaljenom serveru

- kako bi spriječili greške sa file permissionima, trebate odraditi ove naredbe:

```
sudo chown -R algebra:www-data storage/ bootstrap/cache/
sudo chmod -R 775 storage/ bootstrap/cache/
```

- ako u projektu koristite custom javaScrip (Tailwind i slično) onda trebate odraditi npm naredbe

```
npm install
npm run build
```

- zatim napraviti provjeru i po potrebi izmjene .env filea (user_id, ime baze, username, password i slično) 

```
echo $UID
sudo nano .env
```

- naposlijetku trebate napraviti symlink, te napuniti bazu sa podacima

```
php artisan storage:link
php artisan migrate --seed
```


- opcija - pokretanje aplikacije pomoću dockera na udaljenom serveru

- najprije trebate instalirati docker na Linux udaljenog servera (upute na linku, opcionalno možete i dodati docker u sudo grupu)

```
https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04
```

- zatim trebate provjeriti portove u .env fileu (app_port, forward_db port i slično) i eventualno ih zamijeniti (najjednostavnije +1) ako želite upogoniti više docker aplikacija (jer svaka treba raditi na vlastitom portu)

- sljedeće trebate pokrenuti docker, te instalirati potrebne containerse (sa docker ps naredbom možete provjeriti koji containeri trenutno rade na serveru)

```
docker compose up -d
docker ps
```

- naposlijetku trebate ući u app docker container te napraviti symlink i pokrenuti migraciju

```
docker compose exec -it app bash
php artisan storage:link
php artisan migrate --seed
```

- nakon ovoga bi primjerice aplikaciji sa ip adresom 'udaljenog servera' 192.168.1.225 na portu 8000 trebali moći pristupiti u web browseru sa:

```
192.168.1.225:8000
```