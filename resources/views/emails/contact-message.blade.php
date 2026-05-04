<!DOCTYPE html>
<html lang="tk">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Inter', Helvetica, Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #111827;
            padding: 32px;
            color: #ffffff;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header p {
            margin: 8px 0 0;
            font-size: 14px;
            color: #9ca3af;
        }
        .content {
            padding: 32px;
        }
        .row {
            display: flex;
            padding: 16px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .label {
            width: 120px;
            color: #6b7280;
            font-size: 14px;
        }
        .value {
            flex: 1;
            color: #111827;
            font-size: 14px;
            font-weight: 600;
        }
        .message-section {
            margin-top: 32px;
        }
        .message-label {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 12px;
        }
        .message-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            color: #374151;
            font-size: 15px;
            line-height: 1.6;
        }
        .button-wrapper {
            margin-top: 32px;
        }
        .btn {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff !important;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Täze aragatnaşyk haty</h2>
        <p>Web sahypaňyzdan täze bir ýüzlenme geldi.</p>
    </div>

    <div class="content">
        <div class="row">
{{--            <div class="label">Ady:</div>--}}
{{--            <div class="value">{{ $messageData->name }}</div>--}}
        </div>

        <div class="row">
            <div class="label">E-poçta:</div>
            <div class="value" style="color: #2563eb;">{{ $messageData->email }}</div>
        </div>

        <div class="row" style="border-bottom: none;">
            <div class="label">Telefon:</div>
            <div class="value">{{ $messageData->phone_number }}</div>
        </div>

        <div class="message-section">
            <div class="message-label">Hat:</div>
            <div class="message-box">
                {{ $messageData->message }}
            </div>
        </div>

        <div class="button-wrapper">
            <a href="mailto:{{ $messageData->email }}" class="btn">
                Jogap ber
            </a>
        </div>
    </div>
</div>
</body>
</html>
