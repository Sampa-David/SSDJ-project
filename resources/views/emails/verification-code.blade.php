<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f5f5f5;">
    <div style="background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #333; margin: 0; font-size: 28px;">{{ $appName }}</h1>
            <p style="color: #666; margin: 10px 0 0 0; font-size: 14px;">Verify Your Email Address</p>
        </div>

        <!-- Main Content -->
        <div style="margin-bottom: 30px;">
            <p style="color: #333; font-size: 16px; line-height: 24px; margin: 0 0 20px 0;">
                Hello,
            </p>
            
            <p style="color: #666; font-size: 16px; line-height: 24px; margin: 0 0 20px 0;">
                Thank you for signing up! To complete your registration and verify your email address, please use the verification code below:
            </p>

            <!-- Verification Code Box -->
            <div style="background-color: #f0f0f0; border: 2px solid #007bff; border-radius: 6px; padding: 20px; text-align: center; margin: 25px 0;">
                <p style="color: #666; font-size: 14px; margin: 0 0 10px 0;">Your Verification Code:</p>
                <h2 style="color: #007bff; font-size: 36px; letter-spacing: 4px; margin: 0; font-family: 'Courier New', monospace;">
                    {{ $code }}
                </h2>
            </div>

            <!-- Instructions -->
            <p style="color: #666; font-size: 16px; line-height: 24px; margin: 20px 0;">
                <strong>Instructions:</strong>
            </p>
            <ul style="color: #666; font-size: 16px; line-height: 24px; margin: 10px 0;">
                <li>Enter this code on the verification page to complete your registration</li>
                <li>This code will expire in 15 minutes</li>
                <li>Do not share this code with anyone</li>
                <li>You will receive a temporary password after verification</li>
            </ul>

            <!-- Important Note -->
            <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 4px;">
                <p style="color: #856404; font-size: 14px; margin: 0;">
                    <strong>⚠️ Security Note:</strong> If you did not request this code, please ignore this email. Your account will not be created unless you verify it.
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div style="border-top: 1px solid #eee; padding-top: 20px; text-align: center;">
            <p style="color: #999; font-size: 12px; margin: 0;">
                © {{ date('Y') }} {{ $appName }}. All rights reserved.
            </p>
            <p style="color: #999; font-size: 12px; margin: 10px 0 0 0;">
                Need help? <a href="mailto:support@example.com" style="color: #007bff; text-decoration: none;">Contact our support team</a>
            </p>
        </div>

    </div>
</div>
