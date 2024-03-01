<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Imagick;
use ImagickPixel;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 100);
        $extensions = $request->input('extensions');
        $user = Auth::user();
        $query = File::orderBy("id", "desc");
        if (!$user->hasRole('admin')) {
            $query = $query->where('user_id', $user->id);
        }

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

        $fileData = $request->file('file');

        $filename = time() . '_' . rand() . '.' . $fileData->getClientOriginalExtension();
        $category = $validatedData['category'];
        $filePath = 'public/uploads/' . $filename;
        $name = implode('.', array_slice(explode('.', $fileData->getClientOriginalName()), 0, -1));
        $filePath = Storage::url($filePath);
        $user = Auth::user();
        $newFile = new File;
        $newFile->path = $filePath;
        $newFile->extension = $fileData->getClientOriginalExtension();
        $newFile->category = $category;
        $newFile->name = $name;
        $newFile->user_id = $user->id;

        $this->storeFileAndCreateThumbnail($fileData, $filename, $newFile);


        $newFile->save();

        return response()->json(['message' => 'File uploaded successfully']);
    }

    public function show($id)
    {
        $user = Auth::user();
        $file = File::findOrFail($id);
        if (!$user->hasRole('admin')) {
            if ($file->user_id !== $user->id) {
                return response()->json(['message' => 'You are not allowed to view this file'], 403);
            }
        }
        return response()->json($file);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'category' => 'string|max:255'
        ]);
        $fileData = $request->file('file');
        $file = File::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            if ($file->user_id !== $user->id) {
                return response()->json(['message' => 'You are not allowed to update this file'], 403);
            }
        }
        $file->update($validatedData);
        if ($fileData) {
            Storage::disk('public')->delete($file->path);
            if ($file->thumbnail) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $file->thumbnail));
            }
            $splitted = explode('/', $file->path);
            $filename = end($splitted);
            $this->storeFileAndCreateThumbnail($fileData, $filename, $file);


        }
        return response()->json(['message' => 'File updated successfully']);
    }

    public function destroy($id)
    {
        $file = File::findOrFail($id);
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            if ($file->user_id !== $user->id) {
                return response()->json(['message' => 'You are not allowed to delete this file'], 403);
            }
        }

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

    private function storeFileAndCreateThumbnail($fileData, $filename, $newFile)
    {
        Storage::disk('public')->putFileAs('uploads', $fileData, $filename);
        if (in_array($newFile->extension, ['jpg', 'jpeg', 'png', 'gif'])) {
            $thumbnailPath = 'public/thumbnails/' . $filename;
            $thumbnail = Image::make($fileData)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $thumbnail->save(storage_path('app/' . $thumbnailPath));
            $newFile->thumbnail = Storage::url($thumbnailPath);
        } elseif ($newFile->extension === 'pdf') {
            $thumbnailPath = 'public/thumbnails/' . $filename . '.png';

            $imagick = new Imagick();
            $imagick->setResolution(72, 72);

            $imagick->readImage($fileData . '[0]');
            if ($imagick->getImageWidth() > $imagick->getImageHeight()) {
                $imagick->rotateImage(new ImagickPixel('none'), -90);
            }

            $imagick->setImageFormat('png');

            $imagick->writeImage(storage_path('app/' . $thumbnailPath));


            $imagick->clear();
            $imagick->destroy();

            $newFile->thumbnail = Storage::url($thumbnailPath);
        } elseif ($newFile->extension === 'svg') {
            $newFile->thumbnail = $newFile->path;
        }
    }

}
