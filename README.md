## Install Projects 

# Backend :
create database on phpmyadmin with name 'ticketing'

copy env.exemple
```
cp env.exemple .env
```

replace in .env : 
```
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

with

```
DB_CONNECTION=sqlite <---- mysql
DB_HOST=127.0.0.1
DB_PORT= 8889 
DB_DATABASE=ticketing
DB_USERNAME=root <---- username for phpmyadmin
DB_PASSWORD= <---- your password for phpmyadmin
```

Then in the cmd, enter the backend folder and enter this command :
```cmd
composer install
```

then, make a migration :
```
php artisan migrate
```

then, make a Seeder:
```
php artisan db:seed --class=RolesSeeder
```
```
php artisan db:seed --class=StatusSeeder
```

Finally run server Laravel:
```
php artisan serve
```

# Frontend : 
in the cmd, enter a folder frontend and run this commande : 
```
npm i
```

Finnaly go to browser in http://localhost:3000
