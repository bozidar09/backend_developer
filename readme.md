
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