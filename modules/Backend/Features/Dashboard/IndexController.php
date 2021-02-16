<?php

namespace Modules\Backend\Features\Dashboard;

use App\Controller;

/**
 * Handle dashboard requests
 * @package Modules\Backend
 */
class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->theme(__DIR__ . '/Views', 'dashboard');
        $this->authorized('backend');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->has('publisher')) {
            return redirect()->route('publisher.dashboard', $user->publisher->id);
        }

        return view('dashboard::index');
    }
}