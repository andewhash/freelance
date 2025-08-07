<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Response;
use Illuminate\Support\Facades\Storage;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = Response::with(['user', 'category', 'request'])
            ->where('user_id', auth()->user()->id)
            ->orderByDesc('id')
            ->get()
            ->sortByDesc('created_at');

        return view('seller.workplace', compact('responses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'text' => 'required|string',
            'title' => 'required|string|max:255',
            'count' => 'nullable|integer',
            'category' => 'required|exists:categories,id',
            'is_exists' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'request_id' => 'nullable|exists:requests,id',
        ]);

        $responseData = [
            'user_id' => $validatedData['user_id'],
            'text' => $validatedData['text'],
            'title' => $validatedData['title'],
            'count' => $validatedData['count'] ?? 0,
            'category' => $validatedData['category'],
            'is_exists' => $validatedData['is_exists'] ?? false,
            'request_id' => $validatedData['request_id'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/responses');
            $responseData['image_path'] = Storage::url($imagePath);
        }

        Response::create($responseData);

        return redirect()->back()->with('success', 'Response created successfully.');
    }

 
    public function update(Request $request, $id)
    {
        $response = Response::findOrFail($id);

        $validatedData = $request->validate([
            'text' => 'required|string',
            'title' => 'required|string|max:255',
            'count' => 'nullable|integer',
            'category' => 'required|exists:categories,id',
            'is_exists' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'request_id' => 'nullable|exists:requests,id',
        ]);

        $updateData = [
            'text' => $validatedData['text'],
            'title' => $validatedData['title'],
            'count' => $validatedData['count'] ?? 0,
            'category' => $validatedData['category'],
            'is_exists' => $validatedData['is_exists'] ?? false,
            'request_id' => $validatedData['request_id'] ?? null,
        ];

        if ($request->hasFile('image')) {
            if ($response->image_path) {
                $oldImagePath = str_replace('/storage', 'public', $response->image_path);
                Storage::delete($oldImagePath);
            }

            $imagePath = $request->file('image')->store('public/responses');
            $updateData['image_path'] = Storage::url($imagePath);
        }

        $response->update($updateData);

        return redirect()->back()->with('success', 'Response updated successfully.');
    }

    public function destroy($id)
    {
        $response = Response::findOrFail($id);

        if ($response->image_path) {
            $imagePath = str_replace('/storage', 'public', $response->image_path);
            Storage::delete($imagePath);
        }

        $response->delete();

        return redirect()->back()->with('success', 'Response deleted successfully.');
    }
}
