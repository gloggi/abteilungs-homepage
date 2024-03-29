<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DeployController extends Controller
{
    public function runCommands(Request $request)
    {
        $secretKey = $request->input('secret_key');

        if (strval($secretKey) !== strval(env('DEPLOYMENT_SECRET_KEY')) || env('DEPLOYMENT_SECRET_KEY') === null) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        Artisan::call('storage:link');
        Artisan::call('migrate', ['--force' => true]);

        if (env('SEED_DB') === true) {
            Artisan::call('db:seed', ['--force' => true]);
        }
        Artisan::call('thumbnails:copy');
        Artisan::call('settings:create');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');

        return response()->json(['message' => 'Deployed successfully'], 200);

    }
}
