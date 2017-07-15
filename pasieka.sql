-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 30 Cze 2017, 16:56
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pasieka`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `admin`
--

CREATE TABLE `admin` (
  `login` varchar(15) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `admin`
--

INSERT INTO `admin` (`login`, `haslo`) VALUES
('administrator', 'administrator');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `adres`
--

CREATE TABLE `adres` (
  `id_adres` smallint(6) NOT NULL,
  `ulica` varchar(35) COLLATE utf8_polish_ci NOT NULL,
  `nrdomu` varchar(15) COLLATE utf8_polish_ci NOT NULL,
  `miejscowosc` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `kodpocztowy` mediumint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `adres`
--

INSERT INTO `adres` (`id_adres`, `ulica`, `nrdomu`, `miejscowosc`, `kodpocztowy`) VALUES
(152, 'Solna', '22-999', 'Kluski', 11000);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `edu`
--

CREATE TABLE `edu` (
  `id_edu` int(11) NOT NULL,
  `nazwa` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `edu`
--

INSERT INTO `edu` (`id_edu`, `nazwa`) VALUES
(1, 'brak'),
(2, 'podstawowe'),
(3, 'średnie techniczne'),
(4, 'średnie zawodowe'),
(5, 'średnie ogólnokształcące'),
(6, 'wyższe licencjackie'),
(7, 'wyższe inżynierskie'),
(8, 'wyższe magisterskie'),
(9, 'wyższe doktoranckie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `hobby`
--

CREATE TABLE `hobby` (
  `id_hobby` tinyint(4) NOT NULL,
  `nazwa` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `hobby`
--

INSERT INTO `hobby` (`id_hobby`, `nazwa`) VALUES
(1, 'pszczelarstwo'),
(2, 'turystyka'),
(3, 'flora'),
(4, 'fauna'),
(5, 'gastronomia'),
(6, 'rolnictwo'),
(7, 'nic');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `miody`
--

CREATE TABLE `miody` (
  `id_miod` tinyint(4) NOT NULL,
  `nazwa_m` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `opis_m` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `miody`
--

INSERT INTO `miody` (`id_miod`, `nazwa_m`, `opis_m`) VALUES
(1, 'mniszkowy', 'Wyjątkowy, wiosenny miód o delikatnej, złotej barwie. Charakteryzuje go lekko pikantny smak, mocne nuty kwiatowe. Wyczuwalny również smak pyłku.'),
(2, 'spadziowy', 'Miód spadziowy charakteryzuje mocny, leśny smak i intensywna, ciemnozłota barwa. Przebijające nuty jesienne. Wyrafinowana słodycz dla smakoszy.'),
(3, 'wrzosowy', 'Miód o niesamowitej, żelowej konsystencji. W smaku intensywny, kwiatowy, z przeważającą nutą kwasowości. Barwa ciemna, karmelowa. Uważany za jeden z najbardziej pożądanych miodów wśród smakoszy.'),
(4, 'wiosenny', 'Miody pór roku najbliżej oddają charakter miejsca i czasu, z którego pochodzą.\r\nNasz miód wiosenny jest miodem lekkim, bardzo słodkim, delikatnym. Przeważają w nim smaki mniszka, kaczeńcy i krokusów. Barwa jasnozłota, słoneczna.'),
(5, 'letni', 'Miody pór roku najbliżej oddają charakter miejsca i czasu, z którego pochodzą.\r\nNasz miód letni to intensywne smaki tatrzańskiej przyrody: drzewa owocowe, maliny, porzeczki, głóg, dzikie róże.\r\nMocny, złoty odcień.'),
(6, 'jesienny', 'Miody pór roku najbliżej oddają charakter miejsca i czasu, z którego pochodzą.\r\nNasz miód jesienny, to niezwykle intensywne smaki z przewagą smaków leśnych: spadzi, wrzosów, czeremchy i gryki. Barwa ciemnozłota. Smak bardzo mocny, wyrafinowany.'),
(14, 'Krakowski', 'miód z pyłkiem z Huty');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `miod_poj`
--

CREATE TABLE `miod_poj` (
  `id_mp` tinyint(4) NOT NULL,
  `rodzaj` tinyint(4) NOT NULL,
  `pojemnosc` tinyint(4) NOT NULL,
  `cena` decimal(10,2) NOT NULL,
  `stan` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `miod_poj`
--

INSERT INTO `miod_poj` (`id_mp`, `rodzaj`, `pojemnosc`, `cena`, `stan`) VALUES
(1, 1, 1, '15.50', 10),
(2, 1, 2, '28.00', 15),
(3, 1, 3, '50.99', 12),
(4, 1, 4, '88.50', 11),
(5, 1, 5, '2.20', 30),
(6, 2, 1, '20.20', 20),
(7, 2, 2, '39.00', 12),
(8, 2, 3, '74.50', 30),
(9, 2, 4, '120.50', 22),
(10, 2, 5, '3.50', 24),
(11, 3, 1, '25.99', 30),
(12, 3, 2, '48.30', 13),
(13, 3, 3, '90.00', 12),
(14, 3, 4, '170.80', 14),
(15, 3, 5, '4.00', 14),
(16, 4, 1, '14.50', 20),
(17, 4, 2, '25.20', 22),
(18, 4, 3, '45.00', 18),
(19, 4, 4, '77.70', 9),
(20, 4, 5, '2.55', 17),
(21, 5, 1, '12.20', 23),
(22, 5, 2, '20.50', 23),
(23, 5, 3, '35.99', 11),
(24, 5, 4, '65.00', 11),
(28, 6, 3, '75.90', 15),
(29, 6, 4, '140.55', 22),
(35, 6, 5, '3.50', 31),
(36, 6, 2, '22.00', 20),
(37, 14, 1, '200.80', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pojemnosc`
--

