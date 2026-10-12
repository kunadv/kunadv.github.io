-- Zapytanie 1: wybierające jedynie id, nazwę i zdjęcie z tabeli gry
SELECT id, nazwa, zdjecie FROM gry;

-- Zapytanie 2: wybierające jedynie nazwę, pierwsze 100 znaków opisu, punkty oraz cenę z tabeli gry dla wiersza o id równym 1
SELECT nazwa, LEFT(opis, 100), punkty, cena FROM gry WHERE id = 1;

-- Zapytanie 3: wybierające jedynie pola nazwa i punkty z pięciu pierwszych wierszy o najwyższej punktacji z tabeli gry
SELECT nazwa, punkty FROM gry ORDER BY punkty DESC LIMIT 5;

-- Zapytanie 4: wstawiające do tabeli gry wiersz o danych zawartych w pliku rekord.txt (zgodnie z poleceniem wartości podstawiane z formularza w PHP, tutaj wzorzec zapytania)
INSERT INTO gry (nazwa, opis, cena, zdjecie, punkty) VALUES ('Nazwa', 'Opis', 0.0, 'zdjecie.jpg', 0);