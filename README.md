# Irányítószámok REST API (Laravel)

Laravel és Sanctum alapú REST API alkalmazás megyék és települések (irányítószámok) kezelésére.

## Telepítés és indítás

1. Klónozás után függőségek telepítése:
   `composer install`
2. Környezeti fájl létrehozása és adatbázis beállítása:
   `cp .env.example .env`
   `php artisan key:generate`
3. Migráció és teszt felhasználó létrehozása (vagy a `database/laravel_rest_api.sql` importálása):
   `php artisan migrate --seed`
4. Szerver indítása:
   `php artisan serve`

## Elérhető API végpontok

| Metódus | Végpont | Hitelesítés (Bearer Token) | Leírás | Query paraméterek |
| :--- | :--- | :---: | :--- | :--- |
| `POST` | `/api/login` | Nem | Bejelentkezés és token generálás | - |
| `POST` | `/api/logout` | **Igen** | Kijelentkezés (token érvénytelenítése) | - |
| `GET` | `/api/counties` | Nem | Összes megye listázása | `?search=` |
| `GET` | `/api/counties/{id}` | Nem | Egy megye és településeinek lekérdezése | - |
| `POST` | `/api/counties` | **Igen** | Új megye létrehozása | - |
| `PUT` | `/api/counties/{id}` | **Igen** | Meglévő megye módosítása | - |
| `DELETE` | `/api/counties/{id}` | **Igen** | Megye törlése | - |
| `GET` | `/api/cities` | Nem | Települések listázása, keresése és szűrése | `?search=`, `?county_id=` |
| `GET` | `/api/cities/{id}` | Nem | Egy település részletes lekérdezése | - |
| `POST` | `/api/cities` | **Igen** | Új település létrehozása | - |
| `PUT` | `/api/cities/{id}` | **Igen** | Meglévő település módosítása | - |
| `DELETE` | `/api/cities/{id}` | **Igen** | Település törlése | - |

## Tesztelés és Dokumentáció

* **Bruno gyűjtemény:** Az elmentett API tesztkérések az `Iranyitoszam API/` mappában találhatók.
* **API Dokumentáció:** Megtekinthető a `public/docs/index.html` fájl megnyitásával, vagy futó szerver esetén a `http://127.0.0.1:8000/docs` útvonalon.