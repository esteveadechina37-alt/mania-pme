<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin — {{ auth()->user()->company->name }}</title>
    <style>
        body { font-family: 'Cabinet Grotesk', sans-serif; background: #F7F4F0; display:flex; align-items:center; justify-content:center; height:100vh; margin:0; }
        .card { background:#fff; padding:48px 64px; border-radius:24px; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.06); }
        h1 { font-family: 'Clash Display', sans-serif; color:#0A0A0A; font-size:32px; margin-bottom:8px; }
        p { color:#6B6B6B; font-size:16px; }
        .badge { display:inline-block; background:#FF6200; color:#fff; padding:6px 20px; border-radius:100px; font-size:13px; font-weight:700; letter-spacing:0.5px; margin-bottom:24px; }
        .logout { background:#0A0A0A; color:#fff; border:none; padding:12px 28px; border-radius:10px; font-size:14px; font-weight:600; cursor:pointer; margin-top:24px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="badge">ADMIN</div>
        <h1>Bienvenue, {{ auth()->user()->name }} 👋</h1>
        <p>Entreprise : <strong>{{ auth()->user()->company->name }}</strong></p>
        <p style="margin-top:12px;color:#aaa;font-size:14px;">Le dashboard complet arrive dans la prochaine étape...</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout">Se déconnecter</button>
        </form>
    </div>
</body>
</html>