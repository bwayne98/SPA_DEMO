<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Symfony\Component\Console\Output\Output;
// use Symfony\Component\Process\Exception\ProcessFailedException;
// use Symfony\Component\Process\Process;

class NewsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        system('python C:/Users/BM\Desktop/Laravel_project/SPA_DEMO/resources/py/main.py');  
    }
}
