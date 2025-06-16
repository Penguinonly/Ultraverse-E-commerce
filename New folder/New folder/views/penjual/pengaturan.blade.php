<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Settings Page</title>
  <link rel="stylesheet" href="{{ asset('css/Agen_Properti/pengaturan.css') }}">
</head>

<body>
  <div class="card edit-profile">
    <h2>Edit Profile</h2>
    <label for="fullname">Full Name</label>
    <input type="text" id="fullname">

    <label for="username">Username</label>
    <input type="text" id="username">

    <label for="email">E-mail</label>
    <input type="email" id="email">

    <button>Save changes</button>
  </div>

  <div class="card">
    <h2>Privacy & Security</h2>
    <div class="section-link">Change password <span class="arrow">&rarr;</span></div>
    <div class="section-link">Privacy preferences <span class="arrow">&rarr;</span></div>
  </div>

  <div class="card">
    <h2>Other</h2>
    <div class="section-link">Language & Region <span class="arrow">&rarr;</span></div>
  </div>

  <div class="card">
    <div class="section-link">Delete account <span class="arrow">&rarr;</span></div>
  </div>
</body>
</html>
