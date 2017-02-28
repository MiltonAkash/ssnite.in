<?php

 /*
  * Classid For the class Entity.
  * Parameter is  a ClassId
  */
 require_once 'ssnite.class.php';
 include_once 'notification.class.php';
 class Classid extends ssnite{
    public  $year,$dept,$sec,$classid,$yearcode;
    
    public function __construct($classid="19CSEA"){
        parent::__construct();
        $this->classid=$classid;
        $this->updateSYD();
    }
    
    function setClassid($classid){
        $this->classid=$classid;
        $this->updateSYD();
    }
    
    function updateSYD(){
        $this->year=ssnite::$batchYear-substr($this->classid,0,2);
        $this->yearcode=substr($this->classid,0,2);
        $this->sec=substr($this->classid,5,1);
        $this->dept=substr($this->classid,2,3);
    }
    
    function createVolunteer($Name,$Mobile,$mail,$password){
        $password=md5($password);
        $sql="SELECT * FROM volunteer WHERE Id LIKE '$this->classid%'";
        $this->exeQuery($sql);
        $count=$this->numRows();
        $volid=$this->classid."V".($count+1);
        $sql="INSERT INTO volunteer VALUES('$volid','$Name','$Mobile','$password','$mail','INACTIVE')";
        if(!$this->exeQuery($sql)){
             mysqli_error($this->link);
        }
        else{
            $msg="Thankyou for signing up as a volunteer. Once you receive the approval mail you can start uploading the"
                    . "contents.";
            mail($mail,"SSNITE SINGUP",$msg,"FROM: noreply@ssnite.in");
            $obj=new Notification();
            $obj->createVolApproval($volid);
            $this->logit("SITE","ADDVOL","$volid");
            if($count=0){
                $this->addSubject("General","");
            }
            return true;
        }
    }
    
    function getSubject(){
        $sql="SELECT * FROM subjects WHERE SubjectId LIKE '$this->classid%'";
        $result=$this->exeQuery($sql);
        $rows=array();
        if($this->result)
        while($r = mysqli_fetch_assoc($this->result)) {
            $rows[] = $r;
        }
        return json_encode($rows);
        
        
    }
    function createDirectory($subid){
        $pathElement=array($this->year,$this->dept,$this->sec,$subid);
        $path="../uploads/files";
        foreach($pathElement as $curr){
        echo $path;
            $path.='/'.$curr;
            if(!file_exists($path))
               mkdir($path);
        }
        $this->logit("SITE","ADDDIR","$path");

    }
    
    function addSubject($name,$staff){
        echo $this->classid;
        $sql="SELECT MAX(CAST(SUBSTRING(SubjectId,8,2) AS SIGNED)) AS Maxi FROM subjects WHERE SubjectId LIKE '$this->classid%'";
        $this->exeQuery($sql);
        if($this->result){
            $row=  mysqli_fetch_assoc($this->result);
            if($row['Maxi']){
                $count=1+$row['Maxi'];
            }
            else
                $count=1;
        }
        $subid=$this->classid.'S'.$count;
        $sql="INSERT INTO subjects VALUES('$subid','$name','$staff')";
        if($this->exeQuery($sql)){
            $this->createDirectory($subid);
        }
        
        $this->logit("{$_SESSION['volid']}","ADDSUB","$subid");
        
        $sql="INSERT INTO sections VALUES('GENERAL','$subid')";
        return $this->exeQuery($sql);

        
    }
    
    
    
    function getTree(){
        $sql="SELECT * FROM subjects WHERE SubjectId LIKE '{$this->classid}%'";
        $SubjectResult=$this->exeQuery($sql);
        $entity=array();
        foreach($SubjectResult as $res){
            $sql="SELECT Section From sections WHERE SubjectId='{$res['SubjectId']}'";
            $this->exeQuery($sql);
            $sections=array();
            echo mysqli_error($this->link);
            foreach($this->result as $q2){
                $sections[]=$q2['Section'];
            }
            $entity[]=array("Subject"=>$res['SubjectName'],"SubjectId"=>$res['SubjectId'],"Section"=>$sections);
        }
        return json_encode($entity);//$files;
    }
    
  function recursiveRemoveDirectory($directory)
  {
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
  }
    
  function deleteSubject($subid){
      $path="../uploads/files/$this->year/$this->dept/$this->sec/$subid";
      $sql="DELETE From files WHERE SubjectId='$subid'";
      $this->exeQuery($sql);
      $sql="DELETE FROM sections WHERE SubjectId='$subid' ";
      $this->exeQuery($sql);
      $sql="DELETE FROM subjects WHERE SubjectId='$subid'";
      $this->exeQuery($sql);
      $this->recursiveRemoveDirectory($path);
      return 1;
  }
    
    

     
    
    
    
}

?>