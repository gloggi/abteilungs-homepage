<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class MetaController extends Controller
{

    public function favicon()
    {
        $setting = Setting::with(['websiteIcon'])->findOrFail(1);
        if(!$setting->websiteIcon) {
            abort(404);
        }
        $path = str_replace("/storage/", "", $setting->websiteIcon->path);
        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }
    
        $file = Storage::disk('public')->get($path);
        $type = Storage::disk('public')->mimeType($path);
    
        return (new Response($file, 200))
                ->header('Content-Type', $type);
    }
}
