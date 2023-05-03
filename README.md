# Setting up

## 1. Install [XAMPP](https://www.apachefriends.org/download.html)
- Tick `MySQL`, `phpMyAdmin` and `Fake Sendmail`

## 2. Starting localhost + MySQL Server
- Open XAMPP Control Panel
- Click `Start` for Apache and MySQL

Only have to do this once:
- Click on `Config` for MySQL and select `my.ini`
- Amend `max_allowed_packet` to `max_allowed_packet=4M` (increases file upload size)

## 3. Running the app
- Move flicket source folder to `/xampp/htdocs` folder
- Webpage can be accessed via [localhost](http://localhost/flicket/)

## 4. Database Access/Creation
- Go to [phpMyAdmin](http://localhost/phpmyadmin/)
- Create a new database called `flicketdb`
- Click on `import` on the top bar
- Click `Choose File` and select the `.sql` files in `flicket/databaseInit` folder

## Done :)
