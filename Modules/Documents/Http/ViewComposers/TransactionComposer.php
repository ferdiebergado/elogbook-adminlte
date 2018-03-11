<?php
namespace Modules\Documents\Http\ViewComposers;
use Illuminate\View\View;
use Modules\Documents\Entities\Transaction;
class TransactionComposer
{
    /**
     * The Transaction Eloquent Model.
     *
     * @var Model
     */
    protected $transactions;
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        // Dependencies automatically resolved by service container...
        $this->transactions = $transaction;
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
            $fields = [
                'id',
                'task',
                'pending',
                'office_id'
            ];
            $base = $this->transactions->where('office_id', auth()->user()->office_id)->get($fields);
            $transaction_pending = $base->where('pending', 1)->count();
            $transaction_received = $base->where('task', 'I')->where('pending', 0)->count();
            $transaction_released = $base->where('task', 'O')->where('pending', 0)->count();
            $transaction_count = $base->count();
            $view->with(compact('transaction_pending', 'transaction_received', 'transaction_released', 'transaction_count'));
        }
    }
}
