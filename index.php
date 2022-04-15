<?php session_start(); ?>
<html>
    
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DTU Examination Portal</title>
</head>

<?php
if (isset($_POST['login'])) 
{
    if (isset($_POST['usertype']) && isset($_POST['username']) && isset($_POST['pass'])) {
        $conn = mysqli_connect('localhost', 'root', '', 'project');
        if (!$conn) {
            echo "<script>alert(\"Database error retry after some time !\")</script>";
        }
        $type = mysqli_real_escape_string($conn, $_POST['usertype']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['pass']);
        $password = crypt($password, 'absaarandarayan');
        $sql = "select * from " . $type . " where mail='{$username}'";
        $res =   mysqli_query($conn, $sql);
        if ($res == true) {
            global $dbmail, $dbpw;
            while ($row = mysqli_fetch_array($res)) {
                $dbpw = $row['pw'];
                $dbmail = $row['mail'];
                $_SESSION["name"] = $row['name'];
                $_SESSION["type"]=$type;
                $_SESSION["username"]=$dbmail;
            }
            if ($dbpw === $password) {
                if($type==='student'){
                    header("location:homestud.php");
                }elseif($type==='staff'){
                    header("location:homestaff.php");
                }
            } elseif ($dbpw !== $password && $dbmail === $username) {
                echo "<script>alert('password is wrong');</script>";
            } elseif ($dbpw !== $password && $dbmail !== $username) {
                echo "<script>alert('username name not found sing up');</script>";
            }
        }
    }
}
?>

<style>
    @media screen and (max-width: 620px) {
        input {
            height: 6vw !important;
        }

        .seluser {
            display: grid;
        }

        .sub {
            width: 20vw !important;
        }
    }

    .inp {
        width: 30vw;
        height: 3vw;
        border-radius: 10px;
        border: 2px solid black;
        padding-left: 2vw;
        font-weight: bolder;
        outline: none;
    }

    ::placeholder {
        font-weight: bold;
        font-family: 'Courier New', Courier, monospace;
    }

    label {
        font-weight: bolder;
        font-size: 1.5vw;
    }

    form {
        font-size: 1.5vw;
        margin: 0;
    }

    button:hover {
        background-color: #fff !important;
    }

    .bg {
        background-size: 100%;
    }

    a {
        color: #817f7f;
    }
</style>

<body style="margin:0">
    <div class="bg" style="font-weight: bolder; background-image: url(./images/images2.png); background-size: cover; text-transform: uppercase; font-family: 'Courier New'; opacity: 0.9; height: 100%;">
        <center>
            <h1 style=" color:rgb(255, 255, 255); width: auto; background:rgb(0, 0, 0);padding: 1vw;">DTU examination protal</h1>
        </center>
        <center>
            <div class="login" style="color: rgb(0, 0, 0); width: 40vw; background-color: rgb(255, 255, 255); border: 2px solid black; padding: 2vw; margin-top: 10vh; border-radius: 10px;">
                <form method="POST">
                    <div class="seluser">
                        <input type="radio" name="usertype" value="student" required>STUDENT
                        <input type="radio" name="usertype" value="staff" required>STAFF
                    </div>
                    <br>
                    <br>
                    <div class="signin">
                        <label for="username">Username</label><br><br>
                        <input type="email" name="username" placeholder=" Email" class="inp" required>
                        <br><br>
                        <label for="password">Password</label><br><br>
                        <input type="password" name="pass" placeholder="*******" class="inp" required>
                        <br><br>
                        <input name="login" class="sub" type="submit" value="Login" style="height: 3vw;width: 10vw;font-family: 'Courier New', Courier, monospace; border-radius: 10px;border: 2px solid black;background-color:lightblue">
                        <br>
                    </div>
                </form>
                <br>
                <div style="color:rgb(0, 0, 0)"> 
                    <a href="reset.php" style="color:#2284fd;">Forgot password?</a> &nbsp; New user! <a href="signup.php" style="color:#2385fc;">SIGN UP</a>
                </div>
            </div>
        </center>
    </div>
</body>

</html>