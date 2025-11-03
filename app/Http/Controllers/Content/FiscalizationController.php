<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Flash;

class FiscalizationController extends AppBaseController
{
    /** @var ClientRepository $clientRepository */


    public function __construct()
    {
        parent::__construct();
    }


    public function index(Request $request)
    {
//
    }

    public function create()
    {

    }

    public function store(CreateClientRequest $request)
    {
//
    }

    public function show($id)
    {
//
    }

    public function edit($id)
    {
//
    }

    public function update($id, UpdateClientRequest $request)
    {
//
    }

    public function destroy($id)
    {
//
    }
}
