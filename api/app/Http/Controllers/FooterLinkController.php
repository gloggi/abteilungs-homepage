<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFooterLinkRequest;
use App\Http\Requests\UpdateFooterLinkRequest;
use App\Models\FooterLink;
use Illuminate\Http\Request;

class FooterLinkController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('dashboard')){
            $perPage = $request->input('per_page', 10);
        }else{
            $perPage = $request->input('per_page', 100);
        }
        $footerLinks = FooterLink::orderBy('sort')->paginate($perPage);

        return response()->json($footerLinks);
    }

    public function store(StoreFooterLinkRequest $request)
    {
        $footerLink = FooterLink::create($request->validated());

        return response()->json($footerLink, 201);
    }

    public function show($id)
    {
        $footerLink = FooterLink::find($id);

        if (!$footerLink) {
            return response()->json(['message' => 'Footer link not found'], 404);
        }

        return response()->json($footerLink);
    }

    public function update(UpdateFooterLinkRequest $request, $id)
    {
        $footerLink = FooterLink::find($id);

        if (!$footerLink) {
            return response()->json(['message' => 'Footer link not found'], 404);
        }

        $footerLink->update($request->validated());

        return response()->json($footerLink);
    }

    public function destroy($id)
    {
        $footerLink = FooterLink::find($id);

        if (!$footerLink) {
            return response()->json(['message' => 'Footer link not found'], 404);
        }

        $footerLink->delete();

        return response()->json(null, 204);
    }
}
