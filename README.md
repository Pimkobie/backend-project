Ticket Support System
Projectomschrijving

Dit project is een ticket support system waarmee gebruikers eenvoudig supporttickets kunnen aanmaken en beheren. Het systeem is bedoeld voor communities, bedrijven of game servers die hun support overzichtelijk willen regelen.

Met dit systeem kunnen gebruikers problemen melden of vragen stellen, terwijl medewerkers/admins de tickets kunnen bekijken, beantwoorden en afsluiten. Het doel van het systeem is om support sneller, overzichtelijker en efficiënter te maken.

Functionaliteiten
Gebruikers kunnen nieuwe tickets aanmaken
Tickets worden opgeslagen in een database
Overzicht van alle openstaande tickets
Mogelijkheid om tickets te beantwoorden
Tickets kunnen gesloten worden
Login- en registratiesysteem
Admin/support dashboard
Status van tickets bekijken (open/gesloten)

Installatie-instructies
1. Project downloaden

Clone of download het projectbestand naar je computer.

git clone [repository-link]

Of download de ZIP en pak deze uit.

2. Database importeren
Open phpMyAdmin
Maak een nieuwe database aan, bijvoorbeeld:
ticket_system
Importeer het meegeleverde .sql bestand:
Klik op de database
Ga naar Importeren
Selecteer het bestand database.sql
Klik op Start
3. Configuratie aanpassen

Open het configuratiebestand, bijvoorbeeld:

config.php

Pas hier de databasegegevens aan:

$host = "localhost";
$user = "root";
$password = "";
$database = "ticket_system";
4. Project starten

Plaats het project in de htdocs map van XAMPP of de www map van WAMP.

Start vervolgens:

Apache
MySQL

Open daarna in je browser:

http://localhost/projectnaam
Belangrijke mappen
/assets      -> CSS, afbeeldingen en JavaScript
/includes    -> Database connecties en functies
/pages       -> Pagina’s van het systeem
/database    -> SQL-bestand van de database
Technieken die zijn gebruikt
PHP → Backend
MySQL → Database
HTML → Structuur van de website
CSS → Styling
JavaScript → Interactieve functies
XAMPP → Lokale serveromgeving
Auteur

Gemaakt door Pim.
