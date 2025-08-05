<?php
namespace App\Http\Controllers;

use App\Enum\Response\ResponseStatusEnum;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Request;
use App\Models\Response;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function index()
    {
        $requests = Request::query()->orderByDesc('id')->get()->sortByDesc('created_at');

        return view('customer.workplace', compact('requests'));
    }

    public function create()
    {
        return view('customer.createRequest'); // Страница для создания заявки
    }

    public function store(HttpRequest $request)
    {
        Request::create(array_merge($request->all(), ['customer_id' => auth()->id(), 'price' => 1])); // Сохраняем заявку
        return redirect()->route('customer.requests.index');
    }

    public function edit($id)
    {
        $request = Request::where('customer_id', auth()->id())->findOrFail($id); // Находим заявку для редактирования
        return view('customer.editRequest', compact('request'));
    }

    public function update(HttpRequest $request, $id)
    {
        $requestToUpdate = Request::where('customer_id', auth()->id())->findOrFail($id);
        $requestToUpdate->update($request->all()); // Обновляем заявку
        return redirect()->route('customer.requests.index');
    }

    public function destroy($id)
    {
        $request = Request::where('customer_id', auth()->id())->findOrFail($id);
        $request->delete(); // Удаляем заявку
        return redirect()->route('customer.requests.index');
    }

    // Метод для получения откликов на заявку
    public function responses(Request $request)
    {
        $responses = $request->responses()->where('status', ResponseStatusEnum::ACTIVE)->with('user')->get();
        return response()->json(['responses' => $responses]);
    }

    public function accept($requestId, $id)
    {
        $response = Response::where('request_id', $requestId)->findOrFail($id);

        $response->status = ResponseStatusEnum::CHECKED;

        $response->save();

        $chat = Chat::where('customer_id', auth()->id())->where('request_id', $requestId)->where('seller_id', $response->user_id)->first();

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
