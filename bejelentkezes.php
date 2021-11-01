<?php
// core configuration
include_once "compose/core.php";
  
// include login checker
$require_login=false;
include_once "login_checker.php";
 
// default to false
$access_denied=false;
 
// if the login form was submitted
if($_POST){
include_once "compose/database.php";
include_once "compose/objects/user.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$user = new User($db);
 
// check if email and password are in the database
$user->email=$_POST['email'];
 
// check if email exists, also get user details using this emailExists() method
$email_exists = $user->emailExists();
 
// validate login
if ($email_exists && password_verify($_POST['password'], $user->password) && $user->status==1){
 
    // if it is, set the session value to true
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $user->id;
    $_SESSION['access_level'] = $user->access_level;
    $_SESSION['firstname'] = htmlspecialchars($user->firstname, ENT_QUOTES, 'UTF-8') ;
    $_SESSION['lastname'] = $user->lastname;
 
    // if access level is 'Admin', redirect to admin section
    if($user->access_level=='Admin'){
        header("Location: {$home_url}admin/index.php?action=login_success");
    }
 
    // else, redirect only to 'Customer' section
    else{
        header("Location: index.php?action=login_success");
    }
}
 
// if username does not exist or password is wrong
else{
    $access_denied=true;
}


}
 
// include page header HTML
include_once "includes/header.php";

?>
<main>
    <div class="container">
        <div class="row">
            <div class="md-12">
                <div class="box white-box">
                    <?php
                    $action=isset($_GET['action']) ? $_GET['action'] : "";

                    // tell the user he is not yet logged in
                    if($action =='not_yet_logged_in'){
                    echo "<div class='alert alert-danger margin-top-40' role='alert'>Please login.</div>";
                    }

                    // tell the user to login
                    else if($action=='please_login'){
                    echo "<div class='alert alert-info'>
                    <strong>Please login to access that page.</strong>
                    </div>";
                    }

                    // tell the user email is verified
                    else if($action=='email_verified'){
                    echo "<div class='alert alert-success'>
                    <strong>Your email address have been validated.</strong>
                    </div>";
                    }

                    // tell the user if access denied
                    if($access_denied){
                    echo "<div class='alert alert-danger margin-top-40' role='alert'>
                    Access Denied.<br /><br />
                    Your username or password maybe incorrect
                    </div>";
                    }

                    // actual HTML login form
                    echo "<div class='account-wall'>";
                    echo "<div id='my-tab-content' class='tab-content'>";
                    echo "<div class='tab-pane active' id='login'>";
                    echo "<h3>Bejelentkezés e-mail címmel</h3>";
                    echo "<form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
                    echo "</br>";
                    echo "<label class='row-100 input'>";
                    echo "<input type='text' name='email' class='input-style' required autofocus />";
                    echo "<span class='text'>E-mail</span>";
                    echo "<div class='focus-border'></div>";
                    echo "</label>";
                    echo "<label class='row-100 input'>";
                    echo "<input type='password' name='password' class='input-style' required />";
                    echo "<span class='text'>Jelszó</span>";
                    echo "<div class='focus-border'></div>";
                    echo "</label>";

                    echo "<input type='submit' class='btn btn-block btn-details' value='Bejelentkezés' />";
                    echo "<a href='elfelejtett-jelszo.php' class='btn btn-block'>Elfelejtettem a jelszavam</a>
                    <a href='register.php' class='btn btn-block btn-alert'>Regisztráció</a>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";

                    echo "</div>"; ?>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div class="box white-box">
            <h3>Gyors bejelentkezés</h3>
                <a href="" class='btn btn-details btn-block'><i class="fab fa-facebook-f"></i>Bejelentkezés Facebook-al</a>
            </div>
    </div>
</main>


<?php include 'includes/footer.php' ?>