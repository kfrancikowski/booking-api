# booking-api

## Installation
- Add booking-api.test domain to your Hosts file.
- Clone the repository
- Go to project folder and run `composer install`
- Copy `.env.example` to `.env`
- Run docker by using `./vendor/bin/sail up` command. Add -d for detached mode.
- Run `./vendor/bit/sail artisan key:generate` to fill APP_KEY in .env file.
- Run `./vendor/bin/sail artisan migrate` to run all migrations.
- Run database seeder `./vendor/bin/sail artisan seed --class=AdminUser` to create a basic Admin account (email: `admin@booking-api.test`, password: `secret`).
- To receive a token to use in Postman for admin or client you need to use Authentication/IssueToken endpoint to login and receive a token (3 fields are required: email, password and device_name).

## Additional packages used
- Laravel Sail - used to provide Docker configuration.
- Laravel Sanctum - used to provide API Authorization and Authentication (all necesary endpoints like login/register and API Bearer Token auth).

## Tests
I've made feature tests for Booking and Vacancies endpoints, written in PHP Unit. It will provide the good amount of test coverage. To run the tests you can use a Laravel command: `./vendor/bin/sail artisan test` 

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
- Login to admin account by using Authentication/IssueToken endpoint and save the token to collection variables as adminToken.
- You will also need an account with Client role to perform booking. To make this account you can use Authentication/Register endpoint and then receive a token using Authentication/IssueToken endpoint. Save it to collection variables as userToken.
- First you have to set some vacancies. To do it use API CRUD in Vacancies collection. Each vacancy period have date_from, date_to, price and number_of_vacancies fields. Vacancies can't overlap each other.
- Then you can use:
  - Bookings/Calendar Info to get informations what days are available to book, how much do they cost and how many vacancies are available each day.
  - Bookings/Store to put a booking for specific days. It require Client account and two fields: date_from and date_to. As the result you will receive an information about booking with price and other basic informations.
  - Bookings/Destroy to cancel your booking. Client can cancel only own bookings.

