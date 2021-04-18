<p  align="center"><a  href="https://laravel.com"  target="_blank"><img  src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"  width="400"></a></p>

-  [Instalacion](#instalación)

## Instalación
1. Clone el repositorio.
```
git clone https://github.com/kolujas/gamechangerz.git
```

2. Instale **Laravel**
```
composer install
```

3. Inicie e isntale los **submódulos**
```
git submodule init
git submodule update
```

4. Importe y extraiga los **seeders** desde Google Driver *"seeders.rar"* en `database/seeders` 

5. Cree la **base de datos**

6. Mige la **se de datos** y sus **seeders**
```
php artisan migrate --seed
```

7. Instale el paquete **Laravel** passport
```
php artisan passport:install
```

8. Cree el enlace del **storage**
```
php artisan storage:link
```

9. Edite su archivo *".env"* (use *".env.example"* como plantilla)
```
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=

MAIL_USERNAME=algo
MAIL_PASSWORD=algo

MP_APP_ID=
MP_APP_SECRET="algo"

PASSPORT_PERSONAL_ACCESS_CLIENT_ID=1
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET="algo"
```

10. Init the **server**
```
php artisan serve
```

Diviertete **:D**