<?php
namespace App\Http\Helpers;
use \Illuminate\Support\Collection;
class CustomCollection extends Collection {
    /**
     * Converts array items to a collections recursively.
     * Usage: $collection = Collection::make($array)->collectArrayItems();
     *
     * @return mixed
     */
    public function collectArrayItems()
    {
        $this->each(function($item, $key) {
            if (is_array($item)) {
                $collection = self::make($item)->collectArrayItems();
                $this->put($key, $collection);
            }
        });
        return $this;
    }
}
