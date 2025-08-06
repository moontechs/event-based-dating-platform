<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Verification - {{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: #374151;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        .header {
            text-align: center;
            margin-bottom: 32px;
        }
        .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            text-decoration: none;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }
        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            text-decoration: none;
        }
        .title {
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 8px 0;
        }
        .subtitle {
            color: #6b7280;
            font-size: 16px;
            margin: 0;
            font-weight: 400;
        }
        .content {
            font-size: 16px;
            margin-bottom: 24px;
            color: #374151;
        }
        .content p {
            margin: 0 0 16px 0;
        }
        .content p:last-child {
            margin-bottom: 0;
        }
        .cta-button {
            text-align: center;
            margin: 32px 0;
        }
        .btn {
            display: inline-block;
            padding: 16px 32px;
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: #000000;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 14px 0 rgba(251, 191, 36, 0.4);
            transition: all 0.2s ease;
        }
        .btn:hover {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #000000;
            text-decoration: none;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 24px 0;
            font-size: 12px;
            color: #9ca3af;
            text-transform: uppercase;
            font-weight: 500;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }
        .divider::before {
            margin-right: 16px;
        }
        .divider::after {
            margin-left: 16px;
        }
        .verification-code {
            text-align: center;
            margin: 32px 0;
            padding: 24px;
            background: linear-gradient(135deg, #fef3c7 0%, #fbbf24 20%);
            border-radius: 12px;
            border: 2px solid #fbbf24;
        }
        .code {
            font-size: 36px;
            font-weight: 700;
            color: #92400e;
            letter-spacing: 8px;
            font-family: 'Courier New', 'Monaco', monospace;
            margin: 0 0 8px 0;
        }
        .code-label {
            font-size: 14px;
            color: #78350f;
            font-weight: 500;
            margin: 0;
        }
        .alert {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 16px;
            margin: 24px 0;
        }
        .alert-text {
            color: #92400e;
            font-size: 14px;
            margin: 0;
            font-weight: 500;
        }
        .alert-icon {
            display: inline-block;
            margin-right: 4px;
        }
        .footer {
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }
        .footer-text {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }
        .brand-name {
            font-weight: 600;
            color: #111827;
        }
        .security-note {
            margin-top: 24px;
            font-size: 14px;
            color: #6b7280;
            text-align: center;
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #111827;
            }
            .card {
                background-color: #1f2937;
                border-color: #374151;
            }
            .title,
            .logo-text {
                color: #f9fafb;
            }
            .subtitle,
            .content,
            .footer-text,
            .security-note {
                color: #d1d5db;
            }
            .brand-name {
                color: #f9fafb;
            }
            .divider::before,
            .divider::after {
                background: #374151;
            }
            .divider {
                color: #6b7280;
            }
            .footer {
                border-top-color: #374151;
            }
        }

        /* Email client compatibility */
        @media only screen and (max-width: 600px) {
            .email-container {
                padding: 10px;
            }
            .card {
                padding: 24px 20px;
            }
            .title {
                font-size: 24px;
            }
            .code {
                font-size: 28px;
                letter-spacing: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="card">
            <div class="header">
                <div class="logo">
                    <div class="logo-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" fill="#000"/>
                        </svg>
                    </div>
                    <span class="logo-text">{{ config('app.name') }}</span>
                </div>
                <h1 class="title">Welcome back!</h1>
                <p class="subtitle">Sign in to your account</p>
            </div>

            <div class="content">
                <p>Hello there,</p>
                <p>You requested to sign in to your {{ config('app.name') }} account. Click the button below for instant access, or use the verification code if you prefer.</p>
            </div>

            <!-- Primary CTA: Login Button -->
            <div class="cta-button">
                <a href="{{ $loginUrl }}" class="btn">
                    Sign In to Your Account
                </a>
            </div>

            <div class="divider">
                Or enter this verification code
            </div>

            <!-- Secondary Option: Verification Code -->
            <div class="verification-code">
                <div class="code">{{ $code }}</div>
                <div class="code-label">Your 6-Digit Code</div>
            </div>

            <div class="alert">
                <p class="alert-text">
                    <span class="alert-icon">⏰</span>
                    <strong>Time Sensitive:</strong> This verification expires in 15 minutes for security reasons.
                </p>
            </div>

            <div class="security-note">
                <p>If you didn't request this verification, please ignore this email and consider updating your account security settings.</p>
            </div>

            <div class="footer">
                <p class="footer-text">
                    Best regards,<br>
                    The <span class="brand-name">{{ config('app.name') }}</span> Team
                </p>
            </div>
        </div>
    </div>
</body>
</html>
