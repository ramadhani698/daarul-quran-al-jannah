<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terlalu Banyak Percobaan — Daarul Qur'an Al-Jannah</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fdf9f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .error-card {
            background: #fff;
            border-radius: 20px;
            padding: 44px 36px;
            max-width: 440px;
            width: 100%;
            text-align: center;
            box-shadow: 0 16px 40px rgba(43, 28, 16, 0.1);
        }
        .error-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f4c430, #a70e13);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }
        .error-title {
            font-family: 'Lora', serif;
            color: #a70e13;
            font-size: 1.4rem;
            margin-bottom: 12px;
        }
        .error-desc {
            color: #5c4a3a;
            font-size: 0.92rem;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        .error-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .error-btn {
            display: inline-block;
            padding: 12px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: opacity 0.2s ease;
        }
        .error-btn:hover { opacity: 0.85; }
        .error-btn--primary { background: #a70e13; color: #fdf9f0; }
        .error-btn--secondary { background: transparent; color: #5c4a3a; border: 1px solid #e4d9c7; }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="error-icon">⏳</div>
        <h1 class="error-title">Terlalu Banyak Percobaan</h1>
        <p class="error-desc">
            Kamu sudah mencoba beberapa kali dalam waktu singkat.
            Silakan tunggu sebentar (kurang lebih 1 menit), lalu coba lagi ya.
        </p>
        <div class="error-actions">
            <a href="{{ url()->previous() }}" class="error-btn error-btn--primary">Coba Lagi</a>
            <a href="{{ route('donasi.index') }}" class="error-btn error-btn--secondary">Kembali ke Halaman Donasi</a>
        </div>
    </div>
</body>
</html>