<?php 
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 365);
session_start();
if(isset($_GET['logout'])){
    $_SESSION['volid']=NULL;
    header("location:../");
}
elseif(isset($_SESSION['volid'])){
       $volid=$_SESSION["volid"];
}
elseif(isset($_POST['mobile'])){
    include_once '../scripts/volid.class.php';
    include_once '../scripts/subid.class.php';
    $obj=new Volid();
    if(empty($_POST['mobile'])||empty($_POST['password'])){
        header("location:../?er=unathorized");        
        
    }
    $volStatus=$obj->isVolunteer($_POST['mobile'],$_POST['password']);
    if($volStatus==""){
        header("location:../?er=unathorized");        
    }
    elseif($volStatus=="UNAUTH")
        header("location:../?er=unathorized");        
    elseif($volStatus=="INACTIVE")
        header("location:../?er=inactive");
    else{
        $volid=$volStatus;
        $_SESSION["volid"]=$volid;    
    }
}
else{
    header("location:../signup/");
}
?>
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <title>VPANEL </title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <script src="../client/angular.min.js"></script>
        <script src="../client/jquery.js"></script>
        <script src="../client/jquery.form.min.js"></script>
        <script src="vpanel.js"></script>
          <link rel="icon" type="image/x-icon" href="../favicon.ico" />

        <link rel='stylesheet' href='../client/flexboxgrid.css'/>
        <!--<link rel="stylesheet" href="vpanel.css"/>-->
        <link rel="stylesheet" href="vpanelprefix.css"/>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="../client/font-awesome-4.5.0/css/font-awesome.min.css"/>

        <!--<link rel="stylesheet" href="components.css"/>-->
    </head>
    <body ng-app="vpanel" ng-controller="vpanelctrl">
        <leftnav>
            <div class='notice'>
                <a class=btn href="?logout=1"><span class='fa fa-sign-out'></span>LOGOUT</a>
            </div>
            <div class='notice'>
                <a class=btn href="../"><span class='fa fa-home'></span>HOMEPAGE</a>
            </div>
            <div class='notice'>
                <a class=btn href="../faq"><span class='fa fa-hand-o-up'></span>INSTRUCTIONS & FAQ</a>
            </div>
            <div class='notice'>
                <a class=btn href="https://chat.whatsapp.com/D4Kawe28qw87LqTLBmdSD5"><span class='fa fa-whatsapp'></span>JOIN WHATSAPP GROUP. (only mobile)</a>
            </div>
            <div class='notice'>
                <a class=btn href="https://www.facebook.com/groups/i2ivolunteers/"><span class='fa fa-facebook'></span>JOIN FB GROUP</a>
            </div>
            <div class='notice'>
                <a class=btn ng-click="getAllVolNotifications()">Show all Inactive volunteers</a>
            </div>
            
            
            <div ng-repeat="notification in notifications">
                <notice  ng-if=(notification.Cat=='VOLAPPROVAL')>
                    <p>Do you want to Approve {{notification.Notice.Name}} of Year {{notification.Notice.Year}}
                        from {{notification.Notice.Dept}}-{{notification.Notice.Sec}} as a Volunteer?</p>
                    <button ng-click='volApprove(notification.Notice.Volid)'> YES </button>
                    <button ng-click='delNotice(notification.Notid)'> NO </button>
                </notice>
            </div>
            
        </leftnav>
        <content>
            <header class='row '>
<!--                <openclose class="active">
                    <bar></bar>
                    <bar></bar>
                    <bar></bar>
                </openclose>-->
