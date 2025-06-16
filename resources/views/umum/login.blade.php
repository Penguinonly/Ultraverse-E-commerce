<!-- login.html -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>InHouse - Sign In</title>
  <!-- Link to external CSS -->
  <link rel="stylesheet" href="login.css" />
</head>
<body>
  <div class="container">
    <h1>InHouse</h1>
    <form action="../Login/create.html" method="get">
      <div class="form-group">
        <label for="user">Username</label>
        <input type="text" id="user" name="username" placeholder="" />
      </div>
      <div class="form-group">
        <label for="pass">Password</label>
        <input type="password" id="pass" name="password" placeholder="" />
      </div>
      <div class="form-group checkbox-group">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Remember me</label>
      </div>
      <button type="submit" class="btn">Login</button>
      <p class="toggle-link">Don&rsquo;t have an account? <a href="../Login/create.html">Create account</a></p>
    </form>
  </div>
</body>
</html>