<?php

namespace Modules\Setting\Features;

use Exception;
use App\Common\Controller;
use Illuminate\Http\Request;

/**
 * Handle setting requests
 * @package Modules\Backend
 */
class SettingController extends Controller
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
    protected $columns = ['name', 'format', 'value', 'status', 'updated'];

    /**
     * This is module name
     * 
     * @var string
     */
    protected $name = 'setting';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->theme(__DIR__ . '/Views', 'setting');
        $this->authorized('setting');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nodes = [];
        return view('setting::index', [
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
        return redirect()->route('settings.index');
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
            'format' => 'required',
            'value' => 'required',
            'status' => ['required', 'boolean'],
        ]);
        
        $setting = new Setting();
        $setting->fill($request->only($setting->getFillable()));
        $setting->save();

        return redirect()
            ->route('settings.index')
            ->with('success','Setting created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        return redirect()->route('settings.edit', $setting->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return view('setting::edit', ['node' => $setting]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'name' => 'required',
            'format' => 'required',
            'value' => 'required',
            'startup' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ]);

        $setting->fill($request->only($setting->getFillable()));
        $setting->save();

        $callback = $request->input('callback', route('settings.index'));

        return redirect($callback)
            ->with('success','Setting updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        if (request()->ajax()) {
            return [
                'code' => 200,
                'message' => 'Setting <strong>' . $setting->name . '</strong> deleted successfully'
            ];
        }

        return redirect()
            ->route('settings.index')
            ->with('success','Setting deleted successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($setting)
    {
        $setting = Setting::onlyTrashed()->where('_id', $setting)->first();

        if ($setting) {
            $setting->restore();
        }

        if (request()->ajax()) {
            return [
                'code' => 200,
                'message' => 'Setting <strong>' . $setting->name ?? '' . '</strong> restore successfully'
            ];
        }

        return redirect()->route('settings.index')->with('success', 'Setting restore successfully');
    }

    /**
     * Datatable ajax request
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax(SettingDataTable $datatable)
    {
        return $datatable->build()->toJson();
    }
}