Redovisning
====================================

Kmom01: Me-sida
------------------------------------
Oerhört intressant att börja programmera enligt MVC.


Som vanligt använder jag Sublime Text som min text editor, några plugins jag använder är SFTP, SublimeLinter och Emmet dock har jag ändrat färgtemat till vitt.

Google Chrome används flitigt som standard webläsare eftersom man alltid är inloggad på sitt google konto, bokmärken och historik sparas. Jag använder även 1Password som min lösenordshanterare.

Det var ganska mycket att läsa för att komma igång med detta kursmomentet. Väldigt många nya svåra ord att förstå exempelvis Lazy initialization, dependency injection och så vidare.


Problem med Me-sida fanns helt klart, MOS hade missat lite information på http://dbwebb.se/kunskap/bygg-en-me-sida-med-anax-mvc men jag lyckades lösa det själv.

Några exempel på missar:

1. Ingen stylsheet på navbar,

`löstes med: 'stylesheets' => ['css/style.css', 'css/navbar.css'] `

2. Använda URL_CLEAN

`löstes med: $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);`

Som tur är visade jag mos felen och bygg-en-me-sida är nu uppdaterad.
2014-04-03 (B, mos) Vy welcome/page blir me/page, ändra $url::URL_CLEAN till \Anax\Url\CUrl::URL_CLEAN samt style till navbaren.

Kursmoment 1 var inte särskilt svårt, det behövdes inte mycket kod för att implementera me-sidan. Det kändes skönt att behöva slippa skriva massa klasser och istället fokusera på mappstrukturen och hålla reda på alla miljontals filer.

Jag är helt klart nöjd med detta kursmoment. Man fick insyn på hur ett ramverk kan byggas upp och användas.

Tidigare erfarenheter av ramverk är null. Har självklart hört talas om de största Laravel, Code Igniter och så vidare.



Kmom02: Kontroller och modeller
------------------------------------

####Composer
Pakethanterare för PHP, helt klart intressant. Att lätt inkludera andras projekt är suveränt för en open-source programmerare.

