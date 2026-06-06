<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #F9FAFB; margin: 0; padding: 20px; }
        .card { background: white; border-radius: 12px; padding: 24px; max-width: 500px; margin: 0 auto; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        h1 { color: #FF6200; font-size: 20px; }
        p { color: #333; line-height: 1.6; }
        .footer { font-size: 12px; color: #888; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <h1>{{ $subject }}</h1>
        <p>Bonjour {{ $userName }},</p>
        <p>{{ $body }}</p>
        <p>Connectez-vous à <strong>Mania-PME</strong> pour plus de détails.</p>
        <div class="footer">© {{ date('Y') }} Mania-PME · Gestion RH</div>
    </div>
</body>
</html>