<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <style>
        body {
            font-family: system-ui, Arial;
            background: #f6f7fb;
            margin: 0;
            padding: 40px;
        }

        .card {
            max-width: 420px;
            margin: auto;
            background: #fff;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .row {
            margin-bottom: 14px;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 6px;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d7dce3;
            border-radius: 10px;
        }

        button {
            width: 100%;
            padding: 10px 12px;
            border: 0;
            border-radius: 10px;
            background: #111827;
            color: #fff;
            cursor: pointer;
        }

        .hint {
            font-size: 12px;
            color: #6b7280;
            margin-top: 6px;
        }

        .err {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px 12px;
            border-radius: 10px;
            margin-bottom: 14px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2 style="margin:0 0 6px;">Login Sistem Pemagangan</h2>
        <p style="margin:0 0 18px; color:#6b7280;">Masukkan Email (Admin) / NBM (Dosen) / NIM (Mahasiswa).</p>

        @if ($errors->any())
            <div class="err">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="row">
                <label>Akun</label>
                <input name="identifier" value="{{ old('identifier') }}" placeholder="Email / NBM / NIM"
                    autocomplete="username">
                <div class="hint">Contoh: admin@mail.com atau 202312345 atau NBM00123</div>
            </div>

            <div class="row">
                <label>Password</label>
                <input name="password" type="password" placeholder="Masukkan Password" autocomplete="current-password">
            </div>

            <div class="row" style="display:flex; gap:10px; align-items:center;">
                <input type="checkbox" name="remember" id="remember" style="width:auto;">
                <label for="remember" style="margin:0;">Remember me</label>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>
