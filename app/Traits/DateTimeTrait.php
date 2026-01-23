<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateTimeTrait
{
    public function secondsToYmd($seconds) {
        return Carbon::now()
            ->addSeconds($seconds)
            ->format('Y-m-d H:i:s');
    }
}

