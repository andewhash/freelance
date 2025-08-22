<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Response;
use App\Models\Country;
use App\Models\Category;
use App\Models\File;
use App\Models\ResponseCountry;
use App\Models\ResponseCategory;
use App\Models\ResponseImage;
use Illuminate\Support\Facades\Storage;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = Response::with(['user', 'categories', 'countries', 'request', 'images'])
            ->where('user_id', auth()->user()->id)
            ->orderByDesc('id')
            ->get()
            ->sortByDesc('created_at');
        $categories = Category::getAllWithHierarchy();
        return view('seller.workplace', compact('responses', 'categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'text' => 'required|string',
            'title' => 'required|string|max:255',
            'count' => 'nullable|integer',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'countries' => 'required|array',
            'countries.*' => 'exists:countries,id',
            'is_exists' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'request_id' => 'nullable|exists:requests,id',
        ]);

        $responseData = [
            'user_id' => $validatedData['user_id'],
            'text' => $validatedData['text'],
            'title' => $validatedData['title'],
            'count' => $validatedData['count'] ?? 0,
            'is_exists' => $validatedData['is_exists'] ?? false,
            'request_id' => $validatedData['request_id'] ?? null,
        ];

        // Создаем отклик
        $response = Response::create($responseData);

        // Прикрепляем категории
        $response->categories()->sync($validatedData['categories']);

        // Прикрепляем страны
        $response->countries()->sync($validatedData['countries']);

        // Сохраняем изображения
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/responses');
                
                $file = File::create([
                    'name' => $image->getClientOriginalName(),
                    'path' => Storage::url($path),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                ]);

                ResponseImage::create([
                    'response_id' => $response->id,
                    'file_id' => $file->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Объявление успешно создано.');
    }

    public function update(Request $request, $id)
    {
        $response = Response::findOrFail($id);

        $validatedData = $request->validate([
            'text' => 'required|string',
            'title' => 'required|string|max:255',
            'count' => 'nullable|integer',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'countries' => 'required|array',
            'countries.*' => 'exists:countries,id',
            'is_exists' => 'nullable|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'request_id' => 'nullable|exists:requests,id',
        ]);

        $updateData = [
            'text' => $validatedData['text'],
            'title' => $validatedData['title'],
            'count' => $validatedData['count'] ?? 0,
            'is_exists' => $validatedData['is_exists'] ?? false,
            'request_id' => $validatedData['request_id'] ?? null,
        ];

        // Обновляем категории
        $response->categories()->sync($validatedData['categories']);

        // Обновляем страны
        $response->countries()->sync($validatedData['countries']);

        // Добавляем новые изображения
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/responses');
                
                $file = File::create([
                    'name' => $image->getClientOriginalName(),
                    'path' => Storage::url($path),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                ]);

                ResponseImage::create([
                    'response_id' => $response->id,
                    'file_id' => $file->id,
                ]);
            }
        }

        $response->update($updateData);

        return redirect()->back()->with('success', 'Объявление успешно обновлено.');
    }

    public function destroyImage($responseId, $imageId)
    {
        $image = ResponseImage::where('response_id', $responseId)
            ->where('file_id', $imageId)
            ->firstOrFail();

        // Удаляем файл из хранилища
        $path = str_replace('/storage', 'public', $image->path);
        Storage::delete($path);

        // Удаляем записи из БД
        $image->delete();

        return response()->json(['message'=> 'ok']);
    }

    public function getImages($id)
    {
        $response = Response::with('images')->findOrFail($id);
        $images = $response->images->map(function($image) {
            return [
                'id' => $image->id,
                'path' => $image->path
            ];
        });
        
        return response()->json($images);
    }

    public function destroy($id)
    {
        $response = Response::findOrFail($id);

        // Удаляем изображения
        foreach ($response->images as $image) {
            $path = str_replace('/storage', 'public', $image->path);
            Storage::delete($path);
            $image->delete();
        }

        $response->delete();

        return redirect()->back()->with('success', 'Объявление удалено.');
    }
}