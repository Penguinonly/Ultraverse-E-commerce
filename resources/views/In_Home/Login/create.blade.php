<!-- register.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InHouse - Create Account</title>
  <!-- Link to external CSS -->
  <link rel="stylesheet" href="{{ asset('css/create_login.css') }}">
</head>
<body>
  <div class="container">
    <h1>InHouse</h1>
    <form action="../Login/signIn.html" method="get">
      <div class="form-group">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" placeholder="" />
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="" />
      </div>
      <div class="form-group">
        <label for="newpass">Password</label>
        <input type="password" id="newpass" name="password" placeholder="" />
      </div>
      <button type="submit" class="btn">Create Account</button>
      <p class="toggle-link">Already have an account? <a href="../Login/signIn.html">Login</a></p>
    </form>
  </div>
</body>
</html>