####Packagist
Det finns miljontals paket på packagist, några intressanta jag hittade är [Twig](https://packagist.org/packages/twig/twig "Twig") och [phpunit](https://packagist.org/packages/phpunit/phpunit "phpunit").


####Problem
Många problem...

Anax-MVC var inte uppdaterat till senaste. Fick problem redan efter man hade kopierat vyerna. Fick göra en git clone och starta om från början. Mitt egna Git repository är nu helt meningslöst, tror att jag ska lösa det genom att forka från Mos istället för att bara kopiera det.

Ytterligare ett problem uppstår...

`(13:23:48) (@Olund) Bobbzorzen: vad fan är det för fel på kmom02`

Jag hade problem med att editera den första kommentaren, alla andra fungerade. ID blev fel? Efter många försök och ändringar i CommentController och CommentsInSession löstes problemet och jag blev överlycklig.

```
(14:18:37) (@Olund) Jag LÖSTE DET
(14:24:57) (@Bobbzorzen) Belöna dig själv med en chokladboll ;P
```
####Begrepp
Svårt var det. Svårt att förstå hur allt hänger ihop.
Att `<?=$this->url->create('comment/add')?>` mappas till addAction metoden i CommentController klassen var riktigt snyggt, fast svårt att jobba med.

####Svagheter/Förbättringar
Inga svagheter eller förbättringar jag kan säga just nu. Känner mig fortfarande väldigt novis i MVC.


####Tankar..
Onödigt att göra detta kursmomentet i sessions, tycker vi skulle kunna använda en databas direkt från början. Ingen annan kan se mina kommentarer just nu. Varför inte göra det korrekt från början....
Annars ett svårt men helt klart intressant kursmoment!



Kmom03: Bygg ett eget tema
------------------------------------
Äntligen klar med kursmoment 3. Massa pill för att få allting att fungera, tålamodet var rätt lågt vid flera tidpunkter.




####CSS-Ramverk
Jag har använt twitter bootstrap förut. Tycker det är kanon med ett CSS-ramverk för en som har noll talang i styling av hemsidor. Med bootstrap är det väldigt enkelt att komma igång och få det "snyggt". Dock kan hemsidor som använder bootstrap bli väldigt lika. En liten nackdel blir det när ett ramverk blir så stort så att de flesta hemsidor har liknande styling...


####LESS, lessphp och Semantic.gs
Lessphp är guds gåva. Att slippa behöva kompilera Less till Css själv var riktigt bekvämt. Om jag inte hade använt lessphp hade jag nog laddat ner ett plugin till sublime som kompilerar åt mig.
LESS var mycket roligare att arbeta i än CSS. Att kunna använda variabler, inbyggda funktioner (Lighten, Darken) var fantastiskt. Att CSS inte har implementerat det förut är väldigt konstigt.


####Font awesome, Bootstrap, Normalize
Som jag skrev ovan tycker jag bootstrap både är bra och dåligt. Boostrap använder sig av Normalize och även ett font paket (Glyphicons) som liknar Font Awesome.
Om man inte kan design, använd Font Awesome/Bootstrap och Normalize!

####Mitt tema

Ja.. Lånat lite, skrivit lite själv.
Som vanligt är det svårt att få till något bra designmässigt.
Jag ändrade navbaren, A, I, IMG länkar och la till så att man kunde lägga till styling på html och body taggarna.


####Tankar..

Det var jobbigt men även lärorikt kursmoment och jag har fått nya kunskaper som kommer garanterat användas. Speciellt Less känns riktigt bra att kunna.



Kmom04: Databasdrivna modeller
------------------------------------
Svårt kursmoment. Men nu förstår man helt klart bättre hur man ska jobba med Anax-MVC.

Pros:
    Äntligen använder vi en databas istället för session för kommentarer!
    Vi har en databas klass!
    Snyggare kommentarer
Cons:
    Blev ingen extra uppgift för min del.. Ingen tid eller ork, skulle vara jävligt trevligt att använda scaffolding i framtiden.

När man jobbade med Users kontrollern och modellen fick man verkligen upp ögonen hur allt hänger ihop..
Att urlen mappas till /users/list vid listAction() i kontrollern och att kontrollern styr hur modellen fungerar..
Ibörjan hade jag feting routes istället för att lägga in det i kontrollern. Blev nog så eftersom jag hade kollat på hur de andra hade implementerat det.
Men när jag pratade mos på torsdags-lektionen fick man upp ögonen att det skulle ligga i UserControllern istället och det blev helt klart mer logiskt.


####Problem:
Problem med initialize() metoden, förstod ej att den kallades automagiskt i början,
så i varje "action" metod kallade jag på this->initialize() när man ej behövde det.

Lite konstigt att båda ha inaktiv och soft deleted IMO.
Men förstår varför man har det, men jag skulle nog inte göra likadant på ett eget projekt eftersom båda blir nästan samma sak.
När en användare blir Inaktiv borde han även vara soft-deleted, så tänker jag.


Skulle skrivit såhär på alla actions.
Istället för att lägga all kod i if ($status === true)...
men har ingen ork till att ändra så jävla många...
```
 'submit' => [
    'type' => 'submit',
    'callback' => function ($form) {
    // Spara till databas
    $this->users->save([
        'acronym' => $form->Value('acronym'),
        'email' => $form->Value('email'),
        'name' => $form->Value('name'),
    ]);
    return true;


if ($status == true) {
    $url = $this->url->create('users/list');
    $this->response->redirect($url);
}

```


Felstavning vid CommentsController. Stavade utan s... Väldigt många kryptiska fel.. Dock blev felen lättare att läsa
när mos uppdaterade Anax med bättre exceptions?
```
$di->set('CommentsController', function () use ($di) {
    $controller = new \Anax\Comments\CommentsController();
    $controller->setDI($di);
    return $controller;
});
```



####Formulärhantering
CForm var väldigt trevlig att arbeta med, man skapade formulär väldigt enkelt och snabbt.
När syntaxen fastnade i huvudet skrev man formulär under minuten, väldigt stort +.

Den var lite jobbig med URLer, att man måste skriva med "https://" (http://website.com), att det inte räcker med "www.google.se"
blev man lite lack på. Så nu är URL inte ett måste att skriva när man skapar en ny kommentar.

####Databashanteringen
Smidigt till max, föredrar lätt denna arbetssättet istället för att skriva hela sql frågan förhand.


```
// Kan det bli lättare att skriva SQL-kod??? Jag tror inte det:)
$this->db->delete($this->getSource());
return $this->db->execute([]);
```

####Kommentarer i databasen.
Äntlige, ÄNTLIGEN. Slipper alla problem som sessioner inför..


Nu använder jag även  [Gravatar](http://sv.gravatar.com/) för att hämta bilder till kommentarer.



Kmom05: Bygg ut ramverket
------------------------------------

[Packagist](http://www.packagist.com/olund/flash)

[Github](http://www.github.com/olund/flash)

[Test av flash](http://www.student.bth.se/~heoa13/phpmvc/kmom05/webroot/flash)


####Inspiration och Utveckling av modul
Jag ville göra något snabbt och enkelt, valde därför en Flash modul.
Det blev inte många rader kod, vilket var skönt eftersom jag ligger lite efter i kursen.

Det var inga stora svårigheter att skapa denna modul.

Jag fick mest inspiration från http://docs.phalconphp.com/en/latest/reference/flash.html men även
https://github.com/nuvalis/mzFlash
https://github.com/kalkih/Flashy

När jag började med modulen glömde jag att den skulle upp på github.
Jag började att skapa min CFlash i Anax/src/Flash och valde att extenda CFlashBasic som redan fanns.
Ångrade mig senare eftersom jag aldrig använder något från CFlashBasic och det blev något fel med installtionen via Packagist.

Ville att man skulle skriva likadant som phalcon gör det: ```$app->flash->error('Error message');``` när man ville ha ett error meddelande
och då blev det 4 olika metoder som ser nästan exakt likadana ut. Alla metoder använder sig av en hjälp metod jag kallar ```setKey()```



####Publicera modulen
Det var inga problem med att publicera paketet på packagist. Packagist kontot kopplat till github och den hittade Flash modulen direkt.
Använde även Service hooks för att uppdatera packagist när man pushar till github. Fungerar utomordentligt.



####Testning och dokumentation
Problem under testningen blev det skrev lite om det under 'Problem'.
Jag har testat paketet med min fork av Anax-MVC och även mos version.
Med min fork var det 0 problem :)
Men med mos's repo krockade det lite. Det var någon Exception klass som klagade på att Flash inte hade en getMessage() metod, jag orkade inte sätta in mig varför den behövde det utan bara kommentarade ut den raden.
Då fungerade allt perfekt.

####Problem:

När jag skapade github repot använde jag fel mappstruktur och fick problem med att klassen aldrig laddades.
Detta löstes med att lägga till en src mapp.
Ändrade också namespace till olund/flash istället för anax/flash som jag körde med när jag utvecklade flash modulen.

Hade också problem med Packagist. När jag hämtade hem modulen med composer fick jag alltid hem den äldre versionen.
Tänkte att det bara tog lite tid för packagist att uppdatera, jag väntade hela dagen och försökte igen. Ingen förändring....
Problemet var composer.lock filen, jag körde en ```rm composer.lock```och allt löste sig.




####Tankar
Jag fick 10 (Very good) av scrutinizer.
Dock 5 minor errors.

```The call to the method olund\Flash\CFlash::setKey() seems useless as the method has no side-effects.```

Som jag förstår det är denna metoden värdelös enligt phpanalyzer. Detta beror på att den ändrar inga instance variabler eller liknande.
Dock är metoden private och ändrar ```$_SESSION['flash']``` och det är allt den behöver ändra enligt mig.

setKey() ser ut såhär:
```
private function setKey($key, $value)
{
    $_SESSION['flash'][] = [
        'type' => $key,
        'message' => $value,
    ];
}
```



Kmom06: Verktyg och CI
----------------------

###Introduktion:

I det här kursmomentet fick jag arbeta med grunder av automagisk testning och CI. Jag fick skriva testkod med PHPUnit och använda Scrutinzer för att få code quality och code coverage.
Jag arbetade även med Travis för att få till CI.

CFlash fick 10 i kvalité, Build passing och Code coverage på 98%.
Jag fick 10 på Quality, Build passing och Coverage på 98% enligt bilden
men enligt [scrutinzer](https://scrutinizer-ci.com/g/olund/Flash/code-structure/master/class/olund%5CFlash%5CCFlash) fick jag 100%.
Dock har jag 5 minor issues enligt scrutinizer, han tror min setKey method "seems useless", även fast den gör sitt jobb korrekt (sätter rätt session osv).


###Tidigare erfarenhet
Jag har ingen tidigare erfarenhet av testning eller Continous Intergration men har vetat att PHPUnit har funnits en bra stund.
GitHub arbetar jag bekvämt med, fast det blir nog lite googling när man får merge problem och liknande.



###Testfall med PHPUnit
Övningen hjälpte mig att komma igång med det uppstod väldigt många problem på kommandoraden.
Det uppstod problem med att ladda min CFlash klass och jag var helt säker på att jag hade gjort rätt, alla andra hade ju gjort likadant.
Problemet var att autoloadern inte registrerade mitt namespace.

Jag löste problemet med ```$prefix = 'olund\\';``` i autoloader filen.


Innan jag löste problemet var jag förbannad på att klassen aldrig laddades så jag använde istället
```require``` men denna lösningen var ej okej enligt mig. Om jag skulle testa flera filer vill man ju att dom ska laddas automagiskt med autoloadern..


Eftersom min CFlash innehåller väldig lite kod blev testfallen inte så långa heller.
Jag hade en metod som testade Clear metoden, en test metod som hämtade alla "flashar" och metod som hämtade med tomt resultat.

Jag tyckte det var ganska svårt att skriva testfall, men jag gillar tänket att skriva testfall även fast jag tycker det blir rätt svårt/tidskrävande.


###Travis
FYFAN vad det tog lång tid innan den uppdaterade. Jag blev helt ursinnig när jag skulle använda Travis, hade igång datorn hela natten men travis helvettet ville inte uppdatera sig. Efter 3e försöket blev det en build passed och känslan var gudomlig.
Här får man göra rätt från början, första försöket hade jag skrivit fel i ```.scrutinizer.yml```filen. Andra försökte lyckades jag med ```Job Cancelled``` eftersom det aldrig startade efter en ny commit och tredje försöket lyckades jag göra en ny commit
på github och Travis kördes automagist med en build passed.


###Scrutinzer
Enkelt och smidigt, som sagt fick jag 10 Quality och 98% på Code coverage. Inga problem här inte.



###Hur känns verktygen?
Jodå det känns bra, viktigt att kunna i framtiden när man kodar för ett företag.



Kmom07/10: Projekt och examination
-----------------------------------

Min webbplats kallar jag för LinuxQuestions eftersom den handlar om GNU/Linux frågor.

###Krav 1, 2, 3: Grunden
Det fanns väldigt många grundkrav och vissa var lätta och vissa svåra men definitivt tidskrävande. Det jobbigaste att implementera var kommentarer, vilket krävde väldigt många SQL-joins men jag löste det efter många timmar kodande.
Grundkraven kändes väldigt bra och relativa till projektet.


Användare hanteras med UserController som är en utbyggd version på det fjärde kursmomentets UserController, nu innehåller den flera nya actions som behövdes för grundkraven exempelvis updateAction, loginAction, logoutAction och profileAction.
Användare finns under [Users](http://www.student.bth.se/~heoa13/phpmvc/kmom07/webroot/users), användaren använder sig av en gravatar som profilbild och man kan bara uppdatera sin egna profil, UserContorller kollar om man är inloggad som profilen man kollar på.
Exempel: [Admins profil](http://www.student.bth.se/~heoa13/phpmvc/kmom07/webroot/users/profile/admin). UserControllern har rätt många actions som inte används just nu men som kan vara bra i framtiden för administrering av användare.
För inloggning har jag skapat en Authentication model som har metoder för att logga in, kolla om man är inloggad och logga ut. Denna model används i UserControllern för inloggningen ska fungera smärtfritt.
[Inloggning](http://www.student.bth.se/~heoa13/phpmvc/kmom07/webroot/users/login) finns längst upp i högra hörnet, [registrera användare](http://www.student.bth.se/~heoa13/phpmvc/kmom07/webroot/users/add) hittar man när man har tryckt på "Login" och trycker vidare på "Register here".


LinuxQuestions har en [framsida](http://www.student.bth.se/~heoa13/phpmvc/kmom07/webroot/) som visar det senaste frågorna, mest aktiva användarna och populära taggar och här används en dispatcher för att kalla på vissa actions från question och tag kontrollerna.
Den har också en sida för [frågor](http://www.student.bth.se/~heoa13/phpmvc/kmom07/webroot/questions), en sida för [taggar](http://www.student.bth.se/~heoa13/phpmvc/kmom07/webroot/tags) och en sida för [alla användare](http://www.student.bth.se/~heoa13/phpmvc/kmom07/webroot/users) och en [about sida](http://www.student.bth.se/~heoa13/phpmvc/kmom07/webroot/about).


Frågor, svar och kommentar hanteras av QuestionController och Question modellen.
Question modellen innehåller alla viktiga SQL-joins som behövs för att länka ihop frågor, svar och kommentarer.
Question-kontrollern byggdes från grunden och blev rätt lång eftersom den har många actions.


Taggar lösted med en Tag model och Tag controller. Taggarna läggs till när man skapar en fråga (kommaseparerade). Sedan görs det ett antal sträng funktioner i PHP för att kolla så att strängen inte innehåller onödiga tecken och är rätt skriven.
När jag lägger in taggarna i databasen kör jag även serialize på tagg arrayen för att enkelt lägga in arrayen i databasen. När man plockar ut taggarna blir den en unserialize.




###Sammanfattning:
Projektet var väldigt tidskrävande, väldigt mycket mer än vad jag hade räknat med. När jag insåg att man även behövde kommentarer insåg jag att detta var ett stort projekt. Det blev några dagars kodande, dygnade även två gånger för att hinna bli klar innan redovisningen.
Väldigt mycket databashantering i detta momentet och detta var väldigt svårt eftersom vi ej har gått någon databaskurs ännu. Känns väldigt bra att jag har arbetat med PHP och mysql innan, väldigt många SQL-joins krävdes för att få ihop allt...

Projektet var lagom svårt, dock för mycket mysql kunskaper krävdes enligt mig.

Jag gjorde ej några optionella krav eftersom min tidsplanering inte var den bästa. Om jag skulle hunnit skulle jag lätt kunnat implementera krav 4.



###Kursen
Oerhört intressant och utmanande kurs. Lätt den bästa jag har läst hittils.

Efter att ha läst HTMLPHP och OOPHP var denna kursen ett steg i rätt riktning, den var ett steg högre upp och kändes som en bra fortsättningskurs.
Kursen har handlat mest om MVC men även om testning, LESS, repsonsiv design samt alla program utanför vilket känns väldigt bra att kunna.
Väldigt bra lärare och bra föreläsningar. Dock lite jobbigt att Anax-MVC ej var fullständigt (lite buggigt) och det uppstår problem vid kodandet.

Ger denna kurs 10/10 toast.


[GitHub](https://github.com/olund/WGTOTW)
[Demo](http://www.student.bth.se/~heoa13/phpmvc/kmom07/webroot/)





