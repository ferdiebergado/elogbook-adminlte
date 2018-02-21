<?php  
namespace Modules\Documents\Http\Helpers;
Trait RequestParser
{
    // private $perPage;
    // public function __construct() {
    //     parent::__construct;
    //     $this->perPage = config('documents.perpage');
    // }
    /**
     * @param $search
     *
     * @return array
     */
    protected function getRequestLength($request)
    {
        $perPage = config('documents.perpage');
        $length = (integer) $request->length;
        if ($length) {
            $perPage = $length;
        }
        return $perPage;
    }
    protected function getRequestFields($request, $model)
    {
        if ($request->has('orderByMulti')) {
           $request = (string) $request->orderByMulti;
            $fields = explode(';', $request);
            $dirs = explode(';', $request);
            $i = 0;
            foreach($fields as $field) {
                $model->orderBy($field, $dirs[$i]);
                $i++;
            }
        } 
        if (empty($request->sortBy))  {
            $model = $model->latest('updated_at');
        }
        return $model;      
    }
}
