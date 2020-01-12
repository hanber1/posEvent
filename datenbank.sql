-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 09. Jan 2020 um 19:40
-- Server-Version: 10.3.11-MariaDB
-- PHP-Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `festverrechnung`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(100) NOT NULL,
  `idArtikelkategorie` int(11) NOT NULL,
  `idArtikeleinheit` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Tabellenstruktur für Tabelle `artikeleinheit`
--

CREATE TABLE `artikeleinheit` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(45) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellenstruktur für Tabelle `artikelkategorie`
--

CREATE TABLE `artikelkategorie` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(45) NOT NULL,
  `reihenfolge` int(11) DEFAULT NULL,
  `gutschein` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellenstruktur für Tabelle `buchung`
--

CREATE TABLE `buchung` (
  `id` int(11) NOT NULL,
  `rechnungsnummer` varchar(50) DEFAULT NULL,
  `idFesttag` int(11) DEFAULT NULL,
  `idPerson` int(11) DEFAULT NULL,
  `buchungstyp` int(11) DEFAULT NULL COMMENT '1...Barverkauf, 2...Kellner, 3...Kasse, 4...Kunde',
  `gesamtsumme` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL COMMENT '1...Bezahlt, 2...Offen',
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Tabellenstruktur für Tabelle `buchung_festartikel`
--

CREATE TABLE `buchung_festartikel` (
  `id` int(11) NOT NULL,
  `idBuchung` int(11) NOT NULL,
  `idFestartikel` int(11) NOT NULL,
  `menge` int(11) NOT NULL,
  `einzelsumme` decimal(10,2) DEFAULT NULL,
  `gesamtsumme` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Tabellenstruktur für Tabelle `fest`
--

CREATE TABLE `fest` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(100) NOT NULL,
  `zeitraum` text DEFAULT NULL,
  `idFesttyp` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Tabellenstruktur für Tabelle `festartikel`
--

CREATE TABLE `festartikel` (
  `id` int(11) NOT NULL,
  `idArtikel` int(11) NOT NULL,
  `idFesttag` int(11) NOT NULL,
  `preis` decimal(10,2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Tabellenstruktur für Tabelle `festfunktion`
--

CREATE TABLE `festfunktion` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(45) NOT NULL,
  `berechtigung` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Daten für Tabelle `festfunktion`
--

INSERT INTO `festfunktion` (`id`, `bezeichnung`, `berechtigung`, `status`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, 'Kellner', NULL, 1, '2019-05-09 22:26:30', 1, '2019-05-09 22:26:30', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `festkassa`
--

CREATE TABLE `festkassa` (
  `id` int(11) NOT NULL,
  `idKassa` int(11) NOT NULL,
  `idFesttag` int(11) NOT NULL,
  `aktSumme` decimal(10,2) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Tabellenstruktur für Tabelle `festmitarbeiter`
--

CREATE TABLE `festmitarbeiter` (
  `id` int(11) NOT NULL,
  `nummer` int(11) DEFAULT NULL,
  `idMitarbeiter` int(11) NOT NULL,
  `idFesttag` int(11) NOT NULL,
  `idFestfunktion` int(11) NOT NULL,
  `aktSumme` decimal(10,2) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Tabellenstruktur für Tabelle `festtag`
--

CREATE TABLE `festtag` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(100) NOT NULL,
  `datum` date DEFAULT NULL,
  `idFest` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Tabellenstruktur für Tabelle `festtyp`
--

CREATE TABLE `festtyp` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Tabellenstruktur für Tabelle `gruppe`
--

CREATE TABLE `gruppe` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(45) NOT NULL,
  `permission` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Daten für Tabelle `gruppe`
--

INSERT INTO `gruppe` (`id`, `bezeichnung`, `permission`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, 'Superadmin', 'a:68:{i:0;s:7:\"viewPos\";i:1;s:10:\"createUser\";i:2;s:10:\"updateUser\";i:3;s:8:\"viewUser\";i:4;s:10:\"deleteUser\";i:5;s:11:\"createGroup\";i:6;s:11:\"updateGroup\";i:7;s:9:\"viewGroup\";i:8;s:11:\"deleteGroup\";i:9;s:15:\"createEventuser\";i:10;s:15:\"updateEventuser\";i:11;s:13:\"viewEventuser\";i:12;s:15:\"deleteEventuser\";i:13;s:19:\"createEventfunction\";i:14;s:19:\"updateEventfunction\";i:15;s:17:\"viewEventfunction\";i:16;s:19:\"deleteEventfunction\";i:17;s:18:\"createCashregister\";i:18;s:18:\"updateCashregister\";i:19;s:16:\"viewCashregister\";i:20;s:18:\"deleteCashregister\";i:21;s:23:\"createEventcashregister\";i:22;s:23:\"updateEventcashregister\";i:23;s:21:\"viewEventcashregister\";i:24;s:23:\"deleteEventcashregister\";i:25;s:13:\"createArticle\";i:26;s:13:\"updateArticle\";i:27;s:11:\"viewArticle\";i:28;s:13:\"deleteArticle\";i:29;s:14:\"createCategory\";i:30;s:14:\"updateCategory\";i:31;s:12:\"viewCategory\";i:32;s:14:\"deleteCategory\";i:33;s:10:\"createUnit\";i:34;s:10:\"updateUnit\";i:35;s:8:\"viewUnit\";i:36;s:10:\"deleteUnit\";i:37;s:18:\"createEventarticle\";i:38;s:18:\"updateEventarticle\";i:39;s:16:\"viewEventarticle\";i:40;s:18:\"deleteEventarticle\";i:41;s:11:\"createEvent\";i:42;s:11:\"updateEvent\";i:43;s:9:\"viewEvent\";i:44;s:11:\"deleteEvent\";i:45;s:14:\"createEventday\";i:46;s:14:\"updateEventday\";i:47;s:12:\"viewEventday\";i:48;s:14:\"deleteEventday\";i:49;s:15:\"createEventtype\";i:50;s:15:\"updateEventtype\";i:51;s:13:\"viewEventtype\";i:52;s:15:\"deleteEventtype\";i:53;s:11:\"createOrder\";i:54;s:11:\"updateOrder\";i:55;s:9:\"viewOrder\";i:56;s:11:\"deleteOrder\";i:57;s:14:\"createCashbook\";i:58;s:14:\"updateCashbook\";i:59;s:12:\"viewCashbook\";i:60;s:14:\"deleteCashbook\";i:61;s:14:\"createCustomer\";i:62;s:14:\"updateCustomer\";i:63;s:12:\"viewCustomer\";i:64;s:14:\"deleteCustomer\";i:65;s:18:\"updateOrganisation\";i:66;s:13:\"updateProfile\";i:67;s:11:\"viewProfile\";}', '2019-05-09 22:00:00', 1, '2019-11-24 10:40:03', 1),
(2, 'Admin', 'a:32:{i:0;s:7:\"viewPos\";i:1;s:10:\"createUser\";i:2;s:10:\"updateUser\";i:3;s:8:\"viewUser\";i:4;s:15:\"createEventuser\";i:5;s:15:\"updateEventuser\";i:6;s:13:\"viewEventuser\";i:7;s:16:\"viewCashregister\";i:8;s:23:\"createEventcashregister\";i:9;s:23:\"updateEventcashregister\";i:10;s:21:\"viewEventcashregister\";i:11;s:13:\"createArticle\";i:12;s:13:\"updateArticle\";i:13;s:11:\"viewArticle\";i:14;s:12:\"viewCategory\";i:15;s:8:\"viewUnit\";i:16;s:18:\"createEventarticle\";i:17;s:18:\"updateEventarticle\";i:18;s:16:\"viewEventarticle\";i:19;s:9:\"viewEvent\";i:20;s:12:\"viewEventday\";i:21;s:11:\"createOrder\";i:22;s:11:\"updateOrder\";i:23;s:9:\"viewOrder\";i:24;s:14:\"createCashbook\";i:25;s:14:\"updateCashbook\";i:26;s:12:\"viewCashbook\";i:27;s:14:\"createCustomer\";i:28;s:14:\"updateCustomer\";i:29;s:12:\"viewCustomer\";i:30;s:13:\"updateProfile\";i:31;s:11:\"viewProfile\";}', '2019-05-09 22:00:00', 1, '2019-08-01 12:15:19', 1),
(3, 'Kassier', 'a:22:{i:0;s:7:\"viewPos\";i:1;s:8:\"viewUser\";i:2;s:15:\"createEventuser\";i:3;s:15:\"updateEventuser\";i:4;s:13:\"viewEventuser\";i:5;s:16:\"viewCashregister\";i:6;s:23:\"createEventcashregister\";i:7;s:23:\"updateEventcashregister\";i:8;s:21:\"viewEventcashregister\";i:9;s:11:\"viewArticle\";i:10;s:18:\"createEventarticle\";i:11;s:18:\"updateEventarticle\";i:12;s:16:\"viewEventarticle\";i:13;s:11:\"createOrder\";i:14;s:11:\"updateOrder\";i:15;s:9:\"viewOrder\";i:16;s:12:\"viewCashbook\";i:17;s:14:\"createCustomer\";i:18;s:14:\"updateCustomer\";i:19;s:12:\"viewCustomer\";i:20;s:13:\"updateProfile\";i:21;s:11:\"viewProfile\";}', '2019-05-09 22:00:00', 1, '2019-06-17 13:00:52', 1),
(4, 'Mitarbeiter', 'a:2:{i:0;s:13:\"updateProfile\";i:1;s:11:\"viewProfile\";}', '2019-05-09 22:00:00', 1, '2019-05-09 22:26:17', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kassa`
--

CREATE TABLE `kassa` (
  `id` int(11) NOT NULL,
  `bezeichnung` varchar(45) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellenstruktur für Tabelle `kassabuch`
--

CREATE TABLE `kassabuch` (
  `id` int(11) NOT NULL,
  `vorgang` int(11) DEFAULT NULL COMMENT '1...Ausgang, 2...Eingang',
  `buchungstext` varchar(300) DEFAULT NULL,
  `idFesttag` int(11) DEFAULT NULL,
  `idPerson` int(11) DEFAULT NULL,
  `buchungstyp` int(11) DEFAULT NULL COMMENT '1...Manuelle Eingabe, 2...Kellner, 3...Kasse, 4...Kunde',
  `summe` decimal(10,2) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Tabellenstruktur für Tabelle `kunde`
--

CREATE TABLE `kunde` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `vorname` varchar(45) DEFAULT NULL,
  `telefon` varchar(30) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tabellenstruktur für Tabelle `mitarbeiter`
--

CREATE TABLE `mitarbeiter` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `vorname` varchar(45) DEFAULT NULL,
  `geschlecht` int(11) DEFAULT NULL,
  `geburtsdatum` date NOT NULL,
  `telefon` varchar(30) DEFAULT NULL,
  `email` varchar(70) NOT NULL,
  `password` varchar(300) NOT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `createdBy` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Daten für Tabelle `mitarbeiter`
--

INSERT INTO `mitarbeiter` (`id`, `name`, `vorname`, `geschlecht`, `geburtsdatum`, `telefon`, `email`, `password`, `status`, `created`, `createdBy`, `updated`, `updatedBy`) VALUES
(1, 'Administrator', '', 1, '0000-00-00', NULL, 'admin@festverrechnung.at', '$2y$10$yfi5nUQGXUZtMdl27dWAyOd/jMOmATBpiUvJDmUu9hJ5Ro6BE5wsK', 1, '2019-05-09 22:00:00', 1, '2019-05-09 22:00:00', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `mitarbeiter_gruppe`
--

CREATE TABLE `mitarbeiter_gruppe` (
  `id` int(11) NOT NULL,
  `idMitarbeiter` int(11) DEFAULT NULL,
  `idGruppe` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Daten für Tabelle `mitarbeiter_gruppe`
--

INSERT INTO `mitarbeiter_gruppe` (`id`, `idMitarbeiter`, `idGruppe`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `organisation`
--

CREATE TABLE `organisation` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `addresse` varchar(255) DEFAULT NULL,
  `telefon` varchar(45) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `beschreibung` text DEFAULT NULL,
  `waehrung` varchar(255) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updatedBy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_artikel_artikelkategorie_idx` (`idArtikelkategorie`),
  ADD KEY `fk_artikel_artikeleinheit_idx` (`idArtikeleinheit`),
  ADD KEY `idx_bezeichnung` (`bezeichnung`);

--
-- Indizes für die Tabelle `artikeleinheit`
--
ALTER TABLE `artikeleinheit`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `artikelkategorie`
--
ALTER TABLE `artikelkategorie`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `buchung`
--
ALTER TABLE `buchung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_umsatzjournal_festtag_idx` (`idFesttag`),
  ADD KEY `fk_umsatzjournal_festmitarbeiter_idx` (`idPerson`);

--
-- Indizes für die Tabelle `buchung_festartikel`
--
ALTER TABLE `buchung_festartikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_buchArt_buchung_idx` (`idBuchung`),
  ADD KEY `fk_buchArt_artikel_idx` (`idFestartikel`);

--
-- Indizes für die Tabelle `fest`
--
ALTER TABLE `fest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_bezeichnung` (`bezeichnung`),
  ADD KEY `fk_fest_typ_idx` (`idFesttyp`);

--
-- Indizes für die Tabelle `festartikel`
--
ALTER TABLE `festartikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_festartikel_artikel_idx` (`idArtikel`),
  ADD KEY `fk_festartikel_festtag_idx` (`idFesttag`);

--
-- Indizes für die Tabelle `festfunktion`
--
ALTER TABLE `festfunktion`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `festkassa`
--
ALTER TABLE `festkassa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_festmitarbeiter_mitarbeiter_idx` (`idKassa`),
  ADD KEY `fk_festmitarbeiter_festtag_idx` (`idFesttag`);

--
-- Indizes für die Tabelle `festmitarbeiter`
--
ALTER TABLE `festmitarbeiter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_festmitarbeiter_mitarbeiter_idx` (`idMitarbeiter`),
  ADD KEY `fk_festmitarbeiter_festtag_idx` (`idFesttag`);

--
-- Indizes für die Tabelle `festtag`
--
ALTER TABLE `festtag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_festtag_fest_idx` (`idFest`);

--
-- Indizes für die Tabelle `festtyp`
--
ALTER TABLE `festtyp`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `gruppe`
--
ALTER TABLE `gruppe`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `kassa`
--
ALTER TABLE `kassa`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `kassabuch`
--
ALTER TABLE `kassabuch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_umsatzjournal_festtag_idx` (`idFesttag`),
  ADD KEY `fk_umsatzjournal_festmitarbeiter_idx` (`idPerson`);

--
-- Indizes für die Tabelle `kunde`
--
ALTER TABLE `kunde`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_name` (`name`);

--
-- Indizes für die Tabelle `mitarbeiter_gruppe`
--
ALTER TABLE `mitarbeiter_gruppe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mitben_ben_idx` (`idGruppe`),
  ADD KEY `fk_mitben_mit_idx` (`idMitarbeiter`);

--
-- Indizes für die Tabelle `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT für Tabelle `artikeleinheit`
--
ALTER TABLE `artikeleinheit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT für Tabelle `artikelkategorie`
--
ALTER TABLE `artikelkategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `buchung`
--
ALTER TABLE `buchung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1391;

--
-- AUTO_INCREMENT für Tabelle `buchung_festartikel`
--
ALTER TABLE `buchung_festartikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2565;

--
-- AUTO_INCREMENT für Tabelle `fest`
--
ALTER TABLE `fest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `festartikel`
--
ALTER TABLE `festartikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT für Tabelle `festfunktion`
--
ALTER TABLE `festfunktion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `festkassa`
--
ALTER TABLE `festkassa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `festmitarbeiter`
--
ALTER TABLE `festmitarbeiter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT für Tabelle `festtag`
--
ALTER TABLE `festtag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `festtyp`
--
ALTER TABLE `festtyp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `gruppe`
--
ALTER TABLE `gruppe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `kassa`
--
ALTER TABLE `kassa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `kassabuch`
--
ALTER TABLE `kassabuch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT für Tabelle `kunde`
--
ALTER TABLE `kunde`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `mitarbeiter`
--
ALTER TABLE `mitarbeiter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT für Tabelle `mitarbeiter_gruppe`
--
ALTER TABLE `mitarbeiter_gruppe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT für Tabelle `organisation`
--
ALTER TABLE `organisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
