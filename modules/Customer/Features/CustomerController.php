<?php

namespace Modules\Customer\Features;

use Exception;
use App\Common\Controller;
use Illuminate\Http\Request;

/**
 * Handle setting requests
 * @package Modules\Backend
 */
class CustomerController extends Controller
{
    /**
     * Show datatable actions in header
     */
    protected $actions = true;

    /**
     * List query columns for datatable
     * 
     * @var array
     */
    protected $columns = ['name', 'email', 'username', 'nickname', 'updatedAt'];

    /**
     * This is module name
     * 
     * @var string
     */
    protected $name = 'sage.users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->theme(__DIR__ . '/Views', 'customers');
        $this->authorized('customer');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodes = [];
        return view('customers::index', [
            'actions' => $this->actions,
            'columns' => $this->columns,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('customers.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            '_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'nickname' => ['required'],
        ]);
        
        $customer = new Customer();
        $customer->fill($request->only($customer->getFillable()));
        $customer->save();

        return redirect()
            ->route('customers.index')
            ->with('success','customer created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        return redirect()->route('customers.edit', $setting->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        return view('customer::edit', ['node' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'nickname' => ['required'],
        ]);

        $customer->fill($request->only($customer->getFillable()));
        $customer->save();

        $callback = $request->input('callback', route('customers.index'));

        return redirect($callback)
            ->with('success','customer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        if (request()->ajax()) {
            return [
                'code' => 200,
                'message' => 'Setting <strong>' . $customer->name . '</strong> deleted successfully'
            ];
        }

        return redirect()
            ->route('customers.index')
            ->with('success','Customer deleted successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($customer)
    {
        $customer = Customer::onlyTrashed()->where('_id', $customer)->first();

        if ($customer) {
            $customer->restore();
        }

        if (request()->ajax()) {
            return [
                'code' => 200,
                'message' => 'Setting <strong>' . $customer->name ?? '' . '</strong> restore successfully'
            ];
        }

        return redirect()->route('settings.index')->with('success', 'Customer restore successfully');
    }

    /**
     * Datatable ajax request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax(CustomerDataTable $datatable)
    {
        return $datatable->build()->toJson();
    }
}