<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\File;
use Imagick;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\PdfToImage\Pdf as PdfToImage;

class FileController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        $files = File::paginate($perPage, ['*'], 'page', $page);
        $data = $files->items();
        $meta = [
            'current_page' => $files->currentPage(),
            'from' => $files->firstItem(),
            'last_page' => $files->lastPage(),
            'path' => $files->path(),
            'per_page' => $files->perPage(),
            'to' => $files->lastItem(),
            'total' => $files->total(),
        ];
        return response()->json([
            'data' => $data,
            'meta' => $meta
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf,ico',
            'category' => 'string|max:255'
        ]);

        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $category = $validatedData['category'];
        $filePath = 'public/uploads/' . $filename;

      
        Storage::disk('public')->putFileAs('uploads', $file, $filename);

      
        $fileUrl = Storage::url($filePath);

     
        $newFile = new File;
        $newFile->path = $fileUrl;
        $newFile->extension = $file->getClientOriginalExtension();
        $newFile->category = $category;


        if (in_array($newFile->extension, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
            $thumbnailPath = 'public/thumbnails/' . $filename;
            $thumbnail = Image::make($file)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnail->save(storage_path('app/' . $thumbnailPath));
            $newFile->thumbnail = Storage::url($thumbnailPath);
        } elseif ($newFile->extension === 'pdf') {
            $thumbnailPath = 'public/thumbnails/' . $filename . '.png';
            $pdf = new PdfToImage($file);
            $pdf->setResolution(72);
            $pdf->saveImage(storage_path('app/' . $thumbnailPath));
            $newFile->thumbnail = Storage::url($thumbnailPath);
        }

        $newFile->save();

        return response()->json(['message' => 'File uploaded successfully']);
    }

    public function show($id)
    {
        $file = File::findOrFail($id);
        return response()->json($file);
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);

        // Delete the file from the public disk
        Storage::disk('public')->delete($file->path);

        // Delete the thumbnail if it exists
        if ($file->thumbnail) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $file->thumbnail));
        }

        // Delete the File model
        $file->delete();

        return response()->json(['message' => 'File deleted successfully']);
    }

}