<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Verification</title>
    <style>
        body {
            font-family: 'Figtree', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            line-height: 1.6;
            color: #374151;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9fafb;
        }
        .container {
            background-color: white;
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
            margin-bottom: 24px;
            cursor: pointer;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
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
        }
        .content {
            font-size: 16px;
            margin-bottom: 24px;
        }
        .code-container {
            text-align: center;
            margin: 32px 0;
            padding: 24px;
            background: linear-gradient(135deg, #eff6ff 0%, #f3f4f6 100%);
            border-radius: 12px;
            border: 2px solid #3b82f6;
        }
        .code {
            font-size: 36px;
            font-weight: 700;
            color: #3b82f6;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            margin: 0;
        }
        .code-label {
            font-size: 14px;
            color: #6b7280;
            margin-top: 8px;
            font-weight: 500;
        }
        .warning {
            background-color: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 16px;
            margin: 24px 0;
        }
        .warning-text {
            color: #92400e;
            font-size: 14px;
            margin: 0;
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
        .button-container {
            text-align: center;
            margin: 32px 0;
        }
        .button {
            display: inline-block;
            padding: 16px 32px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.39);
            cursor: pointer;
        }
        .button:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        }
        @media (prefers-color-scheme: dark) {
            body { background-color: #111827; }
            .container {
                background-color: #1f2937;
                border-color: #374151;
            }
            .title, .logo-text { color: #f9fafb; }
            .subtitle, .content, .footer-text { color: #d1d5db; }
            .brand-name { color: #f9fafb; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <div class="logo-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" fill="white"/>
                    </svg>
                </div>
                <span class="logo-text">{{ config('app.name') }}</span>
            </div>
            <h1 class="title">Login to Your Account</h1>
            <p class="subtitle">Choose your preferred method</p>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            <p>You requested to log in to your account. You can use either method below:</p>
        </div>

        <!-- Method 1: Login Button -->
        <div class="button-container">
            <a href="{{ $loginUrl }}" class="button" style="color: white;">
                Click to Login
            </a>
        </div>

        <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 before:me-6 after:flex-[1_1_0%] after:border-t after:border-gray-200 after:ms-6 dark:text-gray-500 dark:before:border-gray-600 dark:after:border-gray-600" style="display: flex; align-items: center; text-transform: uppercase; font-size: 12px; color: #9ca3af; margin: 16px 0;">
            <span style="flex: 1; height: 1px; background-color: #e5e7eb; margin-right: 16px;"></span>
            Or enter this code
            <span style="flex: 1; height: 1px; background-color: #e5e7eb; margin-left: 16px;"></span>
        </div>
        
        <!-- Method 2: Verification Code -->
        <div class="code-container">
            <div class="code">{{ $code }}</div>
            <div class="code-label">6-Digit Code</div>
        </div>
        
        <div class="warning">
            <p class="warning-text">
                <strong>⏰ Time Sensitive:</strong> This login expires in 15 minutes for security reasons.
            </p>
        </div>
        
        <div class="content">
            <p>If you didn't request this login, please ignore this email and consider reviewing your account security settings.</p>
        </div>
        
        <div class="footer">
            <p class="footer-text">
                Thank you,<br>
                The <span class="brand-name">{{ config('app.name') }}</span> Team
            </p>
        </div>
    </div>
</body>
</html>