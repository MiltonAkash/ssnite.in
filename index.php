<?php 
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 365);
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 365);
session_start();
if(!isset($_SESSION['classid']))
    $_SESSION["classid"]="19CSEA";

if(isset($_GET['er'])){
    $msg=$_GET['er'];
}
?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <title>SSNITE</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
        <script src="client/angular.min.js"></script>
        <script src="client/jquery.js"></script>
        <script src="index/index.js"></script>
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
        <link rel='stylesheet' href='index/index2.css'/>
        <link rel='stylesheet' href='client/font-awesome-4.5.0/css/font-awesome.min.css'/>
    </head>
    <body class='row' ng-app="homepage" ng-controller="homectrl">
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.8&appId=399009673779547";
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));
        </script>
   <div id='facebook' class='modal'>
        <div style='background:radial-gradient(#0099cc,#3399ff)' class='modal-content'>
            <h1>Connect with Us on Facebook</h1>
            <a href='https://facebook.com/ssnite'>Click Here</a>
            <close class='close' onclick="document.getElementById('facebook').style.display='none'">close</close>
        </div>
    </div>

    <div id='aboutus' class='modal'>
        <div class='modal-content'>
            <h1>ABOUT-US</h1>
            
            <p style='max-width:960px;line-height:45px;'>
                ssnite.in is a website that caters to the need of dayscholar students who have 
                no access to the intranet site outside the college premises . This is a student-friendly 
                website and it is not a step that was taken to offend the college management. 
                This is a non-profit website, i.e , we have zero intention of making money and the contents 
                published here are solely for the beneficial aspect of students. We do not 
                show partiality towards department, batch or group. We are open to queries and 
                suggestions from your side and the polls that we create here are completely genuine.
                You have the complete freedom to share things here. We have enabled an algorithm that 
                would limit the website’s access to ssn students explicitly and this algorithm will 
                be activated if the faculties do not feel free to share their contents online.
                And finally, we attribute the inception and success of this site to volunteers 
                without whom this venture would have failed to reach its destination!  
            </p>
            <close onclick="this.parentElement.parentElement.style.display='none'">close</close>
        </div>
    </div>
    <div id='terms' class='modal'>
        <div  class='modal-content'>
            <h1>TERMS & CONDITIONS</h1>
            <p style='max-width:960px;line-height:45px;'>
                <strong>
                    Any participation in this site will constitute acceptance of the following terms.
                    If you do not agree to abide by the above,
                    Please do not use this site. 
                </strong>
            <ul  style='max-width:960px;line-height:45px;'>
            <li>  The files that are published in this website belong to the staff of SSNCE.
            <li>  We have the authority to terminate the users and volunteers access to the site if you adhere to spamming and swearing.

            <li>  The content of the pages of this website is for your general information and use only and it is subject to change without prior notice.
            <li>  Your use of any information or materials on this website is entirely at your risk for which we shall not be liable. It is your own responsibility to ensure that the contents available on this website satisfy your requirements.
            <li>  At times, this website might include links to other websites that are provided for your convenience to provide further information. This does not signify that we endorse the website and we are not responsible for the content of the linked websites. 
            </ul>


            </p>
            <close onclick="this.parentElement.parentElement.style.display='none'">close</close>
        </div>
    </div>
        
        <leftnav>
            <form class='loginForm' method='post' action="vpanel/">
                <?php
                    if(!isset($_SESSION['volid'])):
                ?>
                <input  placeholder='Mobile Number' name="mobile" type="number"></input>
                <input  placeholder='password' name="password" type="password"></input>
                <input class='btn' type="submit" value="Login"></input>
                <a class='btn' href="signup/"><span class='fa fa-user-plus'></span> SIGN UP</a>
                <?php
                    else:
                        include_once './scripts/volid.class.php';
                        $volObj=new Volid($_SESSION['volid']);
                ?>
                <notice>HI ! <?php echo $volObj->name ?></notice>
                <a class='btn' href="vpanel/"><span class='fa fa-sliders'></span>VPANEL</a>
                <?php
                    endif;
                ?>
            </form>
            <div>
                <?php if(isset($msg)):
                    ?>
                <notice>
                    <?php echo $msg?>
                </notice>
                <?php endif; ?>
                <notice style='background:rgba(245,245,245,0.8);'>
                    <div class="fb-like" data-href="http://facebook.com/ssnite" data-width="150" data-layout="standard" data-action="like" data-size="large" data-show-faces="true" data-share="true"></div>
                </notice>
                <notice>Welcome to SSNITE.IN</notice>
                <notice>Contents will be uploaded soon</notice>
                
                <notice>Welcome to SSNITE.in</notice>
            </div>
        </leftnav>
        <content>
            <header>
                <img src="drawable/ssnite-cmstyle inverse.svg"/>
                <h1>SSNITE.IN</h1>
            </header>
            <slideshow>
                <img src='scripts/image.php?src=/showcase/1.jpg&w=1600&q=50' />
                <img src='scripts/image.php?src=/showcase/2.jpg&w=1600&q=50' />
                <img src='scripts/image.php?src=/showcase/3.jpg&w=1600&q=50' />
                <img src='scripts/image.php?src=/showcase/4.jpg&w=1600&q=50' />
            </slideshow>
            <slidenav class="distribute">
                <navbox> Narasimma</navbox>
                <navbox>Saktheeswaran Kalidass</navbox>
                <navbox>Lalith Venkatesh</navbox>
                <navbox> Lalith Venkatesh</navbox>
            </slidenav>
            <stats class="distribute">
                <statbox>
                    <number>32</number>
                    <category> Volunteers</categpru>
                </statbox>
                <statbox>
                    <number>0</number>
                    <category>Files</categpru>
                </statbox>
                <statbox>
                    <number>0</number>
                    <category>  Downloads</categpru>
                </statbox>
            </stats>
            <div id="select-content" class="distribute">
                <select  class='yes-padding yes-margin col-xs' ng-options="x for x in year"  ng-change='updateSub()' ng-model="optYear"></select>
                <select  class='yes-padding yes-margin col-xs' ng-options="x.Name for x in dept track by x.Code"  ng-change='updateSub()' ng-model="optDept"></select>
                <select ng-disabled="optDept.Code=='CIV'||optDept.Code=='BME'" class='yes-padding yes-margin col-xs'  ng-options="x for x in sec"   ng-change='updateSub()' ng-model="optSec"></select>
                <select ng-disabled="optSub.SubjectName==='No subjects added'" class='yes-padding yes-margin col-xs' ng-options="x.SubjectName for x in sub" ng-change='updateFiles()' ng-model="optSub"></select>
            </div>
            <p id="about-content" ng-if='!filelist.length'>No files uploaded for this subject.<a href='signup' >Click Here</a> to enroll
            as a volunteer and upload files</p>
            <p id='about-content' ng-if='optSub.Staff' class='staff'>These contents belongs to {{optSub.Staff}}</p>

            <div  class='fileList'>
                <table>
                    <tbody ng-repeat="sec in filelist">
                        <tr>
                            <th colspan="3" class='sectionCell'>
                                    <strong>{{sec.Section}}</strong>
                            </th>
                        </tr>
                        <tr ng-repeat="file in sec.Files">
                            <td>{{file.Name}}</td>
                            <td>
                                <a target="_blank" href="{{'uploads/files/'+optYear+'/'+optDept.Code+'/'+optSec+'/'+optSub.SubjectId+'/'+file.FileName}}">
                                    <span class='fa fa-eye'/>
                                </a>
                            </td>
                            <td>
                                <a download href="{{'uploads/files/'+optYear+'/'+optDept.Code+'/'+optSec+'/'+optSub.SubjectId+'/'+file.FileName}}">
                                    <span class='fa fa-download'/>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <footer class="distribute">
                <span>
                    <a href='http://facebook.com/groups/i2ivolunteers'>INTRANET 2 INTERNET</a>
                </span>
                <span onclick="document.getElementById('aboutus').style.display='block'">ABOUT-US</span>
                <span onclick="document.getElementById('terms').style.display='block'">TERMS & CONDITION</span>
            </footer>
            </content>
    </body>
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89125855-1', 'auto');
  ga('send', 'pageview');

</script>
   
</html>
