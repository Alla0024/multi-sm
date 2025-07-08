<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateManufacturerRequest;
use App\Http\Requests\UpdateManufacturerRequest;
use App\Repositories\ManufacturerRepository;
use Flash;
use Illuminate\Http\Request;
use App\Models\Manufacturer;
class ManufacturerController extends AppBaseController
{
    /** @var ManufacturerRepository $manufacturerRepository*/
    private $manufacturerRepository;

    public function __construct(ManufacturerRepository $manufacturerRepo)
    {
        $this->manufacturerRepository = $manufacturerRepo;

        parent::__construct();
    }

    /**
     * Display a listing of the Manufacturer.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $query = Manufacturer::query();

        foreach ($request->all() as $key => $value) {
            if (in_array($key, ['_token', 'page', 'perPage'])) continue;
            if ($value === '' || $value === null) continue;
            $query->where($key, $value);
        }

        $manufacturers = $query->paginate($perPage);
        $vars['manufacturers'] = $manufacturers;
        $this->template = 'pages.manufacturers.index';
        return $this->renderOutput($vars);
    }

    /**
     * Show the form for creating a new Manufacturer.
     */
    public function create()
    {
        return view('pages.manufacturers.create');
    }

    /**
     * Store a newly created Manufacturer in storage.
     */
    public function store(CreateManufacturerRequest $request)
    {
        $input = $request->all();

        $manufacturer = $this->manufacturerRepository->create($input);

        Flash::success('Manufacturer saved successfully.');

        return redirect(route('pages.manufacturers.index'));
    }

    /**
     * Display the specified Manufacturer.
     */
    public function show($id)
    {
        $manufacturer = $this->manufacturerRepository->find($id);

        if (empty($manufacturer)) {
            Flash::error('Manufacturer not found');

            return redirect(route('manufacturers.index'));
        }

        return view('pages.manufacturers.show')->with('manufacturer', $manufacturer);
    }

    /**
     * Show the form for editing the specified Manufacturer.
     */
    public function edit($id)
    {
        $manufacturer = $this->manufacturerRepository->find($id);

        if (empty($manufacturer)) {
            Flash::error('Manufacturer not found');

            return redirect(route('pages.manufacturers.index'));
        }

        return view('pages.manufacturers.edit')->with('manufacturer', $manufacturer);
    }

    /**
     * Update the specified Manufacturer in storage.
     */
    public function update($id, UpdateManufacturerRequest $request)
    {
        $manufacturer = $this->manufacturerRepository->find($id);

        if (empty($manufacturer)) {
            Flash::error('Manufacturer not found');

            return redirect(route('pages.manufacturers.index'));
        }

        $manufacturer = $this->manufacturerRepository->update($request->all(), $id);

        Flash::success('Manufacturer updated successfully.');

        return redirect(route('pages.manufacturers.index'));
    }

    /**
     * Remove the specified Manufacturer from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $manufacturer = $this->manufacturerRepository->find($id);

        if (empty($manufacturer)) {
            Flash::error('Manufacturer not found');

            return redirect(route('pages.manufacturers.index'));
        }

        $this->manufacturerRepository->delete($id);

        Flash::success('Manufacturer deleted successfully.');

        return redirect(route('pages.manufacturers.index'));
    }
}
