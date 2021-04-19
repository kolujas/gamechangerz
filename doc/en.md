<p  align="center"><a  href="https://laravel.com"  target="_blank"><img  src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"  width="400"></a></p>

-  [Installation](#installation)

## Installation
1. Clone the repository.
```
git clone https://github.com/kolujas/gamechangerz.git
```

2. Install **Laravel**
```
composer install
```

3. Init & install **submodules**
```
git submodule init
git submodule update
```

4. Import & extract the **seeders** from Google Driver *"seeders.rar"* into `database/seeders` 

5. Create the **database**

6. Migrate the **database** and its **seeders**
```
php artisan migrate --seed
```

7. Install **Laravel** passport
```
php artisan passport:install
```

8. Make the **storage** link
```
php artisan storage:link
```

9. Edit your *".env"* file (use *".env.example"* as template)
```
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=

MAIL_USERNAME=something
MAIL_PASSWORD=something

MP_APP_ID=
MP_APP_SECRET="something"

PASSPORT_PERSONAL_ACCESS_CLIENT_ID=1
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET="something"
```

10. Init the **server**
```
php artisan serve
```

Have fun **:D**