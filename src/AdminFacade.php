<?php

namespace Ashiful\Admin;

use Illuminate\Support\Facades\Facade;

class AdminFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'admin';
    }
}
