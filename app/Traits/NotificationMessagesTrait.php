<?php

namespace App\Traits;

use Carbon\Carbon;

trait NotificationMessagesTrait
{

    protected function addressCreatedMessage():array
    {
        return [
            'type' => 'Address Created',
            'details' => 'User Created a new address'
        ];
    }

    protected function addressUpdatedMessage():array
    {
        return [
            'type' => 'Address Updated',
            'details' => 'User Update a new address'
        ];
    }

    protected function addressDeletedMessage():array
    {
        return [
            'type' => 'Address Remove',
            'details' => 'User Remove the address new address'
        ];
    }
}

