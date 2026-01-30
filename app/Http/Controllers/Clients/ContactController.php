<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

use function Flasher\Toastr\Prime\toastr;

class ContactController extends Controller
{
    public function index()
    {
        return view('clients.pages.contact');
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric|digits_between:10,12',
            'message' => 'required|min:5'
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.digits_between' => 'Số điện thoại phải có từ 9 đến 12 chữ số.',
            'message.required' => 'Vui lòng nhập thông tin liên hệ',
            'message.min' => 'Thông tin liên hệ phải có ít nhất 5 kí tự',
        ]);

        Contact::create([
            'full_name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'message' => $request->message,
            'is_replied' => 0, //trạng thái trả lời: chưa trả lời
        ]);

        // toastr()->success('Cảm ơn bạn đã liên hệ với chúng tôi! Chúng tôi sẽ phản hồi sớm nhất có thể.');
        // return redirect()->back();

        return response()->json([
            'status' => true,
            'message' => 'Cảm ơn bạn đã liên hệ với chúng tôi! Chúng tôi sẽ phản hồi sớm nhất.'
        ]);
    }
}
