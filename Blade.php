@if (session('resent'))
    <div class="alert alert-success" role="alert">
        Link verifikasi telah dikirim ke email kamu.
    </div>
@endif

Sebelum melanjutkan, silakan cek email kamu untuk link verifikasi.<br>
Jika belum menerima email, <a href="{{ route('verification.resend') }}">klik di sini untuk kirim ulang</a>.
