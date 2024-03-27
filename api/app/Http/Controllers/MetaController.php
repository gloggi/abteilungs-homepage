<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MetaController extends Controller
{
    public function favicon()
    {
        $setting = Setting::with(['websiteIcon'])->findOrFail(1);
        if (! $setting->websiteIcon) {
            abort(404);
        }
        $path = str_replace('/storage/', '', $setting->websiteIcon->path);
        if (! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('public')->get($path);
        $type = Storage::disk('public')->mimeType($path);

        return (new Response($file, 200))
            ->header('Content-Type', $type);
    }

    public function socialIcon()
    {
        $setting = Setting::with(['socialIcon'])->findOrFail(1);
        if (! $setting->socialIcon) {
            abort(404);
        }
        $path = str_replace('/storage/', '', $setting->socialIcon->path);
        if (! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('public')->get($path);
        $type = Storage::disk('public')->mimeType($path);

        return (new Response($file, 200))
            ->header('Content-Type', $type);

    }
}
