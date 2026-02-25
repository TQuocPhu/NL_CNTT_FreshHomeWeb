<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Phản hồi liên hệ</title>
</head>

<body style="margin:0; padding:0; font-family: Arial, sans-serif; background-color:#f5f5f5;">
    <table width="100%" bgcolor="#f5f5f5" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="600" bgcolor="#ffffff" cellpadding="20" cellspacing="0"
                    style="margin-top:30px; border-radius:6px;">

                    <tr>
                        <td align="center" style="font-size:20px; font-weight:bold; color:#333;">
                            Phản hồi từ bộ phận hỗ trợ
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size:14px; color:#555;">
                            Xin chào <strong>{{ $contact->full_name ?? 'Quý khách' }}</strong>,
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size:14px; color:#555;">
                            Cảm ơn bạn đã liên hệ với chúng tôi. Dưới đây là phản hồi từ đội ngũ hỗ trợ:
                        </td>
                    </tr>

                    <tr>
                        <td
                            style="background:#f9f9f9; padding:15px; border-left:4px solid #007bff; font-size:14px; color:#333;">
                            
                            {!! $content !!}
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size:14px; color:#555;">
                            Nếu bạn còn bất kỳ câu hỏi nào, vui lòng phản hồi lại email này.
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size:12px; color:#999; text-align:center; padding-top:20px;">
                            © {{ date('Y') }} Fresh_Home. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>