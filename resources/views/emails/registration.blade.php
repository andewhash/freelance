<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение регистрации</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #212529;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #4d4d4d;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .footer {
            margin-top: 20px;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }
        .verification-code {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            text-align: center;
            margin: 20px 0;
            color: #4d4d4d;
        }
        .btn-primary {
            background-color: #4d4d4d;
            border-color: #4d4d4d;
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Добро пожаловать, {{ $user->name }}!</h1>
        </div>
        
        <div class="content">
            <p>Благодарим вас за регистрацию на {{ config('app.name') }}. Для завершения регистрации подтвердите ваш email адрес.</p>
            
            <div class="alert alert-info">
                <h4 class="alert-heading">Код подтверждения</h4>
                <p>Используйте следующий код для подтверждения вашего email адреса:</p>
                <div class="verification-code">{{ $user->email_verification_code }}</div>
                <p class="mb-0">Этот код действителен в течение 24 часов.</p>
            </div>
            
            <p>Если вы не запрашивали этот код, пожалуйста, проигнорируйте это письмо.</p>
            
            <div class="text-center mt-4">
                <a href="{{ url('/verification') }}" class="btn btn-info">Перейти к подтверждению</a>
            </div>
            
            <div class="mt-4 pt-3 border-top">
                <h5>Ваши данные:</h5>
                <ul class="list-unstyled">
                    <li><strong>Имя:</strong> {{ $user->name }}</li>
                    <li><strong>Email:</strong> {{ $user->email }}</li>
                    @if($user->phone)
                    <li><strong>Телефон:</strong> {{ $user->phone }}</li>
                    @endif
                </ul>
            </div>
        </div>
        
        <div class="footer">
            <p>Если у вас возникли вопросы, свяжитесь с нашей поддержкой.</p>
            <p class="mb-0">&copy; {{ date('Y') }} Textile Server. Все права защищены.</p>
        </div>
    </div>
</body>
</html>