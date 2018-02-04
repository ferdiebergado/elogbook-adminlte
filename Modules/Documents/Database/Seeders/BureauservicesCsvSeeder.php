<?php

namespace Modules\Documents\Database\Seeders;

use Flynsarmy\CsvSeeder\CsvSeeder;
use Illuminate\Support\Facades\DB;

class BureauservicesCsvSeeder extends CsvSeeder {

	public function __construct()
	{
		$this->table = 'bureauservices';
		$this->filename = base_path().'/Modules/Documents/Database/Seeders/csvs/bureaus_service.csv';

	}

	public function run()
	{
		// Recommended when importing larger CSVs
		DB::disableQueryLog();

		// Uncomment the below to wipe the table clean before populating
		//DB::table($this->table)->truncate();

		parent::run();
	}
}
