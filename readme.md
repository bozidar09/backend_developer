## Vlastiti host

- otvorite terminal (bilo u VSCode, bilo zasebno) i sa naredbom "cd /etc/apache2/sites-available" se pozicionirajte u apache direktorij dostupnih hostova

- sa naredbom "sudo nano laravel-videoteka.conf" (umjesto laravel-videoteka fileu možete dati i neko drugo ime po vlastitom izboru) stvorite i otvorite konfiguracijsku host datoteku

- u nju iskopirajte (klikom desnom tipkom miša u otvorenom fileu u nano editoru) ovaj kod:

```
 <VirtualHost *:80>
    ServerName laravel.videoteka
    DocumentRoot /var/www/backend_developer/laravel-videoteka/public

    <Directory /var/www/backend_developer/laravel-videoteka/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    Alias /phpmyadmin /usr/share/phpmyadmin
    <Directory /usr/share/phpmyadmin>
        Options FollowSymLinks
        DirectoryIndex index.php
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/laravel.error.log
    CustomLog ${APACHE_LOG_DIR}/laravel.access.log combined
</VirtualHost>
```

- napomena da ServerName (ovdje laravel.videoteka) možete dati po vlastitom izboru, no DocumentRoot i Directory moraju biti putanje do public direktorija u kojem ste spremili Laravel (većina vas će tu imati laravel-videoteka, no ako ste dali neko drugo ime, onda tu treba upisati njega)

- datoteku spremite sa 'ctrl+o', te izađete sa 'ctrl+x'

- zatim u terminalu izvedete naredbu "sudo a2ensite laravel-videoteka"

- i posljednja stvar u terminalu, naredba "sudo systemctl reload apache2", no morate ostaviti otvoren VSCode (ili zasebni terminal ako ste u njemu radili) da bi mogli otvoriti stranicu u web pretraživaču, odnosno da bi vaš host radio

- u Windowsima otvorite Notepad (ili neki drugi tekst editor) u administrator modu (desni klik na shortcut ikonu pa opcija "more" i zatim "run as administrator")

- kliknite u gornjem lijevom kutu na "file" i "open" te pronađite putanju "Windows\System32\drivers\etc" te dolje u desnom kutu umjesto "Text documents" odaberite opciju "All files" nakon čega će vam se prikazati "hosts" file kojeg trebate otvoriti

- u "hosts" fileu na kraju kopirajte ove dvije linije, te spremite datoteku

```
127.0.0.1       laravel.videoteka
::1             laravel.videoteka
```

- nakon ovoga bi trebali u web pregledniku moći u pretraživač ukucati laravel.videoteka (uz upaljen VSCode) i tamo bi vam se trebala prikazati Laravel welcome stranica



## Keyboard shortcuts (-> i =>) u VSCode

- otvorite VSCode i u donjem lijevom kutu kliknite na ikonu "Manage" (zupčanik), te odaberite opciju "Keyboard shortcuts"

- u prozoru koji će vam se otvoriti na gornjoj lijevoj strani kliknite na ikonu "Open Keyboard Shortcuts (JSON)" (izgleda kao list papira) nakon čega će vam se otvoriti datoteka "keybindings.json"

- u toj datoteci "keybindings.json" unutar! uglatih zagrada [ ] dodajte ovaj kod i spremite datoteku:

```
{
    "key": "ctrl+oem_102",
    "command": "editor.action.insertSnippet",
    "when": "editorTextFocus",
    "args": {
      "snippet": "->"
    }
  },
  {
    "key": "alt+oem_102",
    "command": "editor.action.insertSnippet",
    "when": "editorTextFocus",
    "args": {
      "snippet": "=>"
    }
  }
```

- nakon ovoga ćete sa kombinacijom "ctrl + <" moći automatski dodati "->" (koristimo je kod korištenja svojstava i metoda objekata, odnosno instanci klasa), a sa "alt + <" oznaku "=>" (koristimo je kod definiranja asocijativnih polja)



## (Moguće) rješenje problema sa prikazom Debug bara

- ako već ne postoji, u direktoriju 'storage' stvorite novi direktorij 'debugbar', u terminal ukucajte ove naredbe:
 
 ```
cd storage/
mkdir debugbar
 ```
 
