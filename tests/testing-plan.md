# Testing plan

drink

- [x] czy drink ma cene ? **drink.getPrice**
- [x] czy cena drinku moze byc mniejsza od zero ?
- [x] czy drink ma czas wykonania ?  **drink.brewing time**
- [x] czy drink ma swoja nazwe ? **drink.name**

user

- [x] czy user ma name ?

order

- [x] czy moge przypisac uzytkownika do zamowienia ?
- [x] czy zamowienie moze zawierac drink ?
- [x] czy zamowienie moze zawierac wiele drinkow ?sssssssss
- [x] czy moge usunac drink z zamowienia
- [x] czy wartosc zamowienia odpowiada cenom drinkow ?ssssssssssssssss
- [x] czy zamowienie jest domyslnie otwarte/niezrealizowane/niewyslane ( do wyboru )
- [x] czy moge wyslac zamowienie puste ?
- [x] czy moge wyslac zamowienie z drinkami ?
- [x] czy zmieni sie status wyslanego zamowienia ?

- [x] czy moge zrealizowac pozycje ( drink / job ) z zamowienia
- [x] czy moge pobrac ilosc napojow pozostalych do zrealizowania w zamowieniu ?
- [x] czy zamowienie ze zrealizowanymi pozycjami jest ukonczone / completed ?
- [x] czy zamowienie po utworzeniu zostaje zapisane
- [x] czy po zmianie zamowienie zostaje zaktualizowane
- [x] czy po utworzeniu zamowienia flagi odpowiadajace za status zostaja ustawione na false
- [x] czy mozna zrealizowac za duzo pozycji

CLI / API

- [x] czy moge wyswietlic/pobrac liste drinkow/menu ?
- [x] czy moge zobaczyc liste niezrealizowanych zamowien ?

manager

- [x] czy zamowienie mozna zamienic na kolejke napojow do realizacji

worker

- [x] czy parzenie kawy trwa tak dlugo jak zakladano ?
- [x] czy zakonczenie parzenia skutkuje zmniejszeniem ilosci kaw w zamowieniu ?

event based

- [x] czy wysylane jest powiadomienie/notifikacja/broadcast po zakonczonym zamowieniu ?
- [x] czy wysylane jest powiadomienie do managera o gotowym zamowieniu do procesowania ?
- [x] czy jest listener czekajacy na powiadomienie o gotowym zamowieniu ?
- [x] czy jest listener czekajacy na powiadomienie o skompletowanym zamowieniu ?

cake

- [x] do zamowienia mozna dodac ciasto
- [x] czy manager moze procesowac ciasto do workera ktory kroi ciasto
- [x] czy mozna przygotowac ciasto dla zamowienia

- [x] kawiarnia ma obslugiwac ciasta

questions

- [ ] czy zamowienie majace N kaw i M ciast zostanie zrealizowane w calosci N + M produktow

- [ ] czy payload z eventem zawiera name Usera
- [ ] czy payload do OrderUpdated zawiera nazwe wykonanej kawy / ciasta

