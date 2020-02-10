<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Repositories\TableRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class TableController extends AppBaseController
{
    /** @var  TableRepository */
    private $tableRepository;

    public function __construct(TableRepository $tableRepo)
    {
        $this->tableRepository = $tableRepo;
    }

    /**
     * Display a listing of the Table.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $tables = $this->tableRepository->indexTrans();

        return view('tables.index')
            ->with('tables', $tables);
    }

    /**
     * Show the form for creating a new Table.
     *
     * @return Response
     */
    public function create()
    {
        return view('tables.create');
    }

    /**
     * Store a newly created Table in storage.
     *
     * @param CreateTableRequest $request
     *
     * @return Response
     */
    public function store(CreateTableRequest $request)
    {
        $input = $request->all();

        $table = $this->tableRepository->create($input);

        Flash::success('Table saved successfully.');

        return redirect(route('tables.index',app()->getLocale()));
    }

    /**
     * Display the specified Table.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($locale,$id)
    {
        $table = $this->tableRepository->find($id);

        if (empty($table)) {
            Flash::error('Table not found');

            return redirect(route('tables.index',app()->getLocale()));
        }

        return view('tables.show')->with('table', $table);
    }

    /**
     * Show the form for editing the specified Table.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($locale,$id)
    {
        $table = $this->tableRepository->find($id);

        if (empty($table)) {
            Flash::error('Table not found');

            return redirect(route('tables.index',app()->getLocale()));
        }

        return view('tables.edit')->with('table', $table);
    }

    /**
     * Update the specified Table in storage.
     *
     * @param int $id
     * @param UpdateTableRequest $request
     *
     * @return Response
     */
    public function update($locale,$id, UpdateTableRequest $request)
    {
        $table = $this->tableRepository->find($id);

        if (empty($table)) {
            Flash::error('Table not found');

            return redirect(route('tables.index',app()->getLocale()));
        }

        $table = $this->tableRepository->update($request->all(), $id);

        Flash::success('Table updated successfully.');

        return redirect(route('tables.index',app()->getLocale()));
    }

    /**
     * Remove the specified Table from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($locale,$id)
    {
        $table = $this->tableRepository->find($id);

        if (empty($table)) {
            Flash::error('Table not found');

            return redirect(route('tables.index',app()->getLocale()));
        }
        $this->tableRepository->delete($id);

        Flash::success('Table deleted successfully.');

        return redirect(route('tables.index',app()->getLocale()));
    }
}
