<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//define log
use Illuminate\Support\Facades\Log;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class LogController extends Controller
{
    //
    public function index()
    {

        
        
        //ambil data dari file log 15 terakhir dari channel error
        $logs = Log::channel('error')->getMonolog()->getHandlers()[0]->getFormatter()->formatBatch(Log::getMonolog()->getHandlers()[0]->getRecords(15));
        //kembalikan view dengan data error
        return view('logs', compact('logs'));
    }
}
