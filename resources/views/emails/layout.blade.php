<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
</head>
<body style="margin:0; padding:0; background-color:#f5f7fa; font-family:Arial,Helvetica,sans-serif; color:#2e3a4a;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f7fa; min-width:100%;">
        <tr>
            <td align="center" style="padding:30px 16px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:680px; background-color:#ffffff; border:1px solid #e4e7eb; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(46,58,74,0.08);">
                    <tr>
                        <td style="background-color:#2f64e9; padding:28px 30px; text-align:center; color:#ffffff;">
                            <h1 style="margin:0; font-size:24px; font-weight:700; letter-spacing:-0.5px;">{{ config('app.name') }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 30px 20px; line-height:1.6; font-size:16px; color:#2e3a4a;">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f6f8fb; padding:24px 30px; text-align:center; color:#68717b; font-size:14px;">
                            <p style="margin:0;">Merci de votre confiance,</p>
                            <p style="margin:4px 0 0; font-weight:700;">L'équipe {{ config('app.name') }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
