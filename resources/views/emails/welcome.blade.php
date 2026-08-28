<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to BlogSite System</title>
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
                            <h2 style="margin: 0 0 12px 0; font-size: 18px; font-weight: 700; color: #0f172a;">Welcome, {{ $user->name }}!</h2>
                            <p style="margin: 0 0 20px 0; font-size: 14px; line-height: 1.6; color: #475569;">
                                An administrator has created an account for you on <strong>BlogSite System</strong>. Here are your account details:
                            </p>

                            <!-- Credentials Box -->
                            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px 20px; margin: 20px 0;">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 13px; color: #334155;">
                                    <tr>
                                        <td style="padding: 6px 0; font-weight: 600; color: #64748b; width: 120px;">Email Address:</td>
                                        <td style="padding: 6px 0; font-weight: 700; color: #0f172a;">{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 6px 0; font-weight: 600; color: #64748b;">Assigned Role:</td>
                                        <td style="padding: 6px 0; font-weight: 700; color: #4f46e5; text-transform: uppercase;">{{ $user->role }}</td>
                                    </tr>
                                    @if($initialPassword)
                                        <tr>
                                            <td style="padding: 6px 0; font-weight: 600; color: #64748b;">Password:</td>
                                            <td style="padding: 6px 0; font-family: monospace; font-weight: 700; color: #0f172a;">{{ $initialPassword }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            <!-- Login Button -->
                            <div style="text-align: center; margin: 28px 0 20px 0;">
                                <a href="{{ route('login') }}" 
                                   style="display: inline-block; padding: 12px 28px; background-color: #4f46e5; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 700; border-radius: 10px; box-shadow: 0 2px 4px rgba(79, 70, 229, 0.3);">
                                    Log In to Your Account
                                </a>
                            </div>

                            <p style="margin: 20px 0 0 0; font-size: 12px; line-height: 1.5; color: #64748b; text-align: center;">
                                🔒 For security, you will receive a 6-digit One-Time Password (OTP) on login.
                            </p>

                            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 24px 0 16px 0;">

                            <p style="margin: 0; font-size: 11px; line-height: 1.5; color: #94a3b8;">
                                If you believe this account was created in error, please contact your system administrator.
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