CREATE TABLE `pojemnosc` (
  `id_poj` int(11) NOT NULL,
  `nazwa_poj` varchar(11) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `pojemnosc`
--

INSERT INTO `pojemnosc` (`id_poj`, `nazwa_poj`) VALUES
(1, '0.25L'),
(2, '0.5L'),
(3, '1L'),
(4, '2L'),
(5, 'próbka 50ml');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przesylka`
--

CREATE TABLE `przesylka` (
  `nazwa` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `cena` decimal(5,2) NOT NULL,
  `id_przesylka` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `przesylka`
--

INSERT INTO `przesylka` (`nazwa`, `cena`, `id_przesylka`) VALUES
('poczta polska', '8.85', 1),
('kurier', '15.55', 2),
('paczkomat', '5.00', 3),
('odbiór osobisty', '0.00', 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `status`
--

CREATE TABLE `status` (
  `id_status` smallint(6) NOT NULL,
  `nazwa` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `status`
--

INSERT INTO `status` (`id_status`, `nazwa`) VALUES
(1, 'złożone'),
(2, 'w trakcie realizacji'),
(3, 'wysłane/odebrane'),
(4, 'anulowane');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tresc_zamowienia`
--

CREATE TABLE `tresc_zamowienia` (
  `id_tz` int(11) NOT NULL,
  `towar` smallint(6) NOT NULL,
  `ilosc` smallint(6) NOT NULL,
  `id_zamowienia` int(11) NOT NULL,
  `cenajednostkowa` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `tresc_zamowienia`
--

INSERT INTO `tresc_zamowienia` (`id_tz`, `towar`, `ilosc`, `id_zamowienia`, `cenajednostkowa`) VALUES
(1, 1, 1, 6, '15.50'),
(2, 12, 1, 6, '48.30'),
(3, 20, 5, 6, '2.55'),
(4, 13, 1, 7, '90.00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `login` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `imie` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `wyksztalcenie` tinyint(4) DEFAULT NULL,
  `zgoda_news` tinyint(1) NOT NULL,
  `adres` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`login`, `imie`, `nazwisko`, `haslo`, `email`, `wyksztalcenie`, `zgoda_news`, `adres`) VALUES
('kaniola', 'Karolina', 'Nędza', '$2y$10$TlmS0zeCuP8A.DXAJuydsOlycTf5TYPJ9NvyeI6XQ1iZbvP12MdfC', 'moj@pt.pl', 1, 0, 152);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_hobby`
--

CREATE TABLE `user_hobby` (
  `id_user_hobby` mediumint(9) NOT NULL,
  `login` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `id_hobby` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `user_hobby`
--

INSERT INTO `user_hobby` (`id_user_hobby`, `login`, `id_hobby`) VALUES
(15, 'superinteligencja', 1),
(16, 'kaniola', 1),
(17, 'kaniola', 5),
(18, 'kaniola', 3),
(19, 'kaniola2', 1),
(20, 'kaniola2', 2),
(21, 'kaniola2', 5),
(22, 'piotrpiekny', 2),
(23, 'piotrpiekny', 5),
(24, 'czubajka', 7),
(25, 'kaniakolejna', 1),
(26, 'kaniakolejna', 2),
(27, 'kaniakolejna', 5),
(28, 'kaniakolejna', 4),
(29, 'kaniakolejna', 3),
(30, 'kaniakolejna', 6),
(31, 'kaniakolejna', 7),
(32, 'kaniamania', 1),
(33, 'kaniamania', 2),
(34, 'kaniamania', 5),
(35, 'kaniamania', 4),
(36, 'kaniamania', 3),
(37, 'kaniamania', 6),
(38, 'kaniamania', 7),
(39, 'panienkazokienka', 7),
(40, 'matejko666', 1),
(41, 'matejko666', 2),
(42, 'matejko666', 5),
(43, 'matejko666', 4),
(44, 'matejko666', 3),
(45, 'matejko666', 6),
(46, 'matejko666', 7),
(47, 'kaniolakaniola', 5),
(48, 'kaniakaniakania', 1),
(49, 'kiniakiniakinia', 1),
(50, 'kiniakiniakinia', 2),
(51, 'kiniakiniakinia', 5),
(52, 'kiniakiniakinia', 4),
(53, 'kiniakiniakinia', 3),
(54, 'kiniakiniakinia', 6),
(55, 'kiniakiniakinia', 7),
(56, 'kaniola', 1),
(57, 'kaniola', 3),
(58, 'kaniola', 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienie`
--

CREATE TABLE `zamowienie` (
  `id_zamowienie` int(11) NOT NULL,
  `klient` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `data_zamowienia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL,
  `ostatnia_aktualizacja` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `adres_dostawy` smallint(5) UNSIGNED NOT NULL,
  `rodzaj_dostawy` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `zamowienie`
--

INSERT INTO `zamowienie` (`id_zamowienie`, `klient`, `data_zamowienia`, `status`, `ostatnia_aktualizacja`, `adres_dostawy`, `rodzaj_dostawy`) VALUES
(4, 'kaniola', '2017-06-29 18:04:14', 3, '2017-06-30 14:28:40', 149, 3),
(5, 'kaniola', '2017-06-29 18:07:26', 2, '2017-06-30 14:29:53', 150, 3),
(6, 'kaniola', '2017-06-29 18:17:30', 1, '2017-06-29 18:17:30', 136, 1),
(7, 'kaniola', '2017-06-29 18:23:11', 1, '2017-06-29 18:23:11', 151, 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`login`);

--
-- Indexes for table `adres`
--
ALTER TABLE `adres`
  ADD PRIMARY KEY (`id_adres`);

--
-- Indexes for table `edu`
--
ALTER TABLE `edu`
  ADD PRIMARY KEY (`id_edu`);

--
-- Indexes for table `hobby`
--
ALTER TABLE `hobby`
  ADD PRIMARY KEY (`id_hobby`);

--
-- Indexes for table `miody`
--
ALTER TABLE `miody`
  ADD PRIMARY KEY (`id_miod`);

--
-- Indexes for table `miod_poj`
--
ALTER TABLE `miod_poj`
  ADD PRIMARY KEY (`id_mp`);

--
-- Indexes for table `pojemnosc`
--
ALTER TABLE `pojemnosc`
  ADD PRIMARY KEY (`id_poj`);

--
-- Indexes for table `przesylka`
--
ALTER TABLE `przesylka`
  ADD PRIMARY KEY (`id_przesylka`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `tresc_zamowienia`
--
ALTER TABLE `tresc_zamowienia`
  ADD PRIMARY KEY (`id_tz`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_hobby`
--
ALTER TABLE `user_hobby`
  ADD PRIMARY KEY (`id_user_hobby`);

--
-- Indexes for table `zamowienie`
--
ALTER TABLE `zamowienie`
  ADD PRIMARY KEY (`id_zamowienie`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `adres`
--
ALTER TABLE `adres`
  MODIFY `id_adres` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;
--
-- AUTO_INCREMENT dla tabeli `edu`
--
ALTER TABLE `edu`
  MODIFY `id_edu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT dla tabeli `hobby`
--
ALTER TABLE `hobby`
  MODIFY `id_hobby` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT dla tabeli `miody`
--
ALTER TABLE `miody`
  MODIFY `id_miod` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT dla tabeli `miod_poj`
--
ALTER TABLE `miod_poj`
  MODIFY `id_mp` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT dla tabeli `pojemnosc`
--
ALTER TABLE `pojemnosc`
  MODIFY `id_poj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `przesylka`
--
ALTER TABLE `przesylka`
  MODIFY `id_przesylka` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `status`
--
ALTER TABLE `status`
  MODIFY `id_status` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `tresc_zamowienia`
--
ALTER TABLE `tresc_zamowienia`
  MODIFY `id_tz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `user_hobby`
--
ALTER TABLE `user_hobby`
  MODIFY `id_user_hobby` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT dla tabeli `zamowienie`
--
ALTER TABLE `zamowienie`
  MODIFY `id_zamowienie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
