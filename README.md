# Polecenie
Zbuduj aplikację, która wyświetla artykuły na stronie internetowej w formie listy z możliwością podglądu całości artykułu.
Artykuły mają być przechowywane w bazie danych wraz z tytułem artykułu, datą dodania artykułu oraz datą ostatniej modyfikacji. Musimy pamiętać również o autorze artykułu. Artykułu mają mieć możliwość zawierania zdjęć, które autor może dodać przez stronę internetową - panel zarządzania - każdy autor ma mieć możliwość zalogowania do systemu i dodawania nowych artykułów, edycję oraz możliwość usuwania swoich prac. Dla każdego autora ma być wydzielony katalog na serwerze, w którym może on przechowywać swoje pliki z obrazami. Katalog ma być tworzony w momencie rejestracji autora w systemie. Nad całością działania systemu ma czuwać administrator, który może zablokować urzytkownika, może go odblokować, usunąć lub dodać i zatwierdzić zgłoszone rejestracje nowych user'ów

colors : https://coolors.co/631d76-9e4770-fbfbfb-2e2532-201a23

https://app.logo.com/dashboard/logo_dcba3dc6-b88a-4798-ae39-0348052407b1/your-logo-files


https://app.logo.com/dashboard/logo_dcba3dc6-b88a-4798-ae39-0348052407b1/your-logo-files


### Database creation code

~~~~sql 
CREATE TABLE users (
    userId int(20) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    userName varchar(128) NOT NULL,
    userPwd varchar(128) NOT NULL,
    userStatus ENUM("ACTIVE","TOAPPROVE","ADMIN","BLOCKED") DEFAULT "TOAPPROVE" NOT NULL,
    userArticlesIDs varchar(300),
    userFolder varchar(128)
);
~~~~

~~~~sql
CREATE TABLE articles (
  articleId int(30) PRIMARY KEY AUTO_INCREMENT NOT NULL ,
  articleAuthor varchar(100) NOT NULL,
  articleCreationDate varchar(30) NOT NULL,
  articleModificationDate varchar(30),
  articlePhoto varchar(100),
  articleTitle varChar(150),
  articleContent varchar(500)
)
~~~~