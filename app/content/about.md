Projektspecifikation
==================
Utveckla och leverera projektet enligt följande specifikationen. Saknas info i specen så kan du själv välja väg, dokumentera dina val i redovisningstexten.

De tre första kraven är obligatoriska och måste lösas för att få godkänt på uppgiften. De tre sista kraven är optionella krav. Lös de optionella kraven för att samla poäng och därmed nå högre betyg.

För allra högsta betyg krävs en allmänt god webbplats. Den skall vara både snygg, tilltalande, lättanvänd och felfri.

Varje krav ger max 10 poäng, totalt är det 60 poäng.

Krav 1, 2, 3: Grunden
----------------------

Webbsidan skall skyddas av inloggning. Det skall gå att skapa en ny användare. Användaren skall ha en profil som kan uppdateras. Användarens bild skall vara en gravatar.

Webbplatsen skall ha en förstasida, en sida för frågor, en sida för taggar och en sida för användare. Precis som Stack Overflow har. Dessutom skall det finnas en About-sida med information om webbplatsen och dig själv.

En användare kan ställa frågor, eller besvara dem. Alla inlägg som en användare gör kan kopplas till denna. Klickar man på en användare så ser man vilka frågor som användaren ställt och vilka frågor som besvarats.

En fråga kan ha en eller flera taggar kopplade till sig. När man listar en tagg kan man se de frågor som har den taggen. Klicka på en tagg för att komma till de frågor som har taggen kopplat till sig.

En fråga kan ha många svar. Varje fråga och svar kan i sin tur ha kommentarer kopplade till sig.

Alla frågor, svar och kommentarer skrivs i Markdown.

Förstasidan skall ge en översikt av senaste frågor tillsammans med de mest populära taggarna och de mest aktiva användarna.

Webbplatsen skall finnas på GitHub, tillsammans med en README som beskriver hur man checkar ut och installerar sin egen version.

Webbplatsen skall finnas i drift med innehåll på studentservern.

Krav 4: Frågor (optionell)
----------------------
Ett svar kan märkas ut som ett accepterat svar.

Varje svar, fråga och kommentar kan röstas på av användare med +1 (up-vote) eller -1 (down-vote), summan av en fråga/svar/kommentars rank är ett betyg på hur “bra” den var.

Svaren på en fråga kan sorteras och visas antingen enligt datum, eller rank (antalet röster).

Översikten av frågorna visar hur många svar en fråga har samt vilken rank.

Krav 5: Användare (optionell)
----------------------
Inför ett poängsystem som baseras på användarens aktivitet. Följande ger poäng:

Skriva fråga
Skriva svar
Skriva kommentar
Ranken på skriven fråga, svar, kommentar.
Summera allt och sätt det till användarens rykte.

Visa en översikt på användarens sida om all aktivitet som användaren gjort, dvs frågor, svar, kommentarer, antalet röstningar gjorda samt vilket rykte användaren har.

Du kan efter eget tycke modifiera reglerna för hur användarens rykte beräknas.

Krav 6: Valfritt (optionell)
----------------------
Förutsatt att du gjort krav 4 och 5 kan du använda detta krav som ett valfritt krav. Beskriv något som du gjort i uppgiften som du anser vara lite extra och berätta hur du löst det. Det kan vara en utseendemässig sak, eller en kodmässig sak. Den bör vara något som du lagt mer än 4-8h på.

Kanske har du kopplat ihop projektet på GitHub med Travis, Scrutinizer och använder PHPUnit? Kanske har du utvecklat en egen modul (utöver kmom05) som du publicerat på Packagist och som används i ditt projekt? Det finns mycket att tjäna poäng på när du nått ända hit.