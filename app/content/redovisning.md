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

