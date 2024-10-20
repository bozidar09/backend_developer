<?php

namespace App\Services;

use App\Models\User;

class MembershipService
{
    private const PREFIX = 'user-';

    public function generate() 
    {
        $lastUserId = User::orderBy('id', 'desc')->first()->id ?? 0;

        $number = sprintf('%05d', ++$lastUserId);

        return self::PREFIX . $number;
    }
}