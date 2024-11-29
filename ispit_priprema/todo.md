

Koji su po vama obavezni koraci koje biste uvrstili u CI - continous integration pipeline


U CI (Continuous Integration) pipeline-u, važno je implementirati nekoliko ključnih koraka kako bi se osigurala efikasnost, kvaliteta i stabilnost koda tijekom razvoja. Evo obaveznih koraka koje bih uvrstio u CI pipeline:

### 1. **Preuzimanje koda (Checkout)**
   - **Opis:** Pipeline počinje preuzimanjem najnovije verzije koda sa sustava za upravljanje verzijama (najčešće Git).
   - **Zašto:** Osigurava da se koristi najnovija verzija koda za testiranje i izgradnju, čime se omogućuje kontinuirani razvoj.

### 2. **Instalacija ovisnosti (Install Dependencies)**
   - **Opis:** Nakon preuzimanja koda, potrebno je instalirati sve ovisnosti projekta (biblioteke, paketi itd.).
   - **Zašto:** Većina aplikacija ovisi o vanjskim bibliotekama ili paketima, a ove ovisnosti moraju biti prisutne kako bi aplikacija ispravno funkcionirala i bila testirana.

### 3. **Statička analiza koda (Static Code Analysis)**
   - **Opis:** Korištenje alata za statičku analizu koda, poput **ESLint** (za JavaScript), **Pylint** (za Python), **SonarQube**, **Checkstyle** (za Java) i sl.
   - **Zašto:** Ovaj korak pomaže u pronalaženju potencijalnih grešaka u kodu, nepoželjnih stilskih praksi, pa čak i sigurnosnih propusta prije nego što se kod izvrši.

### 4. **Jedinični testovi (Unit Tests)**
   - **Opis:** Pokretanje svih jediničnih testova koji provjeravaju ispravnost funkcionalnosti na razini manjih dijelova koda (npr. funkcija, metoda).
   - **Zašto:** Ovaj korak omogućava da se osigura ispravnost svih funkcionalnosti i da kod ne sadrži regresije.

### 5. **Testiranje integracije (Integration Tests)**
   - **Opis:** Testiranje interakcije između različitih modula sustava.
   - **Zašto:** Ovi testovi pomažu provjeriti kako različite komponente sustava funkcioniraju zajedno.

### 6. **Testovi za prihvaćanje (Acceptance Tests)**
   - **Opis:** Testovi koji provjeravaju zadovoljava li aplikacija korisničke zahtjeve i je li spremna za proizvodnju.
   - **Zašto:** Ovi testovi verificiraju da sustav radi kako se očekuje od krajnjih korisnika.

### 7. **Izgradnja aplikacije (Build)**
   - **Opis:** Kompiliranje i izgradnja aplikacije (ako je potrebno), uključujući sve datoteke kao što su JAR, WAR, Docker image itd.
   - **Zašto:** Potrebno je generirati artefakte koji će biti postavljeni u proizvodnju ili testno okruženje.

### 8. **Testovi u produkcijskom okruženju (Production-like Tests)**
   - **Opis:** Pokretanje aplikacije u okruženju koje simulira produkciju kako bi se provjerilo funkcionira li sve kao što treba (npr. s istim okruženjima, bazama podataka, servisima).
   - **Zašto:** Pomaže u pronalaženju problema koji mogu nastati samo u produkcijskim uvjetima (npr. mrežni problemi, problemi s performansama).

### 9. **Deploy na test ili staging okruženje (Deploy to Test/ Staging Environment)**
   - **Opis:** Postavljanje izgrađene verzije aplikacije na testno/staging okruženje.
   - **Zašto:** Omogućuje timovima da testiraju aplikaciju u okruženju koje je što bliže stvarnoj produkciji.

### 10. **Testiranje performansi (Performance Tests)**
   - **Opis:** Pokretanje testova koji procjenjuju performanse aplikacije (npr. opterećenje, brzina odgovora).
   - **Zašto:** Osigurava da aplikacija može podnijeti predviđeni broj korisnika i opterećenja.

### 11. **Obavijesti o statusu (Notification)**
   - **Opis:** Nakon svakog koraka (ili na kraju pipeline-a), šaljemo obavijesti timu (npr. putem email-a, Slack-a) o statusu izgradnje i testova.
   - **Zašto:** Omogućava timu da brzo reagira ako se pojavi problem u bilo kojem koraku.

### 12. **Kreiranje verzije i označavanje (Versioning and Tagging)**
   - **Opis:** Ovaj korak označava uspješan build s verzijom (tag) koja može biti postavljena u proizvodnju.
   - **Zašto:** Pomaže u praćenju verzija softvera, što je posebno korisno za održavanje i retroaktivnu analizu.

### 13. **Deploy na produkciju (Production Deployment)**
   - **Opis:** U nekim CI/CD pipeline-ima, nakon uspješnog testiranja, može se postaviti nova verzija direktno na produkcijsko okruženje.
   - **Zašto:** Osigurava brzu isporuku novih funkcionalnosti i ispravki krajnjim korisnicima.

### 14. **Post-deployment monitoring i logiranje (Monitoring & Logging)**
   - **Opis:** Praćenje aplikacije u produkciji nakon implementacije, uključujući analiziranje logova, performansi i drugih ključnih metrika.
   - **Zašto:** Pomaže u brzom prepoznavanju potencijalnih problema u produkciji i omogućava brzo reagiranje.

### Dodatni koraci (Po potrebi):
- **Sigurnosno skeniranje (Security Scans)**: Prepoznaje sigurnosne ranjivosti u ovisnostima ili aplikaciji.
- **Generiranje dokumentacije (Documentation Generation)**: Generiranje i ažuriranje dokumentacije projekta, API-ja itd.

Uključivanje ovih koraka omogućava brzo otkrivanje i rješavanje problema, održavanje visokog kvaliteta koda i omogućava brzu i sigurnu isporuku softverskih rješenja.

