<?php
$myname = $_POST['myname'];
$myemail = $_POST['myemail'];
$mypassword= $_POST['mypassword'];
$myaddress= $_POST['myaddress'];
$mynumber= $_POST['mynumber'];
$myfeedback = $_POST['myfeedback'];
$submit = $_POST['submit'];

if(!empty($myname)|| !empty($myemail) || !empty($mypassword) || !empty($myaddress) || !empty($mynumber) || !empty($myfeedback) || !empty($submit)){

    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "pizzeria_contact_us";

    $conn = mysqli_connect($servername, $username, $password,$dbname); 

    if(mysqli_connect_error()){
       die('Connect Error('. mysqli_connect_errno().')'.mysqli_connect_error());

    }else{
        $SELECT = "SELECT myemail From  contact_form Where myemail = ? Limit 1";
        $INSERT  = "INSERT Into contact_form (myname, myemail ,mypassword ,myaddress, mynumber, myfeedback,submit) values(?,?,?,?,?,?,?)";
    
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s",$myemail);
        $stmt->execute();
        $stmt->bind_result($myemail);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        if($rnum == 0){
            $stmt ->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssisiss", $myname, $myemail ,$mypassword ,$myaddress, $mynumber, $myfeedback,$submit);
            $stmt->execute();
            echo"All new record inserted successfully.";
        }else{
            echo"someone already register using this email";
        } 
        $stmt->close();
        $conn->close();  
    }
}
else{
    echo"ALl field are required";
    die();

}
?>