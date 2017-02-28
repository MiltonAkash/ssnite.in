<?php
require_once 'classid.class.php';
class Volid extends Classid{
    public $volid,$name,$mobile,$mail,$reference;
    function __construct($volid="19CSEAV1"){
        echo $this->volid;
       parent::__construct(substr($volid,0,6));
       $sql="SELECT * FROM volunteer WHERE Id='$volid'";
       $this->exeQuery($sql);
       foreach($this->result as $row){
           $this->name=$row['Name'];
           $this->mobile=$row['Mobile'];
           $this->mail=$row['Mail'];
           $this->reference=$row['Reference'];
       }
    }
    function genVolClassNot($notice,$cat){
        $sql="SELECT * FROM volunteer WHERE Id LIKE '$this->classid'";
        $this->exeQuery($sql);
        foreach($this->result as $res){
            $not=new Notification();
            $not->createNotice($notice,$res['Mail'], $cat);
            
        }
    }
    function isVolunteer($mobile,$password){
        $password=md5($password);
        $sql="SELECT * FROM volunteer WHERE Mobile='$mobile' AND Password='$password'";
        $result=$this->exeQuery($sql);
        if($result){
            $res=mysqli_fetch_assoc($result);
            if($res['Reference']=="INACTIVE")
                return 'INACTIVE';
            else
                return $res['Id'];
        }else{
            return 'UNAUTH';
        }
        
         
    }
    
    function getVolunteers(){
        $sql="SELECT * FROM volunteer WHERE Id Like '$this->classid%'";
        $names=array();
        $this->exeQuery($sql);
        foreach($this->result as $res){
            $names[]=$res['Name'];
        }
        return json_encode($names);
    }
    
    function getVolDetails(){
        echo $this->volid;
        $detail=array("Name"=>$this->name,"Volid"=>$this->volid,"Mobile"=>$this->mobile,"Mail"=>$this->mail,"Reference"=>$this->reference);
        return json_encode($detail);
    }
    
    
//        
//    function mailToVolunteer($text,$subject='General Mail',$from='SSNITE.IN'){
//        mail($mail,$su, $message);
//    }
//    
//    function referVolunteer($mobile,$mail=""){
//        $sql="INSERT INTO VOLUNTEER(Reference,Mail) VALUES('$mobile','$mail')";
//        mysqli_query($this->link,$sql);
//       
//    }
    
    
    
 
    
}





?>