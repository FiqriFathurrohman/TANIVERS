<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP | TANIVERS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-green-800 mb-2">Verifikasi OTP</h1>

        <p class="text-sm text-gray-600 mb-6">
            Masukkan kode OTP 6 digit yang sudah dikirim ke email Anda.
        </p>

        @if (session('status'))
            <div class="mb-4 rounded-xl bg-green-50 text-green-700 px-4 py-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-xl bg-red-50 text-red-700 px-4 py-3 text-sm">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('otp.verify') }}" method="POST">
            @csrf

            <label for="otp" class="block text-xs font-bold uppercase text-green-700 mb-2">
                Kode OTP
            </label>

            <input
                type="text"
                name="otp"
                id="otp"
                maxlength="6"
                inputmode="numeric"
                autocomplete="one-time-code"
                class="w-full rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-center text-2xl tracking-[0.4em] font-bold outline-none focus:border-green-700 focus:bg-white"
                placeholder="000000"
                required
            >

            <button
                type="submit"
                class="mt-5 w-full rounded-full bg-green-700 px-5 py-3 text-white font-bold hover:bg-green-800"
            >
                Verifikasi Akun
            </button>
        </form>

        <form action="{{ route('otp.resend') }}" method="POST" class="mt-4">
            @csrf

            <button
                type="submit"
                class="w-full text-sm font-semibold text-green-700 hover:underline"
            >
                Kirim ulang kode OTP
            </button>
        </form>

        <form action="{{ route('logout') }}" method="POST" class="mt-6 text-center">
            @csrf

            <button type="submit" class="text-xs text-gray-500 hover:text-red-600">
                Keluar
            </button>
        </form>
    </div>

</body>
</html>