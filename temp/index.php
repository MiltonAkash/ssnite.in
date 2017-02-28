<!DOCTYPE html>
<?php
    if(isset($_POST['name'])){
    $username=$_POST['name'];
    if(!$username){
        $username="def";
    }
    if(!file_exists($username))
        mkdir($username);
    
    if(!$_FILES['fileToUpload']['name']){
        echo "NO filetouload";
    }
    else
    foreach($_FILES['fileToUpload']['name'] as $f=>$name){
            $name=$_FILES['fileToUpload']['name'][$f];
            $tmp_name=$_FILES['fileToUpload']['tmp_name'][$f];
            if(file_exists($username.'/'.$name)){
                continue;
            }
            elseif(!move_uploaded_file ($tmp_name,$username.'/'.basename($name))){
                continue;
            }
            else{
                if(mail("mil10akash@gmail.com","upload ssnite","SOomeone upload file  $username ")){};
                echo "<script>alert('ThankYou')</script>";
            }
    }
    }
    
    
    
?>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
        <title>SSNITE</title>
    </head>
    <style>
        body{
            display:flex;
            height:100vh;
            width:100vw;
            justify-content: center;
            align-items: center;
            /*background:url('square cm-01.jpg');*/
            background:#0099cc radial-gradient(rgba(255,255,255,1),rgba(255,255,255,0));
        }
        content{
            display:flex;
            justify-content: space-around;
            background:rgba(255,255,255,0.7);
        }
        form{
            padding:10px;
        }
        input{
            padding:5px;
        }
        img{
            max-height:200px;
            
        }
        form{
            display:flex;
            flex-direction:column;
            justify-content: space-around;
            
        }
        
        @media only screen and (max-width:650px){
            content{
                flex-direction:column;
            }
            form *{
                margin-top:5px;
            }
        }
    </style>
    <body>
        <content>
            <img src="square cm-01.jpg"/>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <label for="fileToUpload">Upload Photos:(single/multiple)</label>
                <input type="file" required name="fileToUpload[]"/>
                <label>Your Name:</label>
                <input type="text" required name="name"/>
                <input type="submit" value="Upload"</input>
            </form>
        </content>
    </body>
    
    <?php
    $dir="/";
    if (is_dir($dir)){
        if ($dh = opendir($dir)){
        while (($file = readdir($dh)) !== false){
        echo "filename:" . $file . "<br>";
    }
    closedir($dh);
  }
}
    
    ?>
</html>
