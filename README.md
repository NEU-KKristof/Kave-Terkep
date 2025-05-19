Drótváz https://www.figma.com/design/YTea7xtRgAaN3KuaIFrr1Z/Untitled?node-id=0-1&t=S8AFDMoV6NW4izsg-1

├── ./               <br>
├── README.md              <br>
├── website/                   <br>
│   ├── connection.php<br>
│   ├── index.php<br>
│   ├── insert.php<br>
│   ├── login.php<br>
│   ├── login_process.php<br>
│   ├── logout.php<br>
│   ├── navbar.php<br>
│   ├── rolunk.php<br>
│   ├── signup.php<br>
│   ├── signup_process.php<br>
│   └── style.css<br>
├── img/ <br>
│   |── Bourbon.jpg<br>
│   |── Selection 9.webp<br>
│   |── castillo.webp<br>
│   |── catimor.jpg<br>
│   |── coffeebean_icon.png<br>
│   |── green-coffee-beans.jpg<br>
│   |── heirloom.jpg<br>
│   |── robusta.jpg<br>
│   └── ruiro 11.webp<br>

1. Projekt Alapadatai
•	Projekt Címe: Kávé világ
•	Készítők: Karanyicz Kristóf, Tóth Roland, Ferenc Áron
•	Megrendelő: Cufforné Kleszó Éva
•	Projekt Időtartama: [Kezdés dátuma] – [Befejezés dátuma]
•	Projekt Háttere: Mostanában az emberek egyre jobban szeretik tudni, hogy amit fogyasztanak, használnak, vesznek honnan származik.
•	Projekt Célja: Egy olyan informatív weboldal létrehozása, amely bemutatja a világ fő kávétermesztő területeit kontinensekre bontva, valamint lehetővé teszi a felhasználók számára a regisztrációt és bejelentkezést egy adatbázis segítségével. Az oldal célja az ismeretterjesztés és a webfejlesztési technológiák gyakorlati alkalmazása.
•	Felhasznált Technológiák:
o	Frontend: HTML, CSS, JavaScript
o	Backend: PHP
o	Adatbázis: MySQL
o	Egyéb eszközök: XAMPP
2. Projekttervezés és Előkészítés
2.1. Ötletelés és Kutatás (Dátum: JJJJ.MM.NN - JJJJ.MM.NN)
•	Tevékenységek:
o	Téma pontosítása, főbb funkciók meghatározása.
o	Információgyűjtés a kávétermesztő régiókról (kontinensenként 3-3-3 helyszín).
o	Források felkutatása
o	Hasonló weboldalak elemzése inspiráció és ötletgyűjtés céljából.
•	Eredmények:
o	Kiválasztott kávétermesztő régiók listája kontinensenként.
o	Összegyűjtött alapinformációk minden régióról

 
2.2. Weboldal Struktúrájának Tervezése (Dátum: JJJJ.MM.NN - JJJJ.MM.NN)
•	Tevékenységek:
o	Oldaltérkép készítése: Főmenü pontok, aloldalak.
	Főoldal
	Kávérégiók (kontinensek szerint lebontva)
	Afrika (3 helyszín)
	Ázsia (3 helyszín)
	Dél-Amerika (3 helyszín)
	Regisztráció
	Bejelentkezés
	Rólunk/Projekt leírása
o	Drótváz (https://www.figma.com/design/YTea7xtRgAaN3KuaIFrr1Z/Untitled?node-id=0-1&t=S8AFDMoV6NW4izsg-1)
•	Eredmények:
o	Véglegesített oldaltérkép.
o	Elfogadott drótvázak.
2.3. Adatbázis Tervezése (Dátum: JJJJ.MM.NN - JJJJ.MM.NN)
•	Tevékenységek:
o	Szükséges táblák és mezők meghatározása:
	Adatok: id, felhasznalonev, email, jelszo_hash, regisztracio_datuma
•	Eredmények:
o	Véglegesített adatbázis séma.
o	Tábla és mezők listája.
2.4. Vizuális Terv Kialakítása (Dátum: JJJJ.MM.NN - JJJJ.MM.NN)
•	Tevékenységek:
o	Weboldal általános stílusának, hangulatának meghatározása.
o	Animáció stilus kiválasztása
•	Eredmények:
o	Kiválasztott színek, betűtípusok.
o	Általános dizájnkoncepció.
o	Animációk kiválasztása
3. Fejlesztési Fázis
3.1. Frontend Fejlesztés (HTML, CSS, JS) (Dátum: JJJJ.MM.NN - JJJJ.MM.NN)
•	HTML Struktúra Felépítése:
o	Főoldal, menürendszer.
o	Alterületek létrehozása a kávérégiók számára
o	Regisztrációs és bejelentkezési űrlapok HTML kódja.
•	CSS Stílusok Implementálása:
o	Reszponzív dizájn kialakítása (mobilbarát megjelenés).
o	Vizuális terv alapján az oldalak stílusozása.
o	Menük, gombok, kártyák és egyéb UI elemek formázása.
•	JavaScript Funkcionalitás:
o	Űrlapvalidáció (kliens oldali).
o	Interaktív elemek (dinamikus tartalombetöltés).
o	Menü működése (pl. mobil menü).
•	Eredmények:
o	Kész HTML oldalak.
o	Reszponzív CSS stíluslapok.
o	Működő kliens oldali JavaScript funkciók.
3.2. Backend Fejlesztés (PHP) és Adatbázis Implementáció (Dátum: JJJJ.MM.NN - JJJJ.MM.NN)
•	Adatbázis Létrehozása:
o	Adatbázis és táblák létrehozása a tervek alapján (phpMyAdmin segítségével).
•	PHP Logika:
o	Adatbázis kapcsolat PHP szkripttel.
o	Regisztrációs folyamat implementálása:
	Adatok fogadása az űrlapról.
	Adatok ellenőrzése (szerver oldali).
	Jelszó hashelése (titkosítása).
	Felhasználó mentése az adatbázisba.
o	Bejelentkezési folyamat implementálása:
	Adatok fogadása az űrlapról.
	Felhasználó ellenőrzése az adatbázisban.
•	Eredmények:
o	Működő adatbázis.
o	Működő regisztrációs és bejelentkezési rendszer PHP-val.
o	Biztonságos jelszókezelés.
3.3. Tartalomfeltöltés (Dátum: JJJJ.MM.NN - JJJJ.MM.NN)
•	Tevékenységek:
o	A kávétermesztő régiókról összegyűjtött információk, képek beillesztése a megfelelő HTML oldalakra.
o	Szövegek formázása, ellenőrzése.
•	Eredmények:
o	Teljes tartalommal feltöltött weboldal.
4. Tesztelés és Hibajavítás (Dátum: JJJJ.MM.NN - JJJJ.MM.NN)
•	Tevékenységek:
o	Funkcionális tesztelés:
	Regisztráció, bejelentkezés, kijelentkezés működésének ellenőrzése.
	Űrlapok helyes működése, bevitt adatok tesztelése.
	Linkek, navigáció ellenőrzése.
o	Megjelenítés tesztelése különböző böngészőkben (pl. Chrome, Brave, Edge) és képernyőméreteken (reszponzivitás).
o	Hibakeresés és javítás.
o	Kódellenőrzés (pl. HTML, CSS).
•	Eredmények:
o	Stabilitás, reszponzivitás, js
 
