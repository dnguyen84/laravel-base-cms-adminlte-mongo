<?php

namespace Modules\Backend\Features\Perm;

use App\Common\Controller;

use Illuminate\Http\Request;

/**
 * Handle permission requests
 * @package Modules\Backend
 */
class PermController extends Controller
{

    /**
     * This is module name
     * 
     * @var string
     */
    protected $name = 'perms';
    
    /**
     * Create a new controller instance.
     * 
     * @todo Set component {view} folder here
     * @return void
     */
    public function __construct()
    {
        $this->theme(__DIR__ . '/Views', $this->name);
        $this->authorized('perm');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('perms::index', ['roles' => Perm::modules()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perms::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route(config('backend.route') . '.user.index')->with('success','User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($account)
    {
        return view('perms::show', compact('account'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($account)
    {
        return view('perms::edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $account)
    {
        return redirect()
            ->route(config('backend.route') . '.users.index')
            ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();

        return redirect()
            ->route(config('backend.route') . 'users.index')
            ->with('success','User deleted successfully');
    }
}