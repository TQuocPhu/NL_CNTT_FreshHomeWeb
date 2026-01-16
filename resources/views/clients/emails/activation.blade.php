<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kích hoạt tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 20px 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
        }
        p {
            color: #555;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            background: #3490dc;
            color: #fff !important;
            padding: 12px 20px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
        }
        .btn:hover {
            background: #2779bd;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Xin chào {{ $user->name }},</h2>
        <p>
            Cảm ơn bạn đã đăng ký tài khoản tại <strong>Website của chúng tôi</strong>.  
            Để hoàn tất quá trình đăng ký, vui lòng nhấn vào nút bên dưới để kích hoạt tài khoản.
        </p>

        <p style="text-align: center;">
            <a href="{{ url('/activate/' . $token) }}" class="btn">
                Kích hoạt tài khoản
            </a>
        </p>

        <p>Nếu bạn không đăng ký tài khoản, vui lòng bỏ qua email này.</p>

        <div class="footer">
            &copy; {{ date('Y') }} FreshHome. Mọi quyền được bảo lưu.
        </div>
    </div>
</body>
</html>