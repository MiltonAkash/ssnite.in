<?php 
session_start();
include_once 'classid.class.php';
$purpose=$_POST["purpose"];

switch($purpose){
    case "getSubjects":
        $obj=new Classid($_POST['classid']);
        echo $obj->getSubject();
        $_SESSION["classid"]=$_POST['classid'];
        break;
    case "getFiles":
        require_once 'subid.class.php';
        $obj=new Subid($_POST['subid']);
//        $obj=new Subid("19CSEAS1");
        echo $obj->getFiles();
        break;

    case "getSessionClassid":
        $classObj=new Classid($_SESSION['classid']);
        echo json_encode($classObj);
        break;
}

?>
