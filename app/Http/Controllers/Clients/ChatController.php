<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function fetchMessages(Request $request)
    {
        if (Auth::check()) {
            $msgs = ChatMessage::where('user_id', Auth::id())->orderBy('created_at')->get();
        } else {
            $token = $request->cookie('chat_token');
            $msgs = $token ? ChatMessage::where('guest_token', $token)->orderBy('created_at')->get() : collect();
        }
        return response()->json($msgs);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $userId = Auth::id();

        $guestToken = null;
        if (!$userId) {
            $guestToken = $request->cookie('chat_token');

            if (!$guestToken) {
                $guestToken = 'guest_' . Str::random(32);
                cookie()->queue(cookie('chat_token', $guestToken, 60 * 24 * 180)); //cookie tồn tại 180 ngày
            }
        }

        // lưu tin nhắn của user vào db
        $userMsg = ChatMessage::create([
            'user_id' => $userId,
            'guest_token' => $userId ? null : $guestToken,
            'sender' => 'user',
            'message' => $request->message,
        ]);

        // lấy sản phẩm
        $products = Product::where('stock', '>', 0)
            ->get(['name', 'price', 'unit', 'description'])
            ->map(function ($product) {
                return "{$product->name} - {$product->price} / {$product->unit}";
            })->toArray();

        $productList = implode("\n", $products);

        // $prompt = "Bạn là trợ lý bán hàng cho website bán rau củ, trái cây, thịt, cá và một số sản phẩm tiêu dùng. Dưới đây là danh sách một số sản phẩm hiện có: \n$productList\n
        //             Hãy trả lời ngắn gọn, trung thực, chỉ dùng thông tin trong danh sách sản phẩm nếu cần.";

        $prompt = "
            Bạn là Hệ thống hỗ trợ khách hàng về sản phẩm cho website FreshHome chuyên bán rau củ, trái cây, thịt cá và hàng tiêu dùng.
            
            Nếu khách hỏi về sản phẩm:
            - Chỉ cung cấp thông tin có trong danh sách.
            - Không chốt đơn.
            - Không hỏi mua.
            - Trả lời ngắn gọn, rõ ràng.
            - Nếu có nhiều sản phẩm thì cách nhau một dòng trống.
            
            Nếu khách giới thiệu tên hoặc hỏi bạn là ai:
            - Hãy trả lời thân thiện.
            - Giới thiệu bạn là Hệ thống hỗ trợ khách hàng về sản phẩm cho website FreshHome chuyên bán rau củ, trái cây, thịt cá và hàng tiêu dùng. Tôi có thể hỗ trợ cho bạn, bạn cần sản phẩm nào ?
            - Không nói về sản phẩm nếu khách không hỏi.
            
            Nếu khách nhắc tới vấn đề khác tư vấn sản phẩm và khác giới thiệu bản thân:
            - Hãy trả lời bạn chỉ hỗ trợ tư vấn sản phẩm, không hỗ trợ đặt hàng, chốt đơn, thanh toán.

            Không in đậm.
            Không dùng ký tự đặc biệt.
            Không thêm câu hỏi không cần thiết.
            
            Hiển thị sản phẩm theo format:
            
            Chào bạn, hiện tại cửa hàng có sản phẩm:
            
            Tên sản phẩm
            Giá: giá / đơn vị
            
            Danh sách sản phẩm hiện có:
            $productList
        ";

        // lấy lịch sử gần nhất
        $history = ChatMessage::query()
            ->where(function ($query) use ($userId, $guestToken) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('guest_token', $guestToken);
                }
            })
            ->latest()
            ->limit(6)
            ->orderBy('created_at', 'asc')->get();


        $contents = [];
        foreach ($history as $msg) {
            $contents[] = [
                "role" => $msg->sender === 'user' ? 'user' : 'model',
                "parts" => [["text" => $msg->message]],
            ];
        }

        // thêm contents mới của user
        $contents[] = [
            "role" => 'user',
            "parts" => [["text" => $request->message]],
        ];

        // Gọi API Gemini (Nếu không có google_gemini_api_key => fallback text)
        $apiReplyText = "Xin lỗi, hiện tại chatbox chưa được cấu hình";

        if (env('GOOGLE_GEMINI_API_KEY')) {
            try {
                $url_apikey = env('GEMINI_URL');
                $payload = [
                    "systemInstruction" => [
                        "parts" => [
                            ["text" => $prompt]
                        ]
                    ],
                    "contents" => $contents
                ];
                
                // Gọi API trả về
                /** @var Response $response */
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => env('GOOGLE_GEMINI_API_KEY'),
                ])->post($url_apikey, $payload);

                if ($response->successful()) {
                    $data = $response->json();
                    $apiReplyText = data_get($data, 'candidates.0.content.parts.0.text') ?? 'Xin lỗi, tôi chưa hiểu câu hỏi!';
                } else {
                    $apiReplyText = 'Xin lỗi, chatbox không thể xử lý lúc này';
                    Log::error('AI API error', ['response' => $response->json()]);
                }
            } catch (\Throwable $e) {
                Log::error('AI call error: ' . $e->getMessage());
                $apiReplyText = 'Xin lỗi, hiện tại không thể kết nối AI';
            }
        }

        $botMsg = ChatMessage::create([
            'user_id' => $userId,
            'guest_token' => $userId ? null : $guestToken,
            'sender' => 'bot',
            'message' => $apiReplyText,
        ]);

        return response()->json([
            'user' => $userMsg,
            'bot' => $botMsg,
        ]);
    }
}
