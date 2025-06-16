<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chat Properti Interaktif</title>
  <link rel="stylesheet" href="{{ asset('css/Agen_Properti/chat.css') }}">
</head>
<body>

<!-- Sidebar -->
  <x-layouts.seller.sidebar></x-layouts.seller.sidebar>

    <!-- MAIN -->
    <div class="main">
      <div class="chat-list">
        <h3>Chat Properti</h3>
        <div class="user"><i class="fas fa-user"></i><span>Admin InHome</span></div>
      </div>

      <div class="chat-area">
        <div class="chat-header">
          <div><strong>Admin</strong><br><small>Online</small></div>
        </div>

        <div class="chat-body" id="chatBody">
          <!-- Chat akan muncul di sini -->
        </div>

        <div class="chat-footer">
          <input type="text" id="chatInput" placeholder="Ketik Pesan" />
          <div class="send-btn" onclick="sendMessage()">➤</div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const chatBody = document.getElementById('chatBody');
    const chatInput = document.getElementById('chatInput');

    function sendMessage() {
      const text = chatInput.value.trim();
      if (text === '') return;

      const userMsg = document.createElement('div');
      userMsg.className = 'message user';
      userMsg.innerHTML = `<div class="sender">Pengguna</div>${text}`;
      chatBody.appendChild(userMsg);
      chatInput.value = '';
      chatBody.scrollTop = chatBody.scrollHeight;

      // Simulasi respon Admin Bot
      setTimeout(() => {
        const adminMsg = document.createElement('div');
        adminMsg.className = 'message admin';
        const whatsappLink = 'https://wa.me/6281244778908';
        const lowerText = text.toLowerCase();

        if (lowerText.includes("jual") || lowerText.includes("penjual")) {
          adminMsg.innerHTML = `<div class="sender">Admin</div>Silakan lanjutkan chat Anda melalui WhatsApp <a href='${whatsappLink}' target='_blank'>di sini</a>.`;
        } else if (lowerText.includes("beli") || lowerText.includes("pembeli")) {
          adminMsg.innerHTML = `<div class="sender">Admin</div>Silakan hubungi pihak terkait langsung melalui WhatsApp <a href='${whatsappLink}' target='_blank'>di sini</a>.`;
        } else if (lowerText.includes("hai") || lowerText.includes("halo") || lowerText.includes("hello")) {
          adminMsg.innerHTML = `<div class="sender">Admin</div>Hai! Ada yang bisa saya bantu hari ini?`;
        } else if (lowerText.includes("bicara") || lowerText.includes("admin") || lowerText.includes("ngobrol") || lowerText.includes("nomor") || lowerText.includes("kontak") || lowerText.includes("hubungi")) {
          adminMsg.innerHTML = `<div class="sender">Admin</div>Siap! Kamu bisa hubungi admin kami di WhatsApp <a href='${whatsappLink}' target='_blank'>di sini</a>.`;
        } else if (lowerText.includes("cari") || lowerText.includes("rumah") || lowerText.includes("harga") || lowerText.includes("lokasi")) {
          adminMsg.innerHTML = `<div class="sender">Admin</div>Tentu! Kami punya beberapa pilihan rumah di dashboard kami. Silahkan mengakses link <a href='#'>di sini</a>.`;
        } else if (lowerText.includes("kpr")) {
          adminMsg.innerHTML = `<div class="sender">Admin</div>Ya! Bisa banget. Kamu bisa mengambil KPR di Website kami.`
        } else {
          adminMsg.innerHTML = `<div class="sender">Admin</div>Maaf, bisa dijelaskan lagi?`;
        }

        chatBody.appendChild(adminMsg);
        chatBody.scrollTop = chatBody.scrollHeight;
      }, 1000);
    }

    // Kirim pesan saat tekan tombol Enter
    chatInput.addEventListener("keydown", function (e) {
      if (e.key === "Enter") {
        e.preventDefault();
        sendMessage();
      }
    });
  </script>
</body>
</html>
