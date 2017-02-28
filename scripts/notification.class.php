<?php
include_once 'ssnite.class.php';
class  Notification extends ssnite{
    function createNotice($notice,$to,$cat){
        $sql="INSERT INTO notification VALUES(0,'$notice','$to','$cat',0)";
        $this->exeQuery($sql);
    }
    
//    type- VAPPROVE,

    function createVolApproval($volid){
        include_once 'volid.class.php';
        $obj=new Volid($volid);
        $cat="VOLAPPROVAL";
        $found=0;
        $networks=array();
        $networks[]=$obj->yearcode.$obj->dept.$obj->sec.'%';
        $networks[]=$obj->yearcode.$obj->dept.'%';
        $networks[]=$obj->yearcode.'%';
        $networks[]='%'.$obj->dept.'%';
        $networks[]='%';
        foreach($networks as $network){
            if($found<6)
            foreach($this->getVolunteersLike($network) as $row){
                $this->createNotice($volid,$row['Id'],$cat);
                $found++;
            }
            
        }
        
        
    }
 
    function getVolunteersLike($like){
        $sql="SELECT Id FROM volunteer WHERE Id LIKE '$like' AND Reference != 'INACTIVE'";
        return $this->exeQuery($sql);
    }
    
    function getNotification($volid="%"){
        $sql="SELECT * FROM notification WHERE `To` LIKE '$volid'";
        $notices=array();
        if($this->exeQuery($sql))
        foreach($this->result as $row){
            if($row['Cat']=='VOLAPPROVAL'){
                include_once 'volid.class.php';
                $obj=new Volid($row['Notice']);
                $voldet=array("Volid"=>$row['Notice'],"Name"=>$obj->name,"Year"=>$obj->year,"Sec"=>$obj->sec,"Dept"=>$obj->dept);
                $notices[]=array("Notid"=>$row['NotId'],"Notice"=>$voldet,"Cat"=>$row['Cat'],"To"=>$row['To'],"Read"=>$row['Read']);
            }
            else
            $notices[]=$row;
        }
        return json_encode($notices);
    }
    function getAllVolNotification(){
        $sql="SELECT * FROM notification WHERE Cat='VOLAPPROVAL'";
        $notices=array();
        if($this->exeQuery($sql))
        foreach($this->result as $row){
            if($row['Cat']=='VOLAPPROVAL'){
                include_once 'volid.class.php';
                $obj=new Volid($row['Notice']);
                $voldet=array("Volid"=>$row['Notice'],"Name"=>$obj->name,"Year"=>$obj->year,"Sec"=>$obj->sec,"Dept"=>$obj->dept);
                $notices[]=array("Notid"=>$row['NotId'],"Notice"=>$voldet,"Cat"=>$row['Cat'],"To"=>$row['To'],"Read"=>$row['Read']);
            }
            else
            $notices[]=$row;
        }
        return json_encode($notices);
    }
    
    function acceptVolApproval($volid,$reference){
        $sql="Update volunteer SET Reference='$reference' WHERE Id='$volid'";
        $this->exeQuery($sql);
        $sql="DELETE from notification WHERE Notice='$volid' AND Cat='VOLAPPROVAL'";
        $this->exeQuery($sql);
        return true;  
    }
    
    function deleteNotification($notid){
        $sql="DELETE FROM notification WHERE Notid='$notid'";
        return $this->exeQuery($sql);
        
    }
    
    
    
}
