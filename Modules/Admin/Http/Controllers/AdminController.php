<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Documents\Repositories\DocumentRepository;
use Modules\Documents\Repositories\TransactionRepository;

class AdminController extends Controller
{
    use \App\Http\Helpers\PhpConfig, \App\Http\Helpers\ArtisanHelper, \Modules\Documents\Http\Helpers\RequestParser;
    private $documents, $transactions;
    public function __construct(DocumentRepository $documents, TransactionRepository $transactions)
    {
        $this->documents = $documents;
        $this->transactions = $transactions;
    }
    public function documents()
    {
        $request = app()->make('request');
        // $model = $this->documents->with(['doctype', 'creator']);
        $perPage = $this->getRequestLength($request); 
        // $documents = $this->sortFields($request, $model)->paginate($perPage);
        $documents = $this->documents->with(['doctype', 'creator'])->paginate($perPage);
        if (request()->wantsJson()) {
            return response()->json([
                'draw' => $request->draw,
                'data' => $documents,
            ]);
        }
        return view('documents::index', compact('documents'));        
    }
    public function transactions()
    {
        $request = app()->make('request');
        $perPage = $this->getRequestLength($request); 
        // $transactions = $this->sortFields($request, $model)->paginate($perPage);
        $transactions = $this->transactions->with(['document', 'document.doctype', 'target_office'])->paginate($perPage);
        if (request()->wantsJson()) {
            return response()->json([
                'draw' => $request->draw,
                'data' => $transactions,
            ]);
        }
        return view('documents::.transactions.index', compact('transactions'));        
    }    
    public function info()
    {
        $phpinfo = $this->quick_dev_insights_phpinfo();
        return view('admin::info', compact('phpinfo'));
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function environment()
    {
        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel version',   'value' => app()->version()],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => array_get($_SERVER, 'SERVER_SOFTWARE')],
            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
            ['name' => 'Queue driver',      'value' => config('queue.default')],
            ['name' => 'Timezone',          'value' => config('app.timezone')],
            ['name' => 'Locale',            'value' => config('app.locale')],
            ['name' => 'Env',               'value' => config('app.env')],
            ['name' => 'URL',               'value' => config('app.url')],
        ];
        $composer = file_get_contents(base_path('composer.json'));
        $dependencies = json_decode($composer, true)['require'];
        // $devDeps = json_decode($composer, true)['require-dev'];
        // $dependencies = array_merge_recursive($deps, $devDeps);
        $package = file_get_contents(base_path('package.json'));
        $js = json_decode($package, true)['dependencies'];
        $devjs = json_decode($package, true)['devDependencies'];
        $packages = array_merge_recursive($devjs, $js);
        return view('admin::environment', compact('envs', 'dependencies', 'packages'));
    }      
    public function run_command(Request $request) 
    {
        $this->validate($request, [
            'command'   => 'string|nullable'
        ]);
        $command = $request->command;
        $output = '<p>&gt; artisan ' . $command . ' </p>' . $this->run((string) $command);
        if (request()->wantsJson()) {
            return [
                'data' => $output
            ];
        }
        return $output;
    }
}
