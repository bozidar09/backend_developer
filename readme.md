
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
