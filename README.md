# booking-api

## Installation
- add booking-api.test domain to your Hosts file.
- Run `composer install`
- Copy `.env.example` to `.env` and fill the APP_KEY value by using `php artisan key:generate`
- Run docker by using `./vendor/bin/sail up` command
- Run `./vendor/bin/sail artisan migrate` to run all migrations
- Run database seeder `./vendor/bin/sail artisan seed --class=AdminUser` to create a basic Admin account (email: `admin@booking-api.test`, password: `secret`)

## Additional packages used
- Laravel Sail - used to provide Docker configuration.
- Laravel Sanctum - used to provide API Authorization and Authentication (all necesary endpoints like login/register and API Bearer Token auth).

## Tests
I've made feature tests for Booking and Vacancies endpoints. It will provide the good amount of test coverage.

## Used Solutions
- Authentication is made with Policies (different access to each endpoint according to user role in table column users.role and ownership; app\Policies).
- All request data is validated by Request validators (app\Http\Requests).
- Every response uses API Resource (app\Http\Resources) instead of default models.
- Services pattern was used to maintain low amount of code in Controllers and to gain more flexibility (app\Services). I've decided to drop my first idea of using Repository pattern as well because in that case it would be just an overkill, so I've left ORM queries in Services.
- Services are loaded in places like controllers etc. by using Dependency Injection.
- Some of more sophisticated Request Validators were made as custom ones, they are in \app\Rules.
- I've put @property for Models in class'es comment section for better code completion by PHP Storm.
- User Roles are stored as Enum instead of const (app\Enums)
- database foreign keys are defined in migration and in Models as well (relations).
## How to use API
There is a Postman collection file in repo to get full list of endpoints.
