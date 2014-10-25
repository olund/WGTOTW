About
===============
A project in the course:
```Databasdrivna webbapplikationer med PHP och Model View Controller (MVC) (phpmvc / DV1486)```

Read more about the project [here](http://dbwebb.se/phpmvc-v2/kmom10).

The project is also on [github](https://github.com/olund/WGTOTW).


####Me
I'm the creator of this site, my name is Henrik Ölund

You can find me at:

- [github](https://github.com/olund/)
- [linkedin](https://www.linkedin.com/pub/henrik-%C3%B6lund/80/859/7a7)
- <mailto:henke.olund@gmail.com>
- #db-o-webb @ irc.bsnet.se (Olund)





Redovisning
------------------------
Kmom07/10: Projekt och examination

Min webbplats kallar jag för LinuxQuestions eftersom den handlar om GNU/Linux frågor.
Krav 1, 2, 3: Grunden

Det fanns väldigt många grundkrav och vissa var lätta och vissa svåra men definitivt tidskrävande. Det jobbigaste att implementera var kommentarer, vilket krävde väldigt många SQL-joins men jag löste det efter många timmar kodande.
Grundkraven kändes väldigt bra och relativa till projektet.
Användare hanteras med UserController som är en utbyggd version på det fjärde kursmomentets UserController, nu innehåller den flera nya actions som behövdes för grundkraven exempelvis updateAction, loginAction, logoutAction och profileAction.
Användare finns under Users, användaren använder sig av en gravatar som profilbild och man kan bara uppdatera sin egna profil, UserContorller kollar om man är inloggad som profilen man kollar på.
Exempel:Admins profil. UserControllern har rätt många actions som inte används just nu men som kan vara bra i framtiden för administrering av användare.
För inloggning har jag skapat en Authentication model som har metoder för att logga in, kolla om man är inloggad och logga ut.
Denna model används i UserControllern för inloggningen ska fungera smärtfritt.
Inloggning finns längst upp i högra hörnet,registrera användare hittar man när man har tryckt på "Login" och trycker vidare på "Register here".
LinuxQuestions har en framsida som visar det senaste frågorna, mest aktiva användarna och populära taggar och här används en dispatcher för att kalla på vissa actions från question och tag kontrollerna.
Den har också en sida för frågor, en sida för taggar och en sida för alla användare och en about sida.
Frågor, svar och kommentar hanteras av QuestionController och Question modellen.
Question modellen innehåller alla viktiga SQL-joins som behövs för att länka ihop frågor, svar och kommentarer.
Question-kontrollern byggdes från grunden och blev rätt lång eftersom den har många actions.
Taggar lösted med en Tag model och Tag controller.
Taggarna läggs till när man skapar en fråga (kommaseparerade).
Sedan görs det ett antal sträng funktioner i PHP för att kolla så att strängen inte innehåller onödiga tecken och är rätt skriven.
När jag lägger in taggarna i databasen kör jag även serialize på tagg arrayen för att enkelt lägga in arrayen i databasen.
När man plockar ut taggarna blir den en unserialize.

Sammanfattning:

Projektet var väldigt tidskrävande, väldigt mycket mer än vad jag hade räknat med. När jag insåg att man även behövde kommentarer insåg jag att detta var ett stort projekt. Det blev några dagars kodande, dygnade även två gånger för att hinna bli klar innan redovisningen. Väldigt mycket databashantering i detta momentet och detta var väldigt svårt eftersom vi ej har gått någon databaskurs ännu. Känns väldigt bra att jag har arbetat med PHP och mysql innan, väldigt många SQL-joins krävdes för att få ihop allt...
Projektet var lagom svårt, dock för mycket mysql kunskaper krävdes enligt mig.
Jag gjorde ej några optionella krav eftersom min tidsplanering inte var den bästa. Om jag skulle hunnit skulle jag lätt kunnat implementera krav 4.
Kursen

Oerhört intressant och utmanande kurs. Lätt den bästa jag har läst hittils.
Efter att ha läst HTMLPHP och OOPHP var denna kursen ett steg i rätt riktning, den var ett steg högre upp och kändes som en bra fortsättningskurs. Kursen har handlat mest om MVC men även om testning, LESS, repsonsiv design samt alla program utanför vilket känns väldigt bra att kunna. Väldigt bra lärare och bra föreläsningar. Dock lite jobbigt att Anax-MVC ej var fullständigt (lite buggigt) och det uppstår problem vid kodandet.
Ger denna kurs 10/10 toast.
GitHub Demo