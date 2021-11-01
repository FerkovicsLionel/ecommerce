<?php 
    include_once 'compose/core.php';

    include_once "login_checker.php";

    include_once 'compose/database.php';
    include_once 'compose/objects/user.php';
    include_once "libs/php/utils.php";
    $database = new Database();
    $db = $database->getConnection();
    
    
    
    include 'includes/header.php';

    if($_POST){
 
        // get database connection
        $database = new Database();
        $db = $database->getConnection();
     
        // initialize objects
        $user = new User($db);
        $utils = new Utils();
     
        // set user email to detect if it already exists
        $user->email=$_POST['email'];
     
        // check if email already exists
        if($user->emailExists()){
            echo "<div class='row'><div class='md-12'><div class='box'><div class='alert alert-none'>";
                echo "Ezzel az e-mail címmel már regisztráltál. Kérlek próbálj meg <a href='login.php'>bejelentkezni.</a>";
                echo "</div></div></div></div>";
            }
     
        else{
        // set values to object properties
        $user->firstname=$_POST['firstname'];
        $user->lastname=$_POST['lastname'];
        $user->password=$_POST['password'];
        $user->access_level='Customer';
        $user->status=1;
    
        // create the user
        if($user->create()){
    
        echo "<div class='row'><div class='md-12'><div class='box'><div class='alert alert-danger'>";
        echo "Regisztrációd sikeresen megtörtént. <a href='login.php'>Kérlek jelentkezz be</a>.";
        echo "</div></div></div></div>";
    
        // empty posted values
        $_POST=array();
    
        }else{
        echo "<div class='row'><div class='md-12'><div class='box'><div class='alert alert-none' role='alert'>Unable to register. Please try again.</div></div></div></div>";
        }
        }
    }
    ?>
<main class="pd-b-130">
    <div class="row">
        <div class="md-12">
            <div class="box">
            <form action='register.php' method='post' id='register' autocomlete="off">

                <h3>Új felhasználó létrehozása e-mail címmel</h3>
                <div class="row-label flexed">
                <label for="" class='flex-1'>
                    <input id='firstname' type="text" class="form-control big-form" name="firstname" placeholder='Vezetéknév' autocomplete="off" required>
                </label>
                <label for="" class='flex-1'>
                    <input id='lastname' type="text" class="form-control big-form" name="lastname" placeholder='Keresztnév' autocomplete="off" required>
                </label>
                
                </div>
                <label for="">
                    <input type="email" name='email' class='form-control big-form' placeholder='E-mail' autocomplete="off" autocomplete='false'>
                </label>
             
                <label for="">
                    <input type="password" name='password' class='form-control big-form' placeholder='Jelszó' autocomplete="off" autocomplete='false'>
                </label>
                <button class='checkout-btn w-100 btn-lg'>Fiók létrehozása</button>

            </div>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="md-12">
            <div class="box">
                <h3>Gyors bejelentkezés</h3>
                <a href="" class='btn btn-block social-btn btn-md'><i class="fab fa-facebook-f"></i>Bejelentkezés Facebook-al</a>
                <a href="" class='btn btn-block social-btn btn-md'><i class="fab fa-google"></i>Google hitelesítés</a>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php' ?>