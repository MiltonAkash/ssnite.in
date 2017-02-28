<?php

require_once 'classid.class.php';
class Subid extends Classid{
    public $subid,$name;
    function __construct($subid="19CSEAS1"){
       parent::__construct(substr($subid,0,6));
       $this->subid=$subid;
       $this->exeQuery("SELECT SubjectName from subjects where SubjectId='$subid'");
       $row=mysqli_fetch_assoc($this->result);
       $name=$row['SubjectName'];
    }
    function uploadFiles($subid,$section){
        $uploadStatus=array();
        
        $path="../uploads/files/$this->year/$this->dept/$this->sec/$this->subid/";
        foreach($_FILES['fileToUpload']['name'] as $f=>$name){
            $name=$_FILES['fileToUpload']['name'][$f];
            $tmp_name=$_FILES['fileToUpload']['tmp_name'][$f];
            if(file_exists($path.$name)){
                $uploadStatus[]=array("FileName"=>$name,"Status"=>"EXIST");
                continue;
            }
            elseif(!move_uploaded_file ($tmp_name,$path.basename($name))){
                $uploadStatus[]=array("FileName"=>$name,"Status"=>"FAILURE");
                continue;
            }
            else{
                $uploadStatus[]=array("FileName"=>$name,"Status"=>"SUCCESS");
                $sql="INSERT INTO files VALUES(0,'$subid','{$_SESSION['volid']}','$name','$name','$section')";
                $this->exeQuery($sql);
                $this->logit("{$_SESSION['volid']}","UPLFILE","$this->subid.$name");
               
            }
        }
        return json_encode($uploadStatus);
    }
    
    function createSection($sectionName){
        $sql="INSERT INTO sections VALUES('$sectionName','$this->subid')";
         $this->logit("{$_SESSION['volid']}","ADDSEC","$this->subid.$sectionName");
        return $this->exeQuery($sql);
    }
    
    
    function getFiles(){
        $sql="SELECT Section FROM files WHERE SubjectId='{$this->subid}' Group By Section";
        $SectionResult=$this->exeQuery($sql);
        $files=array();
        foreach($SectionResult as $res){
            $sql="SELECT FileId,Name,FileName FROM files WHERE SubjectId='{$this->subid}' AND Section='{$res['Section']}' ORDER BY FileId";
            $this->exeQuery($sql);
            $sections=array();
            echo mysqli_error($this->link);
            foreach($this->result as $q2){
                $sections[]=$q2;
            }
            $files[]=array("Section"=>$res['Section'],"Files"=>$sections);
        }
        return json_encode($files);//$files;
    }
    
    function getFilePath($filename){
        return "../uploads/files/$this->year/$this->dept/$this->sec/$this->subid/$filename";
    }
    function updateFile($name,$section,$filename){
        $sql="UPDATE files SET Name='$name',Section='$section' WHERE FileName='$filename'";
        $this->exeQuery($sql);
        $this->logit("{$_SESSION['volid']}","UPDFILE","$filename.$name");
    }
    
    function deleteFile($fileid,$filename){
        $sql="Delete FROM files WHERE FileId='{$fileid}' AND FileName='{$filename}'";
        $this->exeQuery($sql);
         $this->logit("{$_SESSION['volid']}","DELFILE","$this->subid.$filename");
        if(file_exists($this->getFilePath($filename)))
            unlink($this->getFilePath($filename));
    }
    
    function swapFileId($one,$two){
        $sql="update files Set FileId=case when FileId=$one Then $two when FileId=$two Then $one ELSE FileId End";
        $this->exeQuery($sql);
    }
    
    
    function deleteSection($section){
        $sql="SELECT FileName From files WHERE SubjectId='$this->subid' AND Section='$section'";
        $this->exeQuery($sql);
        foreach($this->result as $res){
            $file=$this->getFilePath($res['FileName']);
            if(file_exists($file))
                    unlink($file);
        }
        $sql="DELETE FROM files WHERE SubjectId='$this->subid' AND Section='$section'";
        $this->exeQuery($sql);
        
        $sql="DELETE FROM sections WHERE SubjectId='$this->subid' AND Section='$section'";
        $this->logit("{$_SESSION['volid']}","DELSEC","$this->subid.$section");
        return $this->exeQuery($sql);
    }
    
    
    
//    function swapFile($file1,$file2,$weight1,$weight2){
//        $sql="UPDATE "
//    }
   
}


?>