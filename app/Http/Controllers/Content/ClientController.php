<?php

namespace App\Http\Controllers\Content;

use App\Http\Requests\CreateClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ClientRepository;
use App\Helpers\ModelSchemaHelper;
use Illuminate\Http\Request;
use App\Models\Client;
use Flash;

class ClientController extends AppBaseController
{
    /** @var ClientRepository $clientRepository */
    private $clientRepository;

    public function __construct(ClientRepository $clientRepo)
    {
        parent::__construct();

        $this->clientRepository = $clientRepo;
    }

    /**
     * Display a listing of the Client.
     */
    public function index(Request $request)
    {
        $clients = $this->clientRepository->filterRows($request->all());

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Client::class
        ]);

        $this->template = 'pages.clients.index';

        return $this->renderOutput([
            'clients' => $clients,
            'fields' => $fields,
        ]);
    }


    /**
     * Show the form for creating a new Client.
     */
    public function create()
    {
        $this->template = 'pages.clients.create';

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Client::class
        ]);
        return $this->renderOutput([
            'fields' => $fields,
        ]);
    }

    /**
     * Store a newly created Client in storage.
     */
    public function store(CreateClientRequest $request)
    {
        $input = $request->all();

        $client = $this->clientRepository->save($input);

        Flash::success(__('common.flash_saved_successfully'));

        return redirect(route('clients.index'));
    }

    /**
     * Display the specified Client.
     */
    public function show($id)
    {
        $client = $this->clientRepository->findFull($id);

        if (empty($client)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('clients.index'));
        }

        $this->template = 'pages.clients.show';

        return $this->renderOutput(compact('client'));
    }

    /**
     * Show the form for editing the specified Client.
     */
    public function edit($id)
    {
        $client = $this->clientRepository->findFull($id);

        if (empty($client)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('clients.index'));
        }

        $fields = ModelSchemaHelper::buildSchemaFromModelNames([
            Client::class
        ]);

        $this->template = 'pages.clients.edit';

        return $this->renderOutput(compact('client', 'fields'));
    }

    /**
     * Update the specified Client in storage.
     */
    public function update($id, UpdateClientRequest $request)
    {
        $client = $this->clientRepository->find($id);

        if (empty($client)) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('clients.index'));
        }

        $client = $this->clientRepository->save($request->all(), $id);

        Flash::success(__('common.flash_updated_successfully'));

        if ($request->ajax()) {
            return redirect(route('clients.edit', $id));
        }

        return redirect(route('clients.index'));
    }

    /**
     * Remove the specified Client from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
//
    }
}
