## Нюансы по разворачиванию
1. Выполнить миграции базы данных:
```php 
    php artisan migrate
```
2. Выполнить посев начальных данных:
```php 
    php artisan db:seed
```
3. Установить зависимости:
```javascript 
    composer install
    npm install
```
4. Сбилдить frontend:
```javascript 
    npm run dev || npm run production
```
5. Для php тестов выполнить:
```php 
    vendor\bin\phpunits tests
```