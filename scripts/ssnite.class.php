<?php
  
 /*
  * SSNITE class for the basic Operations and connections
  * NO objects will be created
  */
 class ssnite{
     public $link;
     public static  $batchYear=21;
     public $result;
    
     public function __construct(){
         ssnite::getConn();
     }
     
     public function logit($volid,$oper,$spec){
         $sql="INSERT INTO log VALUES(0,'$volid','$oper','$spec')";
         $this->exeQuery($sql);
     }
     
     public function getConn(){
        $host="localhost";
        $user="ybom_ssnite";
        $password="password";
        $database="ybom_ssnite";
        $this->link= mysqli_connect($host, $user, $password, $database);
        echo mysqli_error($this->link);
        return $this->link;
     }
     
     public static function generateClassid($year,$dept,$sec){
         $classid=ssnite::$batchYear-$year."".$dept.$sec;
         return $classid;
     }
    
     
    public function sanitize($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    
    function exeQuery($sql){
        $this->result=mysqli_query($this->link,$sql);
        if(mysqli_error($this->link)){
            echo mysqli_error($this->link);
            return false;
        }
        return $this->result;
    }
    function numRows(){
            return mysqli_num_rows($this->result);
    }
    
    public static function createNotification($notice,$audience,$type,$mail=0){
        $sql="INSERT INTO notification VALUES('$notice','$audience','$type')";
        $link=ssnite::getConn();
        mysqli_query($link,$sql);
        
    }
     
 }
 ?>