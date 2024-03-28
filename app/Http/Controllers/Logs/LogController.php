<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Responsable\Logs\LogsIndexResponsable;

class LogController extends Controller
{
    public function index(LogsIndexResponsable $logsIndexResponsable)
    {
        return $logsIndexResponsable;
    }
}
