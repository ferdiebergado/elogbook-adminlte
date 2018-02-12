# elogbook-adminlte
A document recording system made with Laravel 5.5 with Admin-LTE Template.

## Installation
1. Clone the repository.

	`git clone https://github.com/ferdiebergado/elogbook-adminlte.git`

2. Setup .env.

	`mv .env.example .env`

3. Generate application key.

	`php artisan key:generate`

4. Install php dependencies.

	`composer install`

5. Install javascript dependencies.

	`yarn`

6. Compile assets. 

	`yarn run dev`

7. Run migrations.

	`php artisan migrate && php artisan module:migrate Documents Users Auth`

8. Seed the document database.

	`php artisan module:seed Documents`

9. Start development server.

	`php artisan serve`

## Configuration

1. Edit config/app.php.

2. Modify CSV seeder files in Modules/Documents/Database/Seeder/csvs folder to match your needs then rerun the migrations and seeders.
