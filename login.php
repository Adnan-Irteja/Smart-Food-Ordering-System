<?php 
session_start();
require_once('DBconnect.php');
if (isset($_POST['username']) && 
    isset($_POST['password']) && 
    isset($_POST['role'])) {
    
    $username = $_POST['username'];
    $pwd = $_POST['password'];
    $role = $_POST['role'];
    $query = "SELECT * FROM users WHERE username='$username' AND password = '$pwd' AND role = '$role'";
    $res = mysqli_query($conn,$query);
    if(mysqli_num_rows($res)>0){
        $user = mysqli_fetch_assoc($res);
        
        $_SESSION['login_id'] = $user['login_id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        if($user['role'] == 'restaurant_owner'){
            header("Location: restaurant_dashboard.php");
            exit;
        }
        else{
            header("Location: user_dashboard.php");
            exit;
        }
    }
    else {
        header("Location: index.php?error=invalid_login");
        exit;
    }
}


?>