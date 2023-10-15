<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Install project

Open project dir:
```php
cd laravel_project
```

Copy .env.example to .env:
```php
cp .env.example .env
```

Build docker containers:
```php
docker-compose up -d
```

Run project install command:
```php
make install
```

Configure npm:
```php
docker-compose run npm install
docker-compose -f docker-compose.yml run --publish 5173:5173 npm run build
```
Open project:
[localhost:8000](http://localhost:8000/)

## Enjoy!
