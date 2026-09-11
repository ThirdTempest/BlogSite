<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - BlogSite System</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1e293b;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; padding: 40px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 520px; background-color: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 32px 24px; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">BlogSite System</h1>
                            <p style="margin: 6px 0 0 0; font-size: 13px; color: #cbd5e1;">A Site with Good Security</p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 36px 32px;">
                            <h2 style="margin: 0 0 12px 0; font-size: 18px; font-weight: 700; color: #0f172a;">Hello, {{ $user->name }}!</h2>
                            <p style="margin: 0 0 20px 0; font-size: 14px; line-height: 1.6; color: #475569;">
                                You are receiving this email because we received a password reset request for your account on <strong>BlogSite System</strong>.
                            </p>

                            <!-- Reset Button -->
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ $resetUrl }}" 
                                   style="display: inline-block; padding: 13px 32px; background-color: #0f172a; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 700; border-radius: 10px; box-shadow: 0 3px 6px rgba(15, 23, 42, 0.2);">
                                    Reset Password
                                </a>
                            </div>

                            <p style="margin: 20px 0 0 0; font-size: 12px; line-height: 1.5; color: #64748b; text-align: center;">
                                ⏱️ This password reset link will expire in <strong>60 minutes</strong>.
                            </p>

                            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 26px 0 18px 0;">

                            <p style="margin: 0 0 12px 0; font-size: 11px; line-height: 1.5; color: #94a3b8;">
                                If you did not request a password reset, no further action is required and your password will remain unchanged.
                            </p>

                            <p style="margin: 0; font-size: 11px; line-height: 1.5; color: #94a3b8; word-break: break-all;">
                                If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:<br>
                                <a href="{{ $resetUrl }}" style="color: #4f46e5; text-decoration: underline;">{{ $resetUrl }}</a>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f8fafc; padding: 18px 32px; border-top: 1px solid #f1f5f9; font-size: 11px; color: #94a3b8;">
                            &copy; {{ date('Y') }} BlogSite System. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

