<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirme seu email</title>
</head>
<body style="margin:0;padding:0;background-color:#f3f6fb;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
    @php
        $resolvedLogoUrl = !empty($logoUrl) ? $logoUrl : asset('images/camump-01.png');
    @endphp

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f6fb;padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td style="padding:28px 28px 12px 28px;text-align:center;background:linear-gradient(135deg,#f6f0ff,#efe7ff);">
                            <img src="{{ $resolvedLogoUrl }}" alt="{{ $appName }} logo" style="max-height:56px;width:auto;display:block;margin:0 auto 14px;">
                            <div style="margin-top:8px;font-size:14px;color:#4b5563;">Confirmação de email</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px;">
                            <p style="margin:0 0 16px 0;font-size:18px;line-height:1.4;font-weight:600;color:#111827;">
                                Olá, {{ $userName }}!
                            </p>

                            <p style="margin:0 0 14px 0;font-size:15px;line-height:1.6;color:#374151;">
                                Obrigado por se cadastrar no {{ $appName }}. Para ativar sua conta, confirme seu endereço de email.
                            </p>

                            <p style="margin:0 0 20px 0;font-size:14px;line-height:1.6;color:#4b5563;">
                                <strong>Email:</strong> {{ $userEmail }}
                            </p>

                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 0 20px 0;">
                                <tr>
                                    <td align="center" style="border-radius:10px;background-color:#2563eb;">
                                        <a href="{{ $verificationUrl }}" style="display:inline-block;padding:14px 22px;font-size:15px;font-weight:700;color:#ffffff;text-decoration:none;border-radius:10px;">
                                            Verificar email
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <div style="margin:0 0 16px 0;padding:12px 14px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;font-size:13px;color:#4b5563;line-height:1.6;">
                                Este link expira em <strong>{{ $expiresInHours }}h</strong> e pode ser usado apenas uma vez.
                            </div>

                            <p style="margin:0;font-size:13px;line-height:1.6;color:#6b7280;">
                                Se você não criou uma conta no {{ $appName }}, ignore este email.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:16px 28px 24px 28px;border-top:1px solid #f3f4f6;font-size:12px;color:#9ca3af;text-align:center;">
                            {{ $appName }} • Segurança de conta
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
