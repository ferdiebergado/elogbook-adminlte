<?php
namespace App\Http\ViewComposers;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
class VersionComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $version = '';
        $file = base_path('VERSION');
        if (file_exists($file)) {
            $version = Cache::remember('version', 60, function() use($file) {
                return '-' . file_get_contents($file);
            });
        }
        $view->with(compact('version'));
    }
}
