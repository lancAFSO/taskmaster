<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if (!isset($_SESSION['system'])) {
  $result = $conn->query("SELECT * FROM system_settings");
  if ($result) {
    $system = $result->fetch_array();
    if ($system) {
      foreach ($system as $k => $v) {
        $_SESSION['system'][$k] = $v;
      }
    } else {
      // Fallback if no data is found
      $_SESSION['system'] = ['name' => 'TaskMaster'];
    }
  } else {
    // Fallback if query fails
    $_SESSION['system'] = ['name' => 'TaskMaster'];
  }
} 
ob_end_flush();
?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");
?>
<?php include 'header.php' ?>

<head>
  <style>
    /* 3D effect for login card */
    .login-card-3d {
      border-radius: 10px;
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2), 0 4px 6px rgba(0, 0, 0, 0.15);
      border: 1px solid #ccc;
      background: linear-gradient(145deg, #ffffff, #e6e6e6);
      padding: 20px;
      transform: perspective(1000px) translateZ(0px);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Add hover effect for more realism */
    .login-card-3d:hover {
      transform: perspective(1000px) translateZ(10px);
      box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3), 0 6px 8px rgba(0, 0, 0, 0.2);
    }

    /* Background for the page with an image */
    body {
      background: url('assets/uploads/runningman.gif') no-repeat center center fixed; 
      background-size: 137% 100%; /* This makes the background image cover the whole screen */
      font-family: Arial, sans-serif;
    }

    /* Center the login box */
    .login-box {
      margin: auto;
      width: 100%;
      max-width: 400px;
      padding-top: 50px;
      position: relative; /* Needed for the title positioning */
    }

    /* Center the logo */
    .brand-logo {
      height: 100px;
      width: 150px;
      margin-bottom: 20px;
    }

    /* Title that appears on hover */
    .title-hover {
      font-family: 'Merriweather', serif;
      font-size: 42px;
      font-weight: bold;
      color: #5C4A0C;
      text-align: center;
      padding: 5px;  /* Padding around the text */
      transition: all 0.3s ease;
    }
  </style>
</head>

<body class="hold-transition login-page">
<div class="login-box">
  <!-- Title displayed on hover -->
  <div class="title-hover">
    <?php echo 'TaskMaster'; ?>
  </div>
  <div class="card login-card-3d">
    <div class="card-body login-card-body">
      <!-- Logo -->
      <div class="text-center">
        <img src="assets/uploads/flipcalendar.gif" alt="Logo" class="brand-logo">
      </div>
      <br>

      <form action="" id="login-form">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" required placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<br><br><br><br>
<script>
  $(document).ready(function(){
    $('#login-form').submit(function(e){
      e.preventDefault();
      start_load();
      if($(this).find('.alert-danger').length > 0 )
        $(this).find('.alert-danger').remove();
      $.ajax({
        url:'ajax.php?action=login',
        method:'POST',
        data:$(this).serialize(),
        error:err=>{
          console.log(err);
          end_load();
        },
        success:function(resp){
          if(resp == 1){
            location.href ='index.php?page=home';
          }else{
            $('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>');
            end_load();
          }
        }
      });
    });
  });
</script>

<?php include 'footer.php' ?>

</body>
</html>