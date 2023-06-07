<?php

namespace App\Http\Controllers\Website;

use App\Entities\App;

use App\Entities\File;
use App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WebsiteController extends Controller
{
    protected $app;

    public function __construct(App $app) 
    {
    	$this->app = $app;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getApp()
    {
        $config = $this->app->first();
        $options = config('subscriber');
      
        return view('website.index', [
            'enableRegistration' => $config->register_enable,
            'options' => $options
        ]);
    }

}
