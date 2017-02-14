<?php
session_start();
if (isset($_GET['logout'])) {
  session_unset();
  header("location : http://localhost/getpro");
}
if (isset($_SESSION['username'])) {
    header("Location:http://localhost/getpro/profile/production/profile.php?name=".$_SESSION['username']."&image=".$_SESSION['userimage']); 
}
  $db = mysqli_connect("localhost","root","","getpro");
  if(!$db):
    die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
  endif;
  if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form
    $myusername = $_POST['email'];
    $_SESSION['email123'] = $myusername; 
    $mypassword = $_POST['password']; 
    $sql = "select * from user where user_email = '$myusername' and user_password = '$mypassword'";
    $result = mysqli_query($db,$sql);
    $count = mysqli_num_rows($result);
    // If result matched $myusername and $mypassword, table row must be 1 row
    if($count == 1) {

    $_SESSION['username'] = $result->fetch_assoc()['user_name'];
    $_SESSION['userimage'] = $result->fetch_assoc()['user_image'];
         header("location: http://localhost/getpro/profile/production/profile.php?name=".$result->fetch_assoc()['user_name']."&image=".$result->fetch_assoc()['user_image']);
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>


<?php
/*  GOOGLE LOGIN BASIC - Tutorial
 *  file            - index.php
 *  Developer       - Krishna Teja G S
 *  Website         - http://packetcode.com/apps/google-login/
 *  Date            - 28th Aug 2015
 *  license         - GNU General Public License version 2 or later
*/

// REQUIREMENTS - PHP v5.3 or later
// Note: The PHP client library requires that PHP has curl extensions configured. 

/*
 * DEFINITIONS
 *
 * load the autoload file
 * define the constants client id,secret and redirect url
 * start the session
 */
require_once __DIR__.'/gplus-lib/vendor/autoload.php';

const CLIENT_ID = '70431705953-7mmtg7he56h549sf6vhjr31en0f4f730.apps.googleusercontent.com';
const CLIENT_SECRET = 'XgonUGVsI2zw_2Uk8gWgJYZk';
const REDIRECT_URI = 'http://localhost/getpro';

/* 
 * INITIALIZATION
 *
 * Create a google client object
 * set the id,secret and redirect uri
 * set the scope variables if required
 * create google plus object
 */
$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setScopes('email');

$plus = new Google_Service_Plus($client);

/*
 * PROCESS
 *
 * A. Pre-check for logout
 * B. Authentication and Access token
 * C. Retrive Data
 */

/* 
 * A. PRE-CHECK FOR LOGOUT
 * 
 * Unset the session variable in order to logout if already logged in    
 */
if (isset($_REQUEST['logout'])) {
   session_unset();
}

/* 
 * B. AUTHORIZATION AND ACCESS TOKEN
 *
 * If the request is a return url from the google server then
 *  1. authenticate code
 *  2. get the access token and store in session
 *  3. redirect to same url to eleminate the url varaibles sent by google
 */
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();

  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));


if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $me = $plus->people->get('me');

  // Get User data
  $id = $me['id'];
  $name =  $me['displayName'];
  $email =  $me['emails'][0]['value'];
  $profile_image_url = $me['image']['url'];
  $cover_image_url = $me['cover']['coverPhoto']['url'];
  $profile_url = $me['url'];
  $_SESSION['username'] = $name;
  $_SESSION['email123'] = $email;
  $_SESSION['userimage'] = $profile_image_url;
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: http://localhost/getpro/profile/production/profile.php?id='.$id.'&name='.$name.'&email='.$email.'&image='.$profile_image_url);



} else {
  // get the login url   
  $authUrl = $client->createAuthUrl();
}



}

/* 
 * C. RETRIVE DATA
 * 
 * If access token if available in session 
 * load it to the client object and access the required profile data
 */
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $me = $plus->people->get('me');

  // Get User data
  $id = $me['id'];
  $name =  $me['displayName'];
  $email =  $me['emails'][0]['value'];
  $profile_image_url = $me['image']['url'];
  $cover_image_url = $me['cover']['coverPhoto']['url'];
  $profile_url = $me['url'];

  $_SESSION['username'] = $name;
  $_SESSION['userimage'] = $profile_image_url;
  $_SESSION['email123'] = $email;

} else {
  // get the login url   
  $authUrl = $client->createAuthUrl();
}


?>

<!-- HTML CODE with Embeded PHP-->










<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="prateekgupta22195" content="">

    <title>Business Frontpage - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/business-frontpage.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<style type="text/css">
.bgimg {
    background-image: url('images/hero.gif');
    padding-top: 0.3%;
    padding-bottom: 25%;
    padding-left: 2%;
}
</style>
</head>

<body >
    <div style = "background: black; margin-top: -70px">

