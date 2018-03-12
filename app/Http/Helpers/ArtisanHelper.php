<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\ArgvInput;
use App\StringOutput;
use Exception;

trait ArtisanHelper
{
	public static function run($command = null)
	{
		$tinker = ['tink', 'tinke', 'tinker'];
		try {           
			if (in_array($command, $tinker)) {
				return 'ERROR: Can\'t run Tinker.';				
			} else {				
				// Taken from https://github.com/laravel-admin-extensions/helpers/blob/master/src/Controllers/TerminalController.php
				Artisan::handle(new ArgvInput(explode(' ', 'artisan ' . trim($command))), $output = new StringOutput());
				return $output->getContent();
			}
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}     
}
