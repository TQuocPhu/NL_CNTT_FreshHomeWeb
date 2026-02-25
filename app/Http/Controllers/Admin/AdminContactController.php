<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminContactController extends Controller
{
    //
    public function index()
    {
        $contacts = Contact::orderBy('is_replied')->orderByDesc('created_at')->paginate(20);
        return view('admin.pages.contacts', compact('contacts'));
    }

    public function replyContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id' => ['required', 'integer', 'exists:contacts,id'],
            'email'      => ['required', 'email'],
            'message'    => ['required', 'string', 'min:5', 'max:5000'],
        ], [
            'contact_id.required' => 'ID liên hệ là bắt buộc.',
            'contact_id.exists'   => 'Liên hệ không tồn tại.',
            'email.required'      => 'Email là bắt buộc.',
            'email.email'         => 'Email không đúng định dạng.',
            'message.required'    => 'Nội dung phản hồi không được để trống.',
            'message.min'         => 'Nội dung phải có ít nhất 5 ký tự.',
            'message.max'         => 'Nội dung tối đa không quá 5000 ký tự.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $contact = Contact::where('id', $request->contact_id)
            ->where('is_replied', 0)
            ->lockForUpdate()
            ->first();

        // Kiểm tra đã gửi phản hồi chưa
        if (!$contact) {
            return response()->json([
                'status'  => false,
                'message' => 'Liên hệ này đã được phản hồi hoặc không tồn tại.'
            ], 400);
        }


        //Kiểm tra email có khớp không
        if ($contact->email !== $request->email) {
            return response()->json([
                'status'  => false,
                'message' => 'Email không khớp với email của khách hàng.'
            ], 400);
        }

        try {

            DB::beginTransaction();

            Mail::send('admin.emails.reply-contact', [
                'content' => $request->message,
                'contact' => $contact
            ], function ($mail) use ($request) {
                $mail->to($request->email)
                    ->subject('Phản hồi liên hệ của khách hàng');
            });

            $contact->update([
                'is_replied' => 1,
                'replied_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Phản hồi qua email thành công.'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Reply contact mail error: ' . $e->getMessage());

            return response()->json([
                'status'  => false,
                'message' => 'Không thể gửi phản hồi lúc này. Vui lòng thử lại sau.'
            ], 500);
        }
    }
}
