<?php

use App\Providers\AppServiceProvider;
use App\Providers\BroadcastServiceProvider;

return [
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    AppServiceProvider::class,
    BroadcastServiceProvider::class,
];
