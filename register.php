<?php

 ob_start();

 session_start(); // start a new session or continues the previous

 if( isset($_SESSION['user'])!="" ){

  header("Location: home.php"); // redirects to home.php

 }

 include_once 'dbconnect.php';


 $error = false;


 if ( isset($_POST['btn-signup']) ) {

 

  // sanitize user input to prevent sql injection

  $name = trim($_POST['name']);

  $name = strip_tags($name);

  $name = htmlspecialchars($name);

 

  $email = trim($_POST['email']);

  $email = strip_tags($email);

  $email = htmlspecialchars($email);

 

  $pass = trim($_POST['pass']);

  $pass = strip_tags($pass);

  $pass = htmlspecialchars($pass);

 

  // basic name validation

  if (empty($name)) {

   $error = true;

   $nameError = "Please enter your full name.";

  } else if (strlen($name) < 3) {

   $error = true;

   $nameError = "Name must have atleat 3 characters.";

  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {

   $error = true;

   $nameError = "Name must contain alphabets and space.";

  }

 

  //basic email validation

  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {

   $error = true;

   $emailError = "Please enter valid email address.";

  } else {

   // check whether the email exist or not

   $query = "SELECT user_email FROM users WHERE user_email='$email'";

   $result = mysqli_query($conn, $query);

   $count = mysqli_num_rows($result);

   if($count!=0){

    $error = true;

    $emailError = "Provided Email is already in use.";

   }

  }


  // password validation

  if (empty($pass)){

   $error = true;

   $passError = "Please enter password.";

  } else if(strlen($pass) < 6) {

   $error = true;

   $passError = "Password must have atleast 6 characters.";

  }

 

  // password encrypt using hallo();

  $password = hash('sha256', $pass);

 

  // if there's no error, continue to signup

  if( !$error ) {

   

   $query = "INSERT INTO users(user_name,user_email,user_pw) VALUES('$name','$email','$password')";

   $res = mysqli_query($conn, $query);

   

   if ($res) {

    $errTyp = "success";

    $errMSG = "Successfully registered, you may login now";

    unset($name);

    unset($email);

    unset($pass);

   } else {

    $errTyp = "danger";

    $errMSG = "Something went wrong, try again later...";

   }

   

  }

 

 

 }

?>

<!DOCTYPE html>

<html>

<head>

<title>Login & Registration System</title>


<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>

<link href="//netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>


<body>

   <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    <div class="row container">
      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3" >
        <h1>Registration</h1>
                <hr />


            <?php

   if ( isset($errMSG) ) {

   

    ?>


             <div class="alert">

 <?php echo $errMSG; ?>

             </div>

 <?php

   }

   ?>

            <label id="icon" for="name"><i class="icon-user"></i></label>
              <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" />
                <span class="text-danger"><?php echo $nameError; ?></span>


            <label id="icon" for="name"><i class="icon-envelope "></i></label>
              <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
                <span class="text-danger"><?php echo $emailError; ?></span>


         <label id="icon" for="name"><i class="icon-shield"></i></label>
            <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
              <span class="text-danger"><?php echo $passError; ?></span>

             <hr />

             <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button> | <a href="index.php">Sign In</
      </div>
    </div>
  </form>
</body>

</html>

<?php ob_end_flush(); ?>