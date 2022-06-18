<?php
$full = $em = $pass = $coun = $gen = false;
$username = "";
include "../config.php";

//register users
function registerUser($fullnames, $email, $password, $country, $gender){
    //create a connection variable using the db function in config.php
    $conn = db();
    if(isset($_SERVER["REQUEST_METHOD"]))
    {
        if(isset($_POST["fullnames"]))
        {
            if(!empty($_POST["fullnames"]))
            {
                $fullnames = $_POST['fullnames'];
                $GLOBAL['full'] = true;
            }
            else
            {
                $GLOBAL['full'] = false;
            }
        }
        if(isset( $_POST["email"]))
        {
            if(!empty( $_POST["email"]))
            {
                $email = $_POST["email"];
                $GLOBALS['em'] = true;
            }
            else
            {
               $GLOBALS['em'] = false;
            }
        }
        if(isset($_POST["password"]))
        {
            if(!empty( $_POST["password"]))
            {
                $password = $_POST["password"];
                $GLOBALS['pass'] = true;
            }
            else
            {
                $GLOBALS['pass'] = false;
            }
        }
        if(isset($_POST["country"]))
        {
            if(!empty($_POST["country"]))
            {
                $country = $_POST["country"];
                $GLOBALS['coun'] = true;
            }
            else
            {
                $GLOBALS['coun'] = false; 
            }
        }
        if(isset($_POST["gender"]))
        {
            if(!empty($_POST["gender"]))
            {
                $gender = $_POST["gender"];
                $GLOBALS['gen'] = true;
            }
            else
            {
                $GLOBALS['gen'] = false;
            }
        }
        if($GLOBALS['full'] == true || $GLOBALS['em'] == true || $GLOBALS['pass'] == true || $GLOBALS['coun'] == true || $GLOBALS['gen'] == true)
        {
            $sql = "INSERT INTO students(Full_names,Email,Password,Country,Gender) VALUES('$fullnames','$email','$password','$country','$gender')";
            $query = mysqli_query($conn,$sql);
            if($query)
            {
                echo "USER SUCCESSFULLY REGISTERED";
            } 
            else
            {
                echo "error occured";
            }
        }       
            
    }
   //check if user with this email already exist in the database
}


//login users
function loginUser($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();

    //echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    //open connection to the database and check if username exist in the database
    //if it does, check if the password is the same with what is given
    //if true then set user session for the user and redirect to the dashboard
    
        if(isset( $_POST["email"]))
        {
            if(!empty( $_POST["email"]))
            {
                $email = $_POST["email"];
                $GLOBALS['em'] = true;
            }
            else
            {
               $GLOBALS['em'] = false;
            }
        }
        if(isset($_POST["password"]))
        {
            if(!empty( $_POST["password"]))
            {
                $password = $_POST["password"];
                $GLOBALS['pass'] = true;
            }
            else
            {
                $GLOBALS['pass'] = false;
            }
        }
        if($GLOBALS['em'] == true || $GLOBALS['pass'] == true)
        {
            $username = mysqli_real_escape_string($conn,$_POST["email"]);
            $upassword = mysqli_real_escape_string($conn,$_POST["password"]);
            $sql = "SELECT * FROM students where Email = '$username' AND Password = '$upassword'";
            if($query = mysqli_query($conn,$sql))
            {      
                $row = mysqli_num_rows($query);
                if($row == 0)
                {
                    //echo "user does not exist";
                    header("location:../forms/login.html");
                }
                else
                {
                    session_start();
                    $_SESSION["response"] = array(
                        "username"=>"$email","userpassword"=>"$password"
                    );
                     header("location:/userAuthMySQL/dashboard.php");
                }  
            }
            else
            {
                echo "error occured";
            }
        }
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    //echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    //if it does, replace the password with $password given
        $sql = "UPDATE students SET Password = '$password' where Email = '$email'";
        $query = mysqli_query($conn,$sql);
        if($query)
        {
            //echo "success";
           header("location:/userAuthMySQL/forms/login.html");
        }
        else
        {
            echo "error occured";
        }
        
    
}

function getusers()
{
    $conn = db();
$sql = "SELECT * from students";
$result = mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        table,th,td{
            border:1px solid black;
        }
    </style>
</head>
<body>
    
<center><h1><u> ZURI PHP STUDENTS </u></h1> </center>
    <table style= "background-color: magenta;" width = "100%" border-style ="none">
        <thead>
            <tr style='height: 40%'>
                <th>ID</th>
                <th>Full Names</th> 
                <th>Email</th>
                <th>Gender</th>
                <th>Country</th>
                <th>Action</th>
            </tr>
        </thead>
            <tbody>
         <?php
            if(mysqli_num_rows($result) > 0)
             {
               while($data = mysqli_fetch_assoc($result))
               {
            
            //show data
            ?>
             <tr style='height: 30px'>
                <td style= "background:blue;" width = "50px"><?php if(isset($data["id"])) echo $data['id'];?></td>
                <td><?php if(isset($data["Full_names"])) echo $data["Full_names"];?></td> 
                <td><?php if(isset($data["Email"])) echo $data["Email"];?></td>
                <td><?php if(isset($data["Gender"])) echo $data["Gender"];?></td>
                <td><?php if(isset($data["Country"])) echo $data["Country"];?></td>
                <td><a href = "action.php?id=<?php echo $data["id"];?>">DELETE</a></td>
             </tr>
        <?php
        }
    } 
    ?>
             </tbody>
            </table>
            </body>
            </html>
     <?php
} 
           
  
    
 function deleteaccount($id)
 {
     $conn = db();
     //delete user with the given id from the database
    $sql = "DELETE FROM students where id = '$id'";
    $query = mysqli_query($conn,$sql);
    if($query)
    {
        header("location:/userAuthMySQL/php/action.php?all");
    }
    else
    {
        echo "error occured";
    }

 }
?>