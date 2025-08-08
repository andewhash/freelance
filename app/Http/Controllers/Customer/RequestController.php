<?php 

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request as HttpRequest;
use App\Models\Request;
use App\Models\Country;
use App\Models\Category;
use App\Models\File;
use App\Models\RequestCountry;
use App\Models\RequestCategory;
use App\Models\RequestImage;
use Illuminate\Support\Facades\Storage;

class RequestController extends Controller
{
    public function index()
    {
        $requests = Request::with(['customer', 'categories', 'countries', 'images'])
            ->where('customer_id', auth()->id())
            ->orderByDesc('id')
            ->get()
            ->sortByDesc('created_at');

        return view('customer.workplace', compact('requests'));
    }

    public function store(HttpRequest $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'countries' => 'required|array',
            'countries.*' => 'exists:countries,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'nullable|numeric',
            'status' => 'nullable|string'
        ]);

        $requestData = [
            'customer_id' => auth()->id(),
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'] ?? 1,
            'country' => "1",
            'category' => '1',
            'status' => $validatedData['status'] ?? 'new'
        ];

        // Создаем заявку
        $newRequest = Request::create($requestData);

        // Прикрепляем категории
        $newRequest->categories()->sync($validatedData['categories']);

        // Прикрепляем страны
        $newRequest->countries()->sync($validatedData['countries']);

        // Сохраняем изображения
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/requests');
                
                $file = File::create([
                    'name' => $image->getClientOriginalName(),
                    'path' => Storage::url($path),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                ]);

                RequestImage::create([
                    'request_id' => $newRequest->id,
                    'file_id' => $file->id,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Заявка успешно создана.');
    }

    public function update(HttpRequest $request, $id)
    {
        $requestToUpdate = Request::where('customer_id', auth()->id())->findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'countries' => 'required|array',
            'countries.*' => 'exists:countries,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'nullable|numeric',
            'status' => 'nullable|string'
        ]);

        $updateData = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'] ?? 1,
            'status' => $validatedData['status'] ?? 'new',
            'country' => "1",
            'category' => '1',
        ];

        // Обновляем категории
        $requestToUpdate->categories()->sync($validatedData['categories']);

        // Обновляем страны
        $requestToUpdate->countries()->sync($validatedData['countries']);

        // Добавляем новые изображения
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('public/requests');
                
                $file = File::create([
                    'name' => $image->getClientOriginalName(),
                    'path' => Storage::url($path),
                    'mime_type' => $image->getMimeType(),
                    'size' => $image->getSize(),
                ]);

                RequestImage::create([
                    'request_id' => $requestToUpdate->id,
                    'file_id' => $file->id,
                ]);
            }
        }

        $requestToUpdate->update($updateData);

        return redirect()->back()->with('success', 'Заявка успешно обновлена.');
    }

    public function destroyImage($requestId, $imageId)
    {
        $image = RequestImage::where('request_id', $requestId)
            ->where('file_id', $imageId)
            ->firstOrFail();

        // Удаляем файл из хранилища
        $path = str_replace('/storage', 'public', $image->file->path);
        Storage::delete($path);

        // Удаляем записи из БД
        $image->delete();
        $image->file()->delete();

        return redirect()->back()->with('success', 'Изображение удалено.');
    }

    public function getImages($id)
    {
        $request = Request::with('images.file')->findOrFail($id);
        $images = $request->images->map(function($image) {
            return [
                'id' => $image->file_id,
                'path' => $image->file->path
            ];
        });
        
        return response()->json($images);
    }

    public function destroy($id)
    {
        $request = Request::where('customer_id', auth()->id())->findOrFail($id);

        // Удаляем изображения
        foreach ($request->images as $image) {
            $path = str_replace('/storage', 'public', $image->file->path);
            Storage::delete($path);
            $image->file()->delete();
        }

        $request->delete();

        return redirect()->back()->with('success', 'Заявка удалена.');
    }

    public function accept($requestId, $id)
    {
        $response = Response::where('request_id', $requestId)->findOrFail($id);
        $response->status = ResponseStatusEnum::CHECKED;
        $response->save();

        $chat = Chat::where('customer_id', auth()->id())
            ->where('request_id', $requestId)
            ->where('seller_id', $response->user_id)
            ->first();

        if (!$chat) {
            $chat = Chat::create([
                'customer_id' => auth()->id(),
                'seller_id' => $response->user_id,
                'request_id' => $response->request_id,
            ]);
        }

        ChatMessage::create([
            'chat_id' => $chat->id,
            'user_id' => auth()->id(),
            'message' => 'Добрый день! Ваш отклик на заявку: ' . $response->text .'.',
        ]);

        return response()->json(['status' => true]);
    }
}