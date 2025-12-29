<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    /**
     * The controller uses the trait
     */
    use AuthorizesRequests, ValidatesRequests;
}
