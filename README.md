# elogbook-adminlte
A document recording system made with Laravel 5.5 using Admin-LTE Template and custom datatables from AdminBSB.

## Installation
1. Clone the repository.

	`git clone https://github.com/ferdiebergado/elogbook-adminlte.git`

2. Setup .env.

	`mv .env.example .env`

3. Generate application key.

	`php artisan key:generate`

4. Install php dependencies.

	`composer install`

5. Install javascript libraries.

	`yarn`

6. Compile assets. 

	`yarn run dev`

7. Run migrations.

	`php artisan migrate`

8. Seed the documents database.

	`php artisan module:seed`

9. Start development server.

	`php artisan serve`

## Configuration

1. Edit config/app.php.

2. Modify CSV seeder files in Modules/Documents/Database/Seeder/csvs folder to match your needs then rerun the migrations and seeders.
## Credits
- [Admin-LTE](https://adminlte.io)
- [AdminBSB](https://gurayyarar.github.io/AdminBSBMaterialDesign/)
## License
This is open source software licensed under the [MIT LICENSE](LICENSE.md).
