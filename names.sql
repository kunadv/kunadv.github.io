-- Utworzenie bazy danych z polskim kodowaniem znaków
CREATE DATABASE IF NOT EXISTS `firma` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `firma`;

-- --------------------------------------------------------
-- Tabela: trenerzy
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `trenerzy` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Nazwisko` VARCHAR(30) NOT NULL,
  `Imie` VARCHAR(20) NOT NULL,
  `Data_ur` DATE DEFAULT NULL,
  `Plec` CHAR(1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Przykładowe dane dla tabeli trenerzy
INSERT INTO `trenerzy` (`Id`, `Nazwisko`, `Imie`, `Data_ur`, `Plec`) VALUES
(1, 'Kowalski', 'Jan', '1985-05-12', 'M'),
(2, 'Nowak', 'Anna', '1990-11-23', 'K');

-- --------------------------------------------------------
-- Tabela: szkolenia
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `szkolenia` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Id_trenera` INT(11) NOT NULL,
  `Data` DATE NOT NULL,
  `Temat` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_trenera` (`Id_trenera`),
  CONSTRAINT `fk_szkolenia_trenerzy` FOREIGN KEY (`Id_trenera`) REFERENCES `trenerzy` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Przykładowe dane dla tabeli szkolenia
INSERT INTO `szkolenia` (`Id`, `Id_trenera`, `Data`, `Temat`) VALUES
(1, 1, '2021-09-20', 'Podstawy języka C++'),
(2, 2, '2021-09-30', 'Photoshop dla zaawansowanych'),
(3, 1, '2021-10-01', 'Podstawy języka Python');

-- --------------------------------------------------------
-- Tabela: sluchacze
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sluchacze` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Nazwisko` VARCHAR(30) NOT NULL,
  `Imie` VARCHAR(20) NOT NULL,
  `Data_ur` DATE DEFAULT NULL,
  `Plec` CHAR(1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Przykładowe dane dla tabeli sluchacze
INSERT INTO `sluchacze` (`Id`, `Nazwisko`, `Imie`, `Data_ur`, `Plec`) VALUES
(1, 'Wisniewski', 'Piotr', '2000-01-15', 'M'),
(2, 'Wojcik', 'Maria', '1998-07-04', 'K');

-- --------------------------------------------------------
-- Tabela: zapisy
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `zapisy` (
  `Id` INT(11) NOT NULL AUTO_INCREMENT,
  `Id_szkolenia` INT(11) NOT NULL,
  `Id_klienta` INT(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id_szkolenia` (`Id_szkolenia`),
  KEY `Id_klienta` (`Id_klienta`),
  CONSTRAINT `fk_zapisy_szkolenia` FOREIGN KEY (`Id_szkolenia`) REFERENCES `szkolenia` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_zapisy_sluchacze` FOREIGN KEY (`Id_klienta`) REFERENCES `sluchacze` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Przykładowe dane dla tabeli zapisy
INSERT INTO `zapisy` (`Id`, `Id_szkolenia`, `Id_klienta`) VALUES
(1, 1, 1),
(2, 2, 2);

-- ========================================================
-- KWERENDY EGZAMINACYJNE (kwerendy.txt)
-- ========================================================

-- Zapytanie 1: Wybierające jedynie daty i tematy szkoleń posortowane rosnąco według daty szkolenia
SELECT Data, Temat 
FROM szkolenia 
ORDER BY Data ASC;

-- Zapytanie 2: Wybierające jedynie daty i tematy szkoleń oraz odpowiadające im nazwiska i imiona trenerów (relacja)
SELECT szkolenia.Data, szkolenia.Temat, trenerzy.Nazwisko, trenerzy.Imie 
FROM szkolenia 
JOIN trenerzy ON szkolenia.Id_trenera = trenerzy.Id;

-- Zapytanie 3: Wybierające dla każdego trenera jego imię, nazwisko oraz zliczające liczbę jego szkoleń (relacja)
SELECT trenerzy.Imie, trenerzy.Nazwisko, COUNT(szkolenia.Id) AS Liczba_szkolen 
FROM trenerzy 
LEFT JOIN szkolenia ON trenerzy.Id = szkolenia.Id_trenera 
GROUP BY trenerzy.Id, trenerzy.Imie, trenerzy.Nazwisko;

-- Zapytanie 4: Zmieniające w tabeli zapisy nazwę kolumny Id_klienta na Id_sluchacza
ALTER TABLE zapisy CHANGE Id_klienta Id_sluchacza INT(11);