<div style="background: black"> <h2 style="color:white; margin-left: 30px;font-family: Times New Roman, Times, serif;">GetPro</h2></div>
        <div class="container" style = "background: black">
            <div class="row">
                <div class="col-md-12">
                    <nav class="navbar navbar-default" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
               <ul class="nav navbar-nav">
                  <li class="active"><a href="http://www.jquery2dotnet.com">Home</a></li>
                  <li><a href="http://www.jquery2dotnet.com">About Us</a></li>
                  <li class="dropdown">
                     <a href="http://www.jquery2dotnet.com" class="dropdown-toggle" data-toggle="dropdown">Pages <b class="caret"></b></a>
                     <ul class="dropdown-menu">
                        <li><a href="http://www.jquery2dotnet.com">Action</a></li>
                        <li><a href="http://www.jquery2dotnet.com">Another action</a></li>
                        <li><a href="http://www.jquery2dotnet.com">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="http://www.jquery2dotnet.com">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="http://www.jquery2dotnet.com">One more separated link</a></li>
                     </ul>
                  </li>
               </ul>
               <form class="navbar-form navbar-left" role="search">
                  <div class="form-group">
                     <input type="text" class="form-control" placeholder="Search">
                  </div>
                  <button type="submit" class="btn btn-default">Submit</button>
               </form>
               <ul class="nav navbar-nav navbar-right">
                  <li><a href="http://localhost/getpro/profile/production/form_validation.php">Sign Up</a></li>
                  <li class="dropdown">
                     <a href="http://www.jquery2dotnet.com" class="dropdown-toggle" data-toggle="dropdown">Sign in <b class="caret"></b></a>
                     <ul class="dropdown-menu" style="padding: 15px;min-width: 250px;">
                        
    <?php
    /*
     * If login url is there then display login button
     * else print the retieved data
    */
    if (isset($authUrl)) {
        echo'<li>
                           <div class="row">
                              <div class="col-md-12">
                                 <form class="form" role="form" method="post" action="" accept-charset="UTF-8" id="login-nav">
                                    <div class="form-group">
                                       <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                       <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" name ="email" required>
                                    </div>
                                    <div class="form-group">
                                       <label class="sr-only" for="exampleInputPassword2">Password</label>
                                       <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" name= "password" required>
                                    </div>
                                    <div class="checkbox">
                                       <label>
                                       <input type="checkbox"> Remember me
                                       </label>
                                    </div>
                                    <div class="form-group">
                                       <button type="submit" class="btn btn-success btn-block">Sign in</button>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div>';



        echo "<a class='login' href='" . $authUrl . "'><img src='gplus-lib/signin_button.png' height='50px' width = '100%'/></a>";

        echo'
</div>





                           
                        </li>
                     </ul>
                  </li>';
    } else {
        print "ID: {$id} <br>";
        print "Name: {$name} <br>";
        print "Email: {$email } <br>";
        print "Image : {$profile_image_url} <br>";
        print "Cover  :{$cover_image_url} <br>";
        print "Url: {$profile_url} <br><br>";
        echo "<a class='logout' href='?logout'><button>Logout</button></a>";
    }
    ?>
               </ul>
            </div>
            <!-- /.navbar-collapse -->
        
      </div>
   </div>
</div>
        <!-- /.container -->
    </nav>
</div>
</div>
</div>
</div>
    <!-- Image Background Page Header -->
    <!-- Note: The background image is set within the business-casual.css file. -->
    <div class="bgimg">
                   <h1 class="tagline">Delivering Knowledge !!! </h1>
             
    </div>
    <!-- Page Content -->
    <div class="container">

        <hr>

        <div class="row">
            <div class="col-sm-8">
                <h2>What We Do</h2>
                <p>We are providing a world class platform to share knowledge around the globe.</p>
                <p>GetPro's objective is to share knowledge related to projects, work analysis, reports, research papers.We work on the user's interest as one can feed his/her interests in sector of technolgy  </p>
                <p>
                    <a class="btn btn-default btn-lg" href="#">Call to Action &raquo;</a>
                </p>
            </div>
            <div class="col-sm-4">

                <h2 >Trending</h2>
                <address>
                <div style = "border : 2px solid #aaaaaa; width : 50%; padding: 1%">
                    <strong style  = "color : #aaaaaa">Trend 1</strong></div>
                    <br>

                <div style = "border : 2px solid #aaaaaa; width : 50%; padding: 1%;margin-top : -4%">
                    <strong style  = "color : #aaaaaa">Trend 2</strong></div>
                </address>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <div class="row">
            <div class="col-sm-4">
                <img class="img-circle img-responsive img-center" src="images/images2.jpeg" alt="">
                <h2>Marketing Box #1</h2>
                <p>These marketing boxes are a great place to put some information. These can contain summaries of what the company does, promotional information, or anything else that is relevant to the company. These will usually be below-the-fold.</p>
            </div>
            <div class="col-sm-4">
                <img class="img-circle img-responsive img-center" src = "images/login1.jpeg" alt="">
                <h2>Marketing Box #2</h2>
                <p>The images are set to be circular and responsive. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
            </div>
            <div class="col-sm-4">
                <img class="img-circle img-responsive img-center" src="images/kaalu1.jpg" alt="">
                <h2>Marketing Box #3</h2>
                <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; GetPro 2017</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
