<?php

namespace App\Http\Controllers;

use App\Traits\FileManagementTrait;
use App\Traits\ResponseJsonTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ResponseJsonTrait, FileManagementTrait;
}
