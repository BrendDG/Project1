<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuw Contactbericht</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #1a1f35 0%, #0f1220 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #4a9eff;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #4a9eff;
        }
        .field-label {
            font-weight: bold;
            color: #333;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .field-value {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
            word-wrap: break-word;
        }
        .message-box {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 5px;
            margin-top: 10px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 14px;
            color: #777;
            border-top: 1px solid #e0e0e0;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #4a9eff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            font-weight: bold;
        }
        .button:hover {
            background: #3b82f6;
        }
        .alert-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .alert-box strong {
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Nieuw Contactbericht</h1>
            <p style="margin: 10px 0 0 0; color: #c0c0c0;">Via Rocket League Community Website</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="alert-box">
                <strong>Let op:</strong> Dit bericht is verzonden via het contactformulier op de website. Reageer direct op deze email om contact op te nemen met de afzender.
            </div>

            <!-- Afzender Info -->
            <div class="field">
                <div class="field-label">Naam</div>
                <div class="field-value">{{ $contactMessage->name }}</div>
            </div>

            <div class="field">
                <div class="field-label">Email Adres</div>
                <div class="field-value">
                    <a href="mailto:{{ $contactMessage->email }}" style="color: #4a9eff; text-decoration: none;">
                        {{ $contactMessage->email }}
                    </a>
                </div>
            </div>

            <div class="field">
                <div class="field-label">Onderwerp</div>
                <div class="field-value">{{ $contactMessage->subject }}</div>
            </div>

            <!-- Bericht -->
            <div class="field">
                <div class="field-label">Bericht</div>
                <div class="message-box">{{ $contactMessage->message }}</div>
            </div>

            <!-- Ontvangen op -->
            <div class="field">
                <div class="field-label">Ontvangen op</div>
                <div class="field-value">{{ $contactMessage->created_at->format('d-m-Y H:i:s') }}</div>
            </div>

            <!-- Action Button -->
            <div style="text-align: center; margin-top: 30px;">
                <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ urlencode($contactMessage->subject) }}" class="button">
                    Reageer op dit bericht
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0 0 10px 0;">
                Dit is een automatisch gegenereerde email vanuit het contactformulier.
            </p>
            <p style="margin: 0; font-size: 12px; color: #999;">
                Rocket League Community © {{ date('Y') }}
            </p>
        </div>
    </div>
</body>
</html>
