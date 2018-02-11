<?php 
namespace App\Http\Helpers;
trait DateHelper
{
	protected function formatDates($date, $time)
    {
        $formatted = null;
        if (($date) && ($time)) {
            $formatted = (new \Carbon\Carbon($date . ' ' . $time))->toDateTimeString();
        }
        return $formatted;
    }
}
