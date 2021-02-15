<?php

namespace Modules\ImportExport\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use DB;
use Hash;
use Modules\Products\Entities\Products;
use Modules\WareHouses\Entities\WareHouses;
use Modules\Suppliers\Entities\Suppliers;
use Modules\Category\Entities\Category;
use Modules\CMS\Entities\Permalink;
use Modules\Brands\Entities\Brands;
use Modules\Products\Entities\ProductsWarehouseStocks;
use Modules\Products\Entities\ProductImages;
use Modules\Stores\Entities\Stores;
//use Maatwebsite\Excel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ImportExportController extends Controller
{
    use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $moduleURL;
    private $viewDir;
    private $model;

    public function __construct(Request $request) {
        //parent::__construct($request);
        //$this->moduleURL = $this->adminURI . 'import/';
        //$this->viewDir = 'admin.import.';
    }


    public function index()
    {
        return view('importexport::.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable

    public function create()
    {
        return view('importexport::create');
    }
*/
    public function create() {
        return view('importexport::backend.add-edit')->with(array(
            //'adminURI' => $this->adminURI,
            'actionTxt' => 'Import',
            'isEdit' => FALSE,
            'action' => $this->moduleURL . 'save',
            'model' => new Products(),
        ));
    }

    public function save(Request $request) {
       //dd('sad');
       //dd($request->all());
        $redirectUrl = 'importexport';
        $request->validate([
            'import_file' => 'required'
        ]);

        $path = $request->file('import_file');
        $model = Excel::import(new ProductsImport(), $path);

        if ($model) {

            return redirect('admin/'.$redirectUrl)->with('success','Import successfully completed');
        }
        FlashMessage::set('error', 'Import has not been completed.');
        return redirect('admin/'.$redirectUrl)->withInput();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('importexport::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('importexport::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
