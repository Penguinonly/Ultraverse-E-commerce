<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Data Diri</title>
    <link rel="stylesheet" href="{{ asset('css/Agen_Properti/data.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="back-arrow" onclick="window.history.back()">&#8592;</div>
        <h2>Verifikasi data diri</h2>
        <form id="verificationForm" enctype="multipart/form-data">
      <div class="form-row">
        <div class="form-group">
          <label for="first-name">First Name</label>
          <input type="text" id="first-name" placeholder="First Name">
        </div>
        <div class="form-group">
          <label for="last-name">Last Name</label>
          <input type="text" id="last-name" placeholder="Last Name">
        </div>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Email">
      </div>

      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" placeholder="Phone Number">
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="dob">Date Birth</label>
          <select id="dob">
            <option value="">Pilih Tanggal Lahir</option>
          </select>
        </div>
        <div class="form-group">
          <label for="city">City</label>
          <select id="city">
            <option value="">Pilih Kota</option>
          </select>
        </div>
      </div>      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" name="address" placeholder="Masukkan alamat lengkap">
      </div>

      <!-- Upload Foto KTP Section -->
      <div class="verification-section">
        <h3>Upload Foto KTP</h3>
        <div class="upload-area">
            <div class="upload-box" id="ktpUploadBox">
                <div class="preview-container" id="ktpPreview">
                    <img src="" alt="Preview KTP" id="ktpPreviewImg">
                    <button type="button" class="remove-preview" onclick="removeKtpPreview()">×</button>
                </div>
                <span class="tambah-foto" onclick="toggleUploadOptions('ktpUploadOptions')">+ Tambah Foto</span>
                <!-- Upload Options Popup -->
                <div class="upload-options" id="ktpUploadOptions">
                    <button type="button" class="upload-option" onclick="document.getElementById('ktpFile').click()">
                        <span class="icon">📁</span> Pilih File
                    </button>
                    <button type="button" class="upload-option" onclick="openKtpCamera()">
                        <span class="icon">📷</span> Buka Kamera
                    </button>
                </div>
            </div>
            <input type="file" id="ktpFile" name="ktp_file" accept="image/*" style="display: none">
        </div>
      </div>

      <!-- Verifikasi Wajah Section -->
      <div class="verification-section">
        <h3>Verifikasi Wajah</h3>
        <div class="upload-area">
            <div class="upload-box" id="faceUploadBox">
                <div class="preview-container" id="facePreview">
                    <img src="" alt="Preview Face" id="facePreviewImg">
                    <button type="button" class="remove-preview" onclick="removeFacePreview()">×</button>
                </div>
                <span class="tambah-foto" onclick="toggleUploadOptions('faceUploadOptions')">+ Tambah Foto</span>                <!-- Upload Options Popup -->
                <div class="upload-options" id="faceUploadOptions">
                    <button type="button" class="upload-option" onclick="document.getElementById('faceFile').click()">
                        <span class="icon">📁</span> Pilih File
                    </button>
                    <button type="button" class="upload-option" onclick="startFaceCamera()">
                        <span class="icon">📷</span> Ambil Foto
                    </button>
                </div>
            </div>
            <input type="file" id="faceFile" name="face_file" accept="image/*" style="display: none">
        </div>
      </div>

      <!-- Terms and Conditions -->
      <div class="terms-section">
        <div class="checkbox-container">
            <input type="checkbox" id="terms" name="terms" required>
            <label for="terms">Saya menyetujui Syarat dan Ketentuan.</label>
        </div>
        <div class="terms-box">
            <ul>
                <li>Semua info yang diberikan kepada kami adalah akurat.</li>
                <li>Penjual memiliki izin untuk menawarkan properti di InHouse.</li>
                <li>Apabila penjual memasukkan informasi palsu maka akan dikenakan sanksi sesuai ketentuan hukum.</li>
            </ul>
        </div>
      </div>

      <button type="submit" class="btn-submit">Submit</button>
    </form>
</div>

