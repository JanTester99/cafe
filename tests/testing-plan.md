# Testing plan

drink

- [x] czy drink ma cene ? **drink.getPrice**
- [x] czy cena drinku moze byc mniejsza od zero ?
- [x] czy drink ma czas wykonania ?  **drink.brewing time**
- [x] czy drink ma swoja nazwe ? **drink.name**

cli / api

- czy moge wyswietlic/pobrac liste drinkow/menu ?

user

- [x] czy user ma name ?

order

- [x] czy moge przypisac uzytkownika do zamowienia ?
- [x] czy zamowienie moze zawierac drink ?
- [x] czy zamowienie moze zawierac wiele drinkow ?
- [x] czy moge usunac drink z zamowienia
- [x] czy wartosc zamowienia odpowiada cenom drinkow ?
- [x] czy zamowienie jest domyslnie otwarte/niezrealizowane/niewyslane ( do wyboru )
- [x] czy moge wyslac zamowienie puste ?
- [x] czy moge wyslac zamowienie z drinkami ?
- [x] czy zmieni sie status wyslanego zamowienia ?

- [x] czy moge zrealizowac pozycje ( drink / job ) z zamowienia
- [x] czy moge pobrac ilosc napojow pozostalych do zrealizowania w zamowieniu ?
- [x] czy zamowienie ze zrealizowanymi pozycjami jest ukonczone / completed ?

CLI / API

- [ ] czy moge zobaczyc liste niezrealizowanych zamowien ?

manager

- [ ] czy zamowienie mozna zamienic na kolejke napojow do realizacji

worker

- [ ] czy parzenie kawy trwa tak dlugo jak zakladano ?
- [ ] czy zakonczenie parzenia skutkuje zmniejszeniem ilosci kaw w zamowieniu ?

event based

- [ ] czy wysylane jest powiadomienie/notifikacja/broadcast po zakonczonym zamowieniu ?
- [ ] czy wysylane jest powiadomienie do managera o gotowym zamowieniu do procesowania ?

