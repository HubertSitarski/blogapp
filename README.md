# Aplikacja Blog (Laravel + Vue) - Hubert Sitarski

## 1. Uruchomienie projektu

1. Pobieramy projekt
2. W katalogu `backend` uruchamiamy `composer install`
3. Kopiujemy `env.example` do `.env` i uzupełniamy plik `.env` o dane bazy danych
4. Używamy komendy `php artisan migrate`
5. Uruchamiamy komendę `php artisan passport:install`
6. Uzywamy komendy `php artisan db:seed`
7. Uzywamy komendy `php artisan storage:link`
8. Uzywamy komendy `php artisan key:generate`
9. Uzywamy komendy `php artisan config:cache`
10. Uruchamiamy serwer komendą `php artisan serve`
11. Przechodzimy do katalogu `frontend`
12. Uruchamiamy `npm install`
13. Uruchamamy serwer komendą `npm run serve`
14. Pod adresem `127.0.0.1:8000` znajdziemy API, pod adresem `127.0.0.1:8080` znajdziemy warstwę front-endową

## 2. Omówienie

Przygotowałem prostą aplikację, która ma symulować serwis do prowadzenia bloga. Projekt wydałem w formie MVP - dodałem podstawowe funkcje, które umożliwiają funkcjonowanie portalu.

W przyszłości aplikacja zostanie rozwinięta o dodatkowe funkcjonalności.

## 3. Wymagania aplikacji

* PHP 8
* Baza danych MySQL

## 4. Wybrane, użyte narzedzia

* Laravel 8
* MySQL
* Laravel Passport
* Vue.js
* Vuex
* Vue Router
* Bootstrap 4
* Axios
* Localforage

## 4. Przydatne komendy
`php artisan queue:work` - wysłanie zakolejkowanych emaili, które powstały po rejestracji użytkownika

## 5. Dane do logowania
* Super Admin
    * login: admin@example.pl
    * hasło: admin
    
* User
    * login: user@example.pl
    * hasło: user