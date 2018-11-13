<?php
session_start();
require_once("../Project/database/Db.php");
$objDb = new Db();
$db = $objDb->database;
  if (isset($_POST['submit']))
  {
    $errMsg = '';    //new variable

    //get data from FORM
    $username = $_POST['username'];
    $password = $_POST['passwd'];
    //Condition username & password
    if($username == '')
      $errMsg = 'Enter username';
    if($password == '')
      $errMsg = 'Enter password';

      if($errMsg == '')
      {
        try
        {
          $stmt = $db->prepare( 'SELECT admin_id username, password FROM admin WHERE username = :username');
          $stmt->execute(array(':username' => $username));
          $data = $stmt->fetch(PDO::FETCH_ASSOC);

          if($data == false)
          {
            echo '<script>alert("ชื่อผู้ใช้ไม่ถูกต้อง '.$username .'");</script>';
          }
         else
          {
           if($password == $data['password'])
            {
              $_SESSION['username'] = $data['username'];
              $_SESSION['passwd'] = $data['passwd'];

              header('Location: index.php?page=dashboard'); //open file
              exit;
            }
            else
              $errMsg = 'Password not match.';
            echo '<script>alert("รหัสผ่านไม่ถูกต้อง");</script>';
          }
        }
        catch(PDOException $e)
        {
         $errMsg = $e->getMessage();
        }
      }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/Project/CSS/Form_login.css">
 <script type="text/javascript" src="/Project/bootstrap-4.1.3/bootstrap-4.1.3/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/Project/jquery/jquery-3.3.1.min.js"></script>
  <title>Form Login</title>
<style>
.toppic {
  text-align: center;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: white;
  overflow: hidden;
  overflow-x: hidden;
  cursor: none;
}
</style>
</head>
<body>
  <!--horizontal bar !-->
  <div class="navbar">
      <a class="active"><h3>Admin</h3></a> <!--not use!-->
      <!-- Button login -->
        <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button>
        <!--Text welcome!-->
      <div class="toppic">
        <h1 style="font-size:50px">ระบบจัดการโรงงานผลิตเซรามิค</h1>
        <p>ยินดีต้อนรับ</p>
      </div>
          <!--Modal login!-->
    <div id="id01" class="modal" >
      <form class="modal-content animate" action="" method="POST">
        <div class="imgcontainer">
          <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <p><center><h3><b>Login</b></h3></center></p>
        </div>
        <div class="container">
          <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off" required>

          <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="passwd" autocomplete="off" value="<?php if(isset($_POST['passwd'])) echo $_POST['passwd'] ?>" required>
            <button type="submit" name="submit" value="submit">Login</button>
             <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        </div>

        <div class="container">
          <span><a href="formgot.php" class="psw" name="">forgot password</a></span>
        </div>
      </form>
  </div>
  </div>
  <img src="/Project/images/gackground-2.jpg" width="100%" height="auto" class="img-responsive">
    <!--script modal!-->
  <script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event)
    {
      if (event.target == modal)
      {
        modal.style.display = "none";
      }
    }
  </script>
</body>
</html>