- dajte sve ovlasti 'www-data' sa:
 
 ```
sudo chown -R www-data:www-data debugbar/
 ```
 
- i zatim očistite 'config' i 'routes':
 
 ```
sudo php artisan config:clear
sudo php artisan route:clear
```

- nakon ovoga bi vam se na dnu stranice vašeg Laravel projekta trebao prikazati Debug bar



## Instalacija Gravatar i Picsum images faker paketa

- u VS Code otvorite terminal i odradite ove dvije naredbe jednu za drugom:

 ```
composer require ottaviano/faker-gravatar --dev
composer require --dev smknstd/fakerphp-picsum-images
 ```

 - nakon toga u terminalu napravite novi Service Provider sa naredbom:

 ```
php artisan make:provider FakerServiceProvider
 ```

 - nakon čega će vam se u direktoriju app/Providers stvoriti novi file 'FakerServiceProvider.php' u kojeg trebate iskopirati ovaj kod:

 ```
    <?php

    namespace App\Providers;

    use Faker\Factory;
    use Faker\Generator;
    use Illuminate\Support\ServiceProvider;

    class FakerServiceProvider extends ServiceProvider
    {
        /**
        * Register services.
        */
        public function register(): void
        {
            $locale = app('config')->get('app.faker_locale') ?? 'en_US';

            $abstract = Generator::class . ':' . $locale;

            $this->app->singleton($abstract, function () use ($locale) {
                $faker = Factory::create($locale);

                $faker->addProvider(new \Ottaviano\Faker\Gravatar($faker));
                $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));

                return $faker;
            });
            
        }

        /**
        * Bootstrap services.
        */
        public function boot(): void
        {
            //
        }
    }
 ```

 - također, u fileu 'AppServiceProvider.php' koji se nalazi unutar istoga direktorija, trebate registrirati taj novovostvoreni service provider na način da unutar vitičastih zagrada {} metode register() dodate ovaj kod:

 ```
 if (!$this->app->environment('production')) {
            $faker = fake();
            $faker->addProvider(new \Ottaviano\Faker\Gravatar($faker));
            $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));
 }
 ```

- objašnjenje if bloka - ovo će vrijediti samo ako niste u produkcijskom okruženju (naš environment je namješten na 'local'), zatim umjesto $faker za pozivanje funkcija ovih servisa možete koristiti fake(), te zatim dodajemo ta dva nova faker providera sa funkcijom addProvider()

- nakon ovoga prilikom kreiranja factoriesa za pojedine tablice (recimo avatar atribut u tablici users ili image atribut u tablici articles) za kreiranje nešto smislenijih slika možete koristiti naredbe:

 ```
 avatar => fake()->gravatarUrl()
 image => fake()->imageUrl()
 ```

- linkovi na ta dva paketa:

 ```
  https://github.com/ottaviano/faker-gravatar
  https://github.com/smknstd/fakerphp-picsum-images
 ```



## Stvaranje custom layouta za Blade x-components u /layouts folderu:

- ako želite stvoriti custom layout, primjerice za naš home page, koji ne mora biti spremljen u /components folderu (nego recimo /layouts poput app.blade.php i guest.blade.php layouta) slijedite ove upute

- u VS Code otvorite terminal i napravite novi component (u našem slučaju MasterLayout) sa ovom naredbom:

```
sudo php artisan make:component MasterLayout
```

- nakon čega će vam se kreirati MasterLayout.php file sa istoimenom klasom koja nasljeđuje klasu Component, unutar tog filea upišite ovaj kod:

```
  <?php

  namespace App\View\Components;

  use Illuminate\Database\Eloquent\Collection;
  use Illuminate\View\Component;
  use Illuminate\View\View;

  class MasterLayout extends Component
  {
      /**
      * Get the view / contents that represents the component.
      */
      public function render(): View
      {
          return view('layouts.master');
      }
  }
```

- ovdje u render() metodi navodimo gdje se nalazi master.blade.php file, odnosno gdje ga poziv na metodu može pronaći (layouts folder)

- zatim u resources/views/layouts folderu kreirajte novi file master.blade.php i u njemu izdvojite okvir vašeg home pagea (kojeg će pozivati home.blade.php, i koji će uključivati - include(), header, footer i slične dijelove html stranice)



## Simulacija udaljenog Linux servera pomoću Virtualboxa:

