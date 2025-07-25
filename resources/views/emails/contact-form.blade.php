<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8fafc;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #00d4aa 0%, #3b82f6 100%);
            padding: 2rem;
            text-align: center;
            color: white;
        }
        
        .email-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .email-header p {
            opacity: 0.9;
            font-size: 1rem;
        }
        
        .email-body {
            padding: 2rem;
        }
        
        .contact-info {
            background: #f8fafc;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #00d4aa;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 1rem;
            align-items: flex-start;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #374151;
            min-width: 100px;
            margin-right: 1rem;
        }
        
        .info-value {
            color: #6b7280;
            flex: 1;
        }
        
        .message-section {
            margin-top: 2rem;
        }
        
        .message-section h3 {
            color: #374151;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 0.5rem;
        }
        
        .message-content {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1.5rem;
            color: #374151;
            line-height: 1.7;
            white-space: pre-wrap;
        }
        
        .email-footer {
            background: #f9fafb;
            padding: 1.5rem 2rem;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer-text {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .footer-link {
            color: #00d4aa;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            background-color: rgba(0, 212, 170, 0.1);
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            background-color: rgba(0, 212, 170, 0.2);
        }
        
        .brand-signature {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e5e7eb;
            color: #9ca3af;
            font-size: 0.8rem;
        }
        
        .urgent {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .urgent-text {
            color: #dc2626;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        @media (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .email-header,
            .email-body,
            .email-footer {
                padding: 1.5rem 1rem;
            }
            
            .info-row {
                flex-direction: column;
            }
            
            .info-label {
                margin-bottom: 0.25rem;
                margin-right: 0;
            }
            
            .footer-links {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🚀 New Contact Form Submission</h1>
            <p>Someone wants to connect with you through your portfolio website</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <!-- Priority Notice (if urgent keywords detected) -->
            @php
                $urgentKeywords = ['urgent', 'asap', 'emergency', 'immediate', 'critical', 'important'];
                $isUrgent = false;
                foreach($urgentKeywords as $keyword) {
                    if(stripos($contactData['subject'], $keyword) !== false || stripos($contactData['message'], $keyword) !== false) {
                        $isUrgent = true;
                        break;
                    }
                }
            @endphp
            
            @if($isUrgent)
            <div class="urgent">
                <div class="urgent-text">⚠️ This message may require immediate attention</div>
            </div>
            @endif
            
            <!-- Contact Information -->
            <div class="contact-info">
                <div class="info-row">
                    <span class="info-label">👤 Name:</span>
                    <span class="info-value">{{ $contactData['name'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">📧 Email:</span>
                    <span class="info-value">
                        <a href="mailto:{{ $contactData['email'] }}" style="color: #00d4aa; text-decoration: none;">
                            {{ $contactData['email'] }}
                        </a>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">📋 Subject:</span>
                    <span class="info-value">{{ $contactData['subject'] }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">🕒 Received:</span>
                    <span class="info-value">{{ now()->format('F j, Y \a\t g:i A') }}</span>
                </div>
            </div>
            
            <!-- Message Content -->
            <div class="message-section">
                <h3>💬 Message Content</h3>
                <div class="message-content">{{ $contactData['message'] }}</div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-text">
                Quick Actions - Respond directly to this inquiry:
            </div>
            <div class="footer-links">
                <a href="mailto:{{ $contactData['email'] }}?subject=Re: {{ $contactData['subject'] }}" class="footer-link">
                    Reply via Email
                </a>
                <a href="https://www.kudzainigeljeche.com" class="footer-link">
                    Visit Portfolio
                </a>
            </div>
            
            <div class="brand-signature">
                <strong>&lt;Nigel/&gt;</strong> - Leading Digital Portfolio<br>
                Automated email from kudzainigeljeche.com contact form
            </div>
        </div>
    </div>
</body>
</html>