<img style='max-width:40px;' src='../drawable/ssnite-cmstyle inverse.svg'/>
                <h1>SSNITE | VPANEL<h1>
            </header>
            <div class="bluePanel">
                <p class='panelTitle'>Add Subject</p>
                <form id='addSubjectForm' method='post' action='../scripts/ajaxvpanel.php'>
                    <input type='hidden' name='purpose' value='addSubject'/>
                    <input type="text" placeholder='Subject Name'  name='subject'/>
                    <input type="text" placeholder='Staff Name' name="staff"/>
                    <input type="submit"  name="Add Subject"/>
                </form>
            </div>
            <div  class="bluePanel">
                <p class='panelTitle'>Add Sub-division</p>
                <form id='addSectionForm' method="post" action="../scripts/ajaxvpanel.php">  
                    <input type='hidden'  name='purpose' value='addSection'/>
                    <select name="subject" ng-options='x.Subject for x in tree track by x.SubjectId' ng-model='addSubjectSec'>
                    </select>
                    <input type="text" placeholder="Section Name" name="section"/>
                    <input type="submit" name="Add Section"/>
                </form>
            </div>
                
            <div   class='filePanel'>

                <form class='selectionPanel'>
                    <select ng-options="x.Subject for x in tree track by x.Subject" ng-change='updateSection()'ng-model="selectSubject"></select>
                    <select ng-options="x for x in selectSubject.Section track by x" ng-change="updateFiles()" ng-model="selectSection"></select>
                </form>
            </div>
            <div ng-show="selectSection"  class='filePanel' style='max-width:100vw;overflow-x:scroll;'>

                <table  >
                    <tr>
                        <th>Display Name</th>
                        <th>FIleName</th>
                        <th>Update</th>
                        <th>MoveUp</th>
                        <th>Delete</th>
                    </tr>
                    <tr class='{{$index}}' ng-repeat='file in files' ng-model='fileee'>
                        <td>
                            <input name="fileid" type=hidden value="{{file.FileId}}"/>
                            <input name='name'  ng-change='updateList($index)'  ng-model='file.Name' type='text' value='{{file.Name}}'/>
                        </td>
                        <td>
                            <input type="hidden" value="{{file.FileName}}" name="filename"/>
                           {{file.FileName}}
                        </td>
                        <td>
                        <span class="fa fa-pencil"  ng-click='updateList($index)' value='Up'></span>
                        </td>
                        <td>
                        <span class="fa fa-angle-up"  ng-click='moveup($index)' value='Move Up'></span>
                        </td>
                        <td>
                        <span class="fa fa-trash"  ng-click='deleteFile($index)' value='delete'></span>
                            
                        </td>
                    </tr>
                </table>
            </div>
            <div ng-show="selectSection" class='filePanel uploadPanel''>

                <form  class='row' method='post' id="upload" enctype="multipart/form-data" action='../scripts/ajaxvpanel.php'>
                        <input type='hidden'  name='purpose' value='uploadFile'></input>
                        <input type='hidden' name='subid' value='{{selectSubject.SubjectId}}'></input>
                        <input type='hidden' name='section' value='{{selectSection}}'></input>
                        <div class='upFile'  onclick="document.getElementById('inputfile').click();">
                            Upload
                        </div>
                        <input class='col-md-4'style='display:none' onchange="document.getElementById('uploadButton').click();" id='inputfile' type='file' multiple name='fileToUpload[]'></input>
                        <progress class='col-md-4' label='asd' value='0' max='100'></progress>
                        <input class='col-md-4' type='submit' style='display:none;' id="uploadButton" value='upload'/>
                        <button ng-hide=(uploadStatus==null) class='upFile' ng-click='uploadStatus=[]' ng-model='clrBtn'>CLEAR Upload Status</button>
                </form>
                <table>
                        <tr ng-repeat='filed in uploadStatus'>
                            <td>{{filed.FileName}}</td>
                            <td>{{filed.Status}}</td>
                        </tr>
                </table>
            </div>
            <div class="filePanel">
                <button class="delete" ng-if='selectSubject' ng-click="deleteSubject()">Delete subject {{selectSubject.Subject}}</button>
                <button class='delete' ng-if='selectSection' ng-click="deleteSection()">Delete sub-division {{selectSection}}</button>
               
            </div>
            <div class='filePanel vollist'>
                <p class='panelTitle'>Volunteers</p>
                <ul>
                    <li ng-repeat='name in vol'>{{name}}</li>
                </ul>
            </div>
            <div class='filePanel vollist'>
                <p class='panelTitle'>ABOUT YOu</p>
                <ul>
                    <li>{{volunteer.Name}}</li>
                    <li>{{volunteer.Mobile}}</li>
                    <li>{{volunteer.Mail}}</li>
                </ul>
            </div>
<!--            <div>
                <form>
                    
                    <input type="name" value="{{volunteer.Name}}"/>
                    <input type="name" value="{{volunteer.Mobile}}"/>
                    <input type="name" value="{{volunteer.Mail}}"/>
                    <input type="name" value="{{volunteer.Reference}}"/>
                    <input type="name" value="{{volunteer.}}"/>
                </form>
                
            </div>-->
        </content>
    </body><script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89125855-1', 'auto');
  ga('send', 'pageview');

</script>
   
</html>