- download najnovijih verzija Virtualbox i Ubuntu server LTS

- nakon instalacije, u Virtualboxu treba odabrati opciju 'New' za dodavanje nove virtualke, te kliknuti na "Skip unattended installation" kako bi mogli ručno namjestiti pojedine opcije, pritom je ključno odabrati dovoljnu veličinu virtualnog hard diska (barem 30GB) ako na virtualki želite instalirati i docker

- u settings (može i prije, i poslije instalacije) treba za Network namjestiti opciju 'bridged connection'

- tokom instalacije bitno je namjestiti vlastiti ipV4 network connection, te naposljetku odabrati opciju da se instalira OpenSSH (u videu možete vidjeti primjer toga)

```
https://www.youtube.com/watch?v=zx3bICfe5PY
```

- nakon instalacije virtualke treba omogućiti OpenSSH, te dodati vlastiti SSH ključ prilikom spajanja sa desktop (u našem slučaju wsl) Linuxa na simulirani udaljeni Virtualbox Linux server (primjer za to, uključujući i kako stvoriti SSH ključ, te onemogućiti običan password login, možete vidjeti na linkovima dolje)

```
https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu

https://www.youtube.com/watch?v=3FKsdbjzBcc
```

- nakon što ste se spojili sa vlastitog linuxa na "udaljeni server", trebate još iskopirati i pokrenuti .setup.sh datoteku sa gita (pritom treba naglastiti da je iz nje na "server" jedino bitno instalirati PHP i Composer), nakon čega ćete imati potpuno spreman "udaljeni" Linux server za pokretanje vaših aplikacija

```
sudo apt install -y php libapache2-mod-php php-mysql php-pdo php-intl php-gd php-xml php-json php-mbstring php-tokenizer php-fileinfo php-opcache

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"
```



## Prebacivanje aplikacije na udaljeni server naredbom rsync -a

- prije prebacivanja trebate naredbom chown dobiti ovlast nad odredišnim direktorijem na serveru u kojeg želite spremiti aplikaciju (primjer slučaja ako aplikaciju želite prebaciti u odredišni direktorij /var/www/)

```
sudo chown -R algebra:algebra /var/www/
```

- nakon toga koristimo naredbu 'rsync -a' kako bi aplikaciju prebacili na udaljeni server (uz napomenu da nam trebaju sudo ovlasti ako na server želimo prebaciti i datoteke kojima vlasnik nije korisnik 'algebra')

```
sudo rsync -a /var/www/backend_developer/laravel-videoteka algebra@192.168.1.225:/var/www/
```



## Prebacivanje aplikacije na udaljeni server pomoću git clone

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



## Pokretanje aplikacije na udaljenom serveru

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



## Pokretanje aplikacije pomoću dockera na udaljenom serveru

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



## Instalacija wsl i ubuntu na virtualnim Windowsima

- upute za instalaciju wsl i Ubuntu iz command prompta (Windows+R, pa upišite cmd, te potom ctrl+shift+enter da bi ga otvorili sa administratorskim ovlastima)

 ```
https://learn.microsoft.com/en-us/windows/wsl/install
 ```

- nakon toga trebate spojiti wsl sa VS Code prema sljedećim uputama (koristite "from VS Code" dio)

 ```
https://code.visualstudio.com/docs/remote/wsl
 ```

- sljedeće pristupite Ubuntu putem terminala na VS Code te napravite naredbu za update i upgrade

 ```
sudo apt-get update && sudo apt-get upgrade -y
 ```

- zatim kopirajte .setup.sh sa gita (imate link dolje) i pohranite u setup.sh na Ubuntu (sa sudo nano), dajte mu 777 ovlasti (sudo chmod 777), te ga pokrenite kako bi instalirali LAMP stack (php, mysql, apache, composer)

 ```
https://github.com/adobrini-algebra/radno_okruzenje/blob/master/setup.sh

sudo nano setup.sh
sudo chmod 777 setup.sh
setup.sh
 ```



## Instaliranje Laravel projekta pomoću Composera

- s obzirom da već imamo instalirane php i composer (ako smo instalirali LAMP stack pomoću setup.sh datoteke), Laravel možemo instalirati ovom naredbom:

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



## Postavljanje aplikacije na server

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

```
git clone link_projekta
```

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
