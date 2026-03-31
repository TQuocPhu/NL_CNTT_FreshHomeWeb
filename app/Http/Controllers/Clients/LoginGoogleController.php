<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

use function Flasher\Toastr\Prime\toastr;

class LoginGoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            //lấy thông tin user từ google

            /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
            $driver = Socialite::driver('google');

            $googleUser = $driver->stateless()->user();

            //Tìm user trong database dựa trên google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                Auth::login($user);
                toastr()->success('Đăng nhập bằng google thành công');
                return redirect()->route('home');
            } else {
                $existingUser = User::where('email', $googleUser->getEmail())->first();

                if ($existingUser) {
                    $existingUser->update([
                        'google_id' => $googleUser->getId(),
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                    Auth::login($existingUser);
                } else {
                    //Tạo user mới hoàn toàn
                    $newUser = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password' => Hash::make(Str::random(19)),
                        'status' => 'active',
                        'role_id' => 3,
                        'avatar' => $googleUser->getAvatar(),
                    ]);
                    Auth::login($newUser);
                }

                toastr()->success('Đăng nhập bằng google thành công');
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            toastr()->error('Đăng nhập với google thất bại');
            return redirect()->route('login');
        }
    }
}
