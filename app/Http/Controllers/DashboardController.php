<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AppBaseController;
use Lang;
use Alias;

class DashboardController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->template = 'pages.dashboard';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->renderOutput([]);
    }
}
