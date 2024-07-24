<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Peres Bakeries Limited API v1",
 *      description="Peres Bakeries Limited API for managing daily transactons in bakery"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
}
