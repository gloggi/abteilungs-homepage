<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\File;
use Imagick;
use ImagickPixel;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\PdfToImage\Pdf as PdfToImage;

class FileController extends Controller
{

    public function index(Request $request)
{
    $perPage = $request->input('per_page', 100);
    $extensions = $request->input('extensions');
    $query = File::orderBy("id", "desc");

    if ($extensions) {
        $extensionsArray = explode(',', $extensions); 
        $query->whereIn('extension', $extensionsArray);
    }

    $files = $query->paginate($perPage);

    return response()->json($files);
}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf,ico,svg',
            'category' => 'string|max:255'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
        $category = $validatedData['category'];
        $filePath = 'public/uploads/' . $filename;
        $name = implode('.', array_slice(explode('.', $file->getClientOriginalName()), 0, -1));

     

        Storage::disk('public')->putFileAs('uploads', $file, $filename);


        $fileUrl = Storage::url($filePath);


        $newFile = new File;
        $newFile->path = $fileUrl;
        $newFile->extension = $file->getClientOriginalExtension();
        $newFile->category = $category;
        $newFile->name = $name;



        if (in_array($newFile->extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $thumbnailPath = 'public/thumbnails/' . $filename;
            $thumbnail = Image::make($file)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnail->save(storage_path('app/' . $thumbnailPath));
            $newFile->thumbnail = Storage::url($thumbnailPath);
        } elseif ($newFile->extension === 'pdf') {
            $thumbnailPath = 'public/thumbnails/' . $filename . '.png';

            $imagick = new Imagick();
            $imagick->setResolution(72, 72);

            $imagick->readImage($file . '[0]');
            if ($imagick->getImageWidth() > $imagick->getImageHeight()) {
                $imagick->rotateImage(new ImagickPixel('none'), -90);
            }

            $imagick->setImageFormat('png');

            $imagick->writeImage(storage_path('app/' . $thumbnailPath));

            
            $imagick->clear();
            $imagick->destroy();

            $newFile->thumbnail = Storage::url($thumbnailPath);
        } elseif ($newFile->extension === 'svg') {
            $newFile->thumbnail = $fileUrl;
        }

        $newFile->save();

        return response()->json(['message' => 'File uploaded successfully']);
    }

    public function show($id)
    {
        $file = File::findOrFail($id);
        return response()->json($file);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'category' => 'string|max:255'
        ]);
        $file = File::findOrFail($id);
        $file->update($validatedData);
        return response()->json(['message' => 'File updated successfully']);
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