## Нюансы по разворачиванию
1. Установить зависимости:
```javascript 
    composer install
    npm install
```
2. Выполнить миграции базы данных:
```php 
    php artisan migrate
```
3. Выполнить посев начальных данных:
```php 
    php artisan db:seed
```
5. Для php тестов выполнить:
```php 
    vendor\bin\phpunits tests
```