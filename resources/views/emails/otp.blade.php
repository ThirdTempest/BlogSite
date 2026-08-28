<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification Code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f8fafc; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #1e293b;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; padding: 40px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 520px; background-color: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                    <!-- Header -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 32px 24px; color: #ffffff;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">BlogSite System</h1>
                            <p style="margin: 6px 0 0 0; font-size: 13px; color: #e0e7ff;">A Site with Good Security</p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 36px 32px;">
                            <h2 style="margin: 0 0 12px 0; font-size: 18px; font-weight: 700; color: #0f172a;">Hello, {{ $user->name }}!</h2>
                            <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #475569;">
                                Thank you for using BlogSite System. Please use the following 6-digit One-Time Password (OTP) to complete your verification and access your dashboard:
                            </p>

                            <!-- OTP Box -->
                            <div style="text-align: center; margin: 28px 0; padding: 20px; background-color: #f1f5f9; border: 2px dashed #6366f1; border-radius: 12px;">
                                <span style="font-size: 32px; font-weight: 800; letter-spacing: 8px; color: #4f46e5; font-family: monospace;">
                                    {{ $otp }}
                                </span>
                            </div>

                            <p style="margin: 0 0 16px 0; font-size: 13px; color: #64748b; text-align: center;">
                                ⏱️ This code will expire in <strong>10 minutes</strong>.
                            </p>

                            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 28px 0 20px 0;">

                            <p style="margin: 0; font-size: 12px; line-height: 1.5; color: #94a3b8;">
                                If you did not request this verification code, please ignore this email.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f8fafc; padding: 20px 32px; border-top: 1px solid #f1f5f9; font-size: 11px; color: #94a3b8;">
                            &copy; {{ date('Y') }} BlogSite System. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

