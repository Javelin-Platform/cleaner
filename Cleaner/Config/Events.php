<?php

namespace Module\Cleaner\Config;

// Create CRON jobs for automatically sending emails and deleting carts
use App\Libraries\System\Events;

Events::on('cron_jobs', function ($jobs) {
    $jobs[] = [
        'interval' => 86400, // Every day
        'name' => 'Cleaner',
        'callback' => 'Module\Cleaner\Libraries\Cleaner::clean',
        'limiter' => 'maintenance_hours'
    ];

    return $jobs;
});