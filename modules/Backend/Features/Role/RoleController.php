<?php

namespace Modules\Backend\Features\Role;

use Perm;
use Exception;
use App\Common\Controller;
use Illuminate\Http\Request;

/**
 * Handle role requests
 * @package Modules\Backend
 */
class RoleController extends Controller
{
    /**
     * This is module name
     * 
     * @var string
     */
    protected $name = 'roles';

    /**
     * Create a new controller instance.
     * 
     * @todo Set component {view} folder here
     * @return void
     */
    public function __construct()
    {
        $this->theme(__DIR__ . '/Views', $this->name);
        $this->authorized('role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get roles from config
        $nodes = Role::all();

        // Rendering view
        return view('roles::index', compact('nodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            '_id' => 'required',
            'name' => 'required',
            'about' => 'required',
            'status' => ['required', 'boolean'],
        ]);

        try {
            Role::create($request->all());
        } catch(Exception $e) {
            return back()->withInput()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('roles.index')->with('success','Role created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles::show', [
            'node' => $role,
            'roles' => Perm::modules(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('roles::edit', [
            'node' => $role,
            'roles' => Perm::modules(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if ($request->has('perms')) {
            // Update role->perms data
            $bucket = [];
            foreach($request->input('perms', []) as $module => $perms) {
                foreach($perms as $perm => $value) {
                    $bucket[] = "{$module}.{$perm}";
                }
            }
            $role->update(['perms' => $bucket]);
        } else {
            // Update role data only
            request()->validate([
                'name' => 'required',
                'about' => 'required',
                'status' => ['required', 'boolean'],
            ]);

            $role->update($request->all());
        }

        return redirect()
            ->route('roles.index')
            ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success','Role deleted successfully');
    }
}