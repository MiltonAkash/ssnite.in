<?php 
session_start();
include_once 'classid.class.php';
$purpose=$_POST["purpose"];

switch($purpose){
    case "uploadFile":
        include_once 'subid.class.php';
        $subid=$_POST['subid'];
        $section=$_POST['section'];
        $objsub =new Subid($subid);
        echo $objsub->uploadFiles($subid,$section);
        break;
    case "addSubject":
        include_once 'volid.class.php';
        $obj=new Volid($_SESSION['volid']);
        echo $obj->addSubject($_POST['subject'],$_POST['staff']);
        break;
    case "addSection":
        include_once 'subid.class.php';
        $obj=new Subid($_POST['subject']);
        echo $obj->createSection($_POST['section']);
        break;
    case "updateFile":
        include_once 'subid.class.php';
        $obj=new Subid($_POST['subject']);
        echo $obj->updateFile($_POST['name'],$_POST['section'],$_POST['filename']);
        break;
    case "swapFileId":
        include_once 'subid.class.php';
        $obj=new Subid($_POST['subject']);
        echo $obj->swapFileId($_POST['one'],$_POST['two']);
        break;
    case "deleteFile":
        include_once 'subid.class.php';
        $obj=new Subid();
        echo $obj->deleteFile($_POST['fileid'],$_POST['filename']);
        break;
    case "getFiles":
        include_once'subid.class.php';
        $obj=new Subid($_POST['subid']);
        echo $obj->getFiles();
        break;
    case "getTree":
        include_once "volid.class.php";
        $obj=new Volid($_SESSION["volid"]);
        echo $obj->getTree();
        break;
    case "getVolDetails":
        include_once "volid.class.php";
        $obj=new Volid($_SESSION['volid']);
        echo $obj->getVolDetails();
        break;
    case "getNotifications":
        include_once 'notification.class.php';
        $obj=new notification();
        echo $obj->getNotification($_SESSION['volid']);
        break;
    case "getAllVolNotifications":
        include_once 'notification.class.php';
        $obj=new notification();
        echo $obj->getAllVolNotification();
        break;
    
    case "acceptVolApproval":
        include_once 'notification.class.php';
        $obj=new notification();
        echo $obj->acceptVolApproval($_POST['volid'],$_SESSION['volid']);
        break;
    case "deleteNotification":
        include_once 'notification.class.php';
        $obj=new notification();
        echo $obj->deleteNotification($_POST['Notid']);
        break;
    case "getClassVolunteers":
        include_once 'volid.class.php';
        $obj=new Volid($_SESSION['volid']);
        echo $obj->getVolunteers();
        break;
    case "deleteSubject":
        include_once 'subid.class.php';
        $obj=new Subid($_POST['subid']);
        $obj->deleteSubject($_POST['subid']);
        break;
    case "deleteSection":
        include_once 'subid.class.php';
        $obj=new Subid($_POST['subid']);
        $obj->deleteSection($_POST['section']);
        break;
   
        
}

?>
