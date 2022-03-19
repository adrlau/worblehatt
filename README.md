# worblehatt

Beskrivelse
Programvareverkstedet har en rekke bøker, og en konstant tilstrøm av nye. Teoretisk sett skal disse ryddes og kategoriseres jevntlig, men da dette ikke gjøres ofte nok kan det være et varig strev å finne ut hvor bøker står til enhver tid. Styret har derfor tatt initiativ til å opprette et biblioteksystem for å systematisere bøkene. Prosjektet har fått navn Worblehat etter en bibliotekar i Terry Pratchetts discworld serie. Worblehatt har vært påbegynnt flere ganger opp gjennom historien uten å komme i noen form for funksjonell tilstand enda.
Funksjonalitet

forhåndskrav.
* postgresql
* python 3.x
* php (for webside integrering)

Høy prioritet:
    Bokdatabase med alle PVVs bøker må lages
    Bokdatabasebyggingsverktøy for å bygge bokdatabasen (sjekker online ISBN-database for informasjon om boken)
    Utlånsmuligheter på PVVs lokaler for eksempel gjennom Dibbler sin strekkodescanner

Lav prioritet:
    Utlånsmuligheter gjennom nettportal på PVVs nettsider
    Søkemuligheter gjennom en nettportal på PVVs nettsider

Database datafields.
    ISBN (faktisk eller pvv generert)
    Forfatter
    Tittel
    Utgivelsesår
    Antall sider
    Sjanger
    Språk
    Om boken er utlånbar
    Bruker som har lånt boken
    Dato på når boken ble lånt ut

Prosedyre for bokdatabasebygging
    Systematisk arbeid, hylle for hylle
    Tre bunker: "ikke scannet", "scannet" og "manuell innlegging"
    Scanning sjekker live om info kan hentes fra online database(r)
    Dersom finnes: legg i "scannet", ellers legg i "manuell innlegging"
    Legg inn manuelle bøker
    Sett tilbake i hyllen og fortsett til neste




