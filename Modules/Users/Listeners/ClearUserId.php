<?php

namespace Modules\Users\Listeners;

use Modules\Users\Events\UserAmended;
use Illuminate\Contracts\Cache\Repository;

class ClearUserId
{
    private $cache;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserAmended $event)
    {
        $this->cache->forget('user_by_id_' . $event->model->id);
        $this->cache->forget('users');
        $this->cache->forget('active_offices_count');
    }
}
