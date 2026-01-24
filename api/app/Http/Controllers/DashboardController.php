<?php

namespace App\Http\Controllers;

use App\Models\Camp;
use App\Models\Event;
use App\Models\Group;
use App\Models\Location;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return response()->json([
            'pages' => Page::count(),
            'users' => User::count(),
            'groups' => Group::count(),
            'events' => Event::count(),
            'camps' => Camp::count(),
            'locations' => Location::count(),
        ]);
    }
}
