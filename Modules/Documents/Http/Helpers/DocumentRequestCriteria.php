<?php

namespace Modules\Documents\Http\Helpers;

use Prettus\Repository\Criteria\RequestCriteria;

class DocumentRequestCriteria extends RequestCriteria 
{
    /**
     * @param $search
     *
     * @return array
     */
    protected function parserSearchData($search)
    {
        $searchData = [];

        $search = $search['value'];

        if (stripos($search, ':')) {
            $fields = explode(';', $search);

            foreach ($fields as $row) {
                try {
                    list($field, $value) = explode(':', $row);
                    $searchData[$field] = $value;
                } catch (\Exception $e) {
                    //Surround offset error
                }
            }
        }

        return $searchData;
    }

    /**
     * @param $search
     *
     * @return null
     */
    protected function parserSearchValue($search)
    {
    	$search = $search['value'];

        if (stripos($search, ';') || stripos($search, ':')) {
            $values = explode(';', $search);
            foreach ($values as $value) {
                $s = explode(':', $value);
                if (count($s) == 1) {
                    return $s[0];
                }
            }

            return null;
        }

        return $search;
    }
}