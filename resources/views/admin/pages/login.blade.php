<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Admin | </title>

    <!-- Bootstrap -->
    <link href="{{  asset('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('assets/admin/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset('assets/admin/vendors/animate.css/animate.min.css')}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset('assets/admin/build/css/custom.min.css')}}" rel="stylesheet">
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form method="post" action="">
                        @csrf
                        <h1>Đăng nhập</h1>
                        <div>
                            <input type="email" class="form-control" name="email" placeholder="Email" required />
                        </div>
                        <div>
                            <input type="password" class="form-control" name="password" placeholder="Mật khẩu"
                                required />
                        </div>
                        <div>
                            <button type="submit" class="btn btn-default submit">Đăng nhập</button>
                        </div>

                        <br />

                        <div class="separator">
                            
                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1><i class="fa fa-paw"></i> Fresh_Home!</h1>
                                <p>©2026 All Rights Reserved. Fresh_Home! is a Bootstrap 4 template. Privacy and
                                    Terms</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</body>

</html>