<!-- Camera Interface -->
<div class="camera-interface" id="cameraInterface">
    <button class="close-camera" onclick="closeCameraInterface()">
        <i class="fas fa-times"></i>
    </button>

    <div class="camera-viewport">
        <video id="cameraFeed" autoplay playsinline></video>
    </div>

    <button class="capture-button" onclick="capturePhoto()"></button>
</div>

<script>
// Close popup when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.upload-box')) {
        document.querySelectorAll('.upload-options').forEach(popup => {
            popup.classList.remove('active');
        });
    }
});

function toggleUploadOptions(id) {
    // Close all other popups first
    document.querySelectorAll('.upload-options').forEach(popup => {
        if (popup.id !== id) {
            popup.classList.remove('active');
        }
    });
    // Toggle the clicked popup
    document.getElementById(id).classList.toggle('active');
}

let stream = null;

function openKtpCamera() {
    document.getElementById('ktpUploadOptions').classList.remove('active');
    document.getElementById('cameraInterface').classList.add('active');
    startCamera();
}

let currentSection = '';

function startFaceCamera() {
    currentSection = 'face';
    document.getElementById('faceUploadOptions').classList.remove('active');
    document.getElementById('cameraInterface').classList.add('active');
    startCamera('user'); // Use front camera for face
}

function openKtpCamera() {
    currentSection = 'ktp';
    document.getElementById('ktpUploadOptions').classList.remove('active');
    document.getElementById('cameraInterface').classList.add('active');
    startCamera('environment'); // Use back camera for KTP
}

function startCamera(facingMode) {
    navigator.mediaDevices.getUserMedia({ 
        video: { 
            facingMode: facingMode,
            width: { ideal: 1920 },
            height: { ideal: 1080 }
        } 
    })
    .then(function(mediaStream) {
        stream = mediaStream;
        const video = document.getElementById('cameraFeed');
        video.srcObject = mediaStream;
    })
    .catch(function(err) {
        console.error('Error accessing camera:', err);
        alert('Error accessing camera: ' + err.message);
    });
}

function closeCameraInterface() {
    document.getElementById('cameraInterface').classList.remove('active');
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}

function capturePhoto() {
    if (!stream) return;

    const video = document.getElementById('cameraFeed');
    const canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    
    const context = canvas.getContext('2d');
    context.drawImage(video, 0, 0);
    
    const imageData = canvas.toDataURL('image/jpeg');
    
    if (currentSection === 'ktp') {
        document.getElementById('ktpPreviewImg').src = imageData;
        document.getElementById('ktpPreview').classList.add('active');
        document.getElementById('ktpUploadBox').querySelector('.tambah-foto').style.display = 'none';
    } else {
        document.getElementById('facePreviewImg').src = imageData;
        document.getElementById('facePreview').classList.add('active');
        document.getElementById('faceUploadBox').querySelector('.tambah-foto').style.display = 'none';
    }
    
    closeCameraInterface();
}

// Preview handlers for KTP
document.getElementById('ktpFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('ktpPreviewImg').src = e.target.result;
            document.getElementById('ktpPreview').classList.add('active');
            document.getElementById('ktpUploadBox').querySelector('.tambah-foto').style.display = 'none';
            document.getElementById('ktpUploadOptions').classList.remove('active');
        };
        reader.readAsDataURL(file);
    }
});

function removeKtpPreview() {
    document.getElementById('ktpFile').value = '';
    document.getElementById('ktpPreviewImg').src = '';
    document.getElementById('ktpPreview').classList.remove('active');
    document.getElementById('ktpUploadBox').querySelector('.tambah-foto').style.display = 'flex';
}

// Preview handlers for Face
document.getElementById('faceFile').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('facePreviewImg').src = e.target.result;
            document.getElementById('facePreview').classList.add('active');
            document.getElementById('faceUploadBox').querySelector('.tambah-foto').style.display = 'none';
            document.getElementById('faceUploadOptions').classList.remove('active');
        };
        reader.readAsDataURL(file);
    }
});

function removeFacePreview() {
    document.getElementById('faceFile').value = '';
    document.getElementById('facePreviewImg').src = '';
    document.getElementById('facePreview').classList.remove('active');
    document.getElementById('faceUploadBox').querySelector('.tambah-foto').style.display = 'flex';
}
</script>
</body>
</html>
