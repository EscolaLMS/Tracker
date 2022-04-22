# Tracker
[![swagger](https://img.shields.io/badge/documentation-swagger-green)](https://escolalms.github.io/Tracker/)
[![codecov](https://codecov.io/gh/EscolaLMS/Tracker/branch/main/graph/badge.svg?token=NRAN4R8AGZ)](https://codecov.io/gh/EscolaLMS/Tracker)
[![phpunit](https://github.com/EscolaLMS/Tracker/actions/workflows/test.yml/badge.svg)](https://github.com/EscolaLMS/Tracker/actions/workflows/test.yml)
[![downloads](https://img.shields.io/packagist/dt/escolalms/tracker)](https://packagist.org/packages/escolalms/tracker)
[![downloads](https://img.shields.io/packagist/v/escolalms/tracker)](https://packagist.org/packages/escolalms/tracker)
[![downloads](https://img.shields.io/packagist/l/escolalms/tracker)](https://packagist.org/packages/escolalms/tracker)

## What does it do
The package is used to track the api route.
Tracker is enabled by default and track routes with `/api/admin` prefix.
By default, `/api/admin/tracks/routes` is ignored. 

## Installing
- `composer require escolalms/tracker`
- `php artisan migrate`
- `php artisan db:seed --class="EscolaLms\Tracker\Database\Seeders\TrackerPermissionSeeder"`

## Configuration
You can configure this package by specifying keys in the .env file.
- `TRACKER_ENABLED` - enable or disable route tracking
- `TRACKER_ROUTE_PREFIX` - set tracked route prefix
- `TRACKER_CONNECTION` - database connection, by default `sqlite`

You can also use [facade](src/Facades/Tracker.php) to configure tracker.

```php
Tracker::disable();
Http::get('api/admin/example-route')
Tracker::enable();

... 

Tracker::ignoreUris(['api/admin/example-route']);
Http::get('api/admin/example-route')

... 

Tracker::prefix('api');
Http::get('api/example-route')
```

## Database
```
TrackRoutes - stores tracked routes
```

Table `track_routes` sample rows

| id | user\_id | path | full\_path | method | extra | created\_at | updated\_at |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | 2 | /api/admin/example-1 | /api/admin/example-1?key=value | GET | NULL | 2022-04-14 08:49:25 | 2022-04-14 08:49:25 |
| 2 | 33 | /api/admin/example-2 | /api/admin/example-2 | POST | NULL | 2022-04-14 08:49:25 | 2022-04-14 08:49:25 |

## Endpoints
[![swagger](https://img.shields.io/badge/documentation-swagger-green)](https://escolalms.github.io/Tracker/)

## Tests
Run `./vendor/bin/phpunit` to run tests. See [tests](tests) folder as it's quite good staring point as documentation appendix.

[![codecov](https://codecov.io/gh/EscolaLMS/Tracker/branch/main/graph/badge.svg?token=NRAN4R8AGZ)](https://codecov.io/gh/EscolaLMS/Tracker)
[![phpunit](https://github.com/EscolaLMS/Tracker/actions/workflows/test.yml/badge.svg)](https://github.com/EscolaLMS/Tracker/actions/workflows/test.yml)

## Permissions
Permissions are defined in [seeder](database/seeders/TrackerPermissionSeeder.php)
