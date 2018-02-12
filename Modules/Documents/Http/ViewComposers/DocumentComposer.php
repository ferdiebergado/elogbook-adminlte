<?php
namespace Modules\Documents\Http\ViewComposers;
use Illuminate\View\View;
use Modules\Documents\Entities\Document;
class DocumentComposer
{
    /**
     * The document Eloquent Model.
     *
     * @var Model
     */
    protected $documents;
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(Document $document)
    {
        // Dependencies automatically resolved by service container...
        $this->documents = $document;
    }
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (auth()->check()) {
            if (auth()->user()->role === 1) {
                $document_count = $this->documents->count();
            } else {
                $document_count = $this->documents->where('office_id', auth()->user()->office_id)->count();           
            }
            $view->with(compact('document_count'));
        }
    }
}
