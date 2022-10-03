#Testing plan

drink

- czy drink ma cene ? **drink.getPrice**
 - czy cena drinku moze byc mniejsza od zero ? 
- czy drink ma czas wykonania ?  **drink.brewing time**
- czy drink ma swoja nazwe ? **drink.name**

cli / api

- czy moge wyswietlic/pobrac liste drinkow/menu ? 

user

- czy user ma name ? 

order

- czy moge przypisac uzytkownika do zamowienia ?
- czy zamowienie moze zawierac drink ? 
- czy zamowienie moze zawierac wiele drinkow ?
- czy moge usunac drink z zamowienia
- czy wartosc zamowienia odpowiada cenom drinkow ?
- czy zamowienie jest domyslnie otwarte/niezrealizowane/niewyslane ( do wyboru )
- czy moge wyslac zamowienie puste ? 
- czy moge wyslac zamowienie z drinkami ? 
- czy zmieni sie status wyslanego zamowienia ? 

- czy moge zrealizowac pozycje ( drink / job ) z zamowienia
- czy moge pobrac ilosc napojow pozostalych do zrealizowania w zamowieniu ?
- czy zamowienie ze zrealizowanymi pozycjami jest ukonczone / completed ?

CLI / API

- czy moge zobaczyc liste niezrealizowanych zamowien ? 

manager

- czy zamowienie mozna zamienic na kolejke napojow do realizacji

worker

- czy parzenie kawy trwa tak dlugo jak zakladano ?
- czy zakonczenie parzenia skutkuje zmniejszeniem ilosci kaw w zamowieniu ?

event based

- czy wysylane jest powiadomienie/notifikacja/broadcast po zakonczonym zamowieniu ?
- czy wysylane jest powiadomienie do managera o gotowym zamowieniu do procesowania ?

