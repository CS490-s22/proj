<?php 
    //Start session
    session_start();

    //URl of Controller(Middle)
    $url= 'https://afsaccess4.njit.edu//~rsp84/alpha/middle.php';

    $error=[]; // Error Message
    //only run after form submission  
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $user=[
        'username'=>$_POST['ucid'],
        'password'=>$_POST['password']
    ];

    $resource= curl_init();
    curl_setopt_array($resource,[
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS => json_encode($user)    
    ]);

    $result= curl_exec($resource);
    curl_close($resource);
    //decode json into associative array
    $result= json_decode($result,true);

    //if user is found
    if (!$result["error"]){
    $_SESSION['ucid'] = $_POST['ucid'];
    $_SESSION['role'] = $result['role'];
    }
    else{
        $error[] = $result['error'];
    }
    //check role and redirect
    if($result["role"]==="Student"){
        header('Location: https://afsaccess4.njit.edu/~kp673/alpha/student.php');
    }else if($result["role"]==="Professor"){
        header('Location: https://afsaccess4.njit.edu/~kp673/alpha/teacher.php');
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href='app.css'>
    <title>Log In Screen</title>
</head>

<body>
    
    <h1>Log In Screen</h1>
    <!-- Check for errors -->
    <?php if (!empty($error)) : ?>
        <div class="alert alert-danger">
            <div><?php echo $error[0]; ?></div>
        </div>
    <?php endif; ?>

    <form action="index.php" method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">UCID</label>
            <input type="username" class="form-control" name="ucid">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name = "password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</body>

</html>