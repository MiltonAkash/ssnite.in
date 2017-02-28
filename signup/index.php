<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
        <title>Signup| SSN ONLINE</title>
        <script src='../client/angular.min.js'></script>
        <link rel='stylesheet' href='signupprefix.css'/>
    </head>
    <body ng-app='signup' ng-controller="control">
        <?php
            if(isset($_POST['name'])):
                require_once '../scripts/classid.class.php';
                $classid=ssnite::generateClassid($_POST['year'],$_POST['dept'],$_POST['sec']);
                $obj=new Classid($classid);
                if($result=$obj->createVolunteer($_POST['name'], $_POST['mobile'],$_POST['mail'],$_POST['password'])):
        ?>
            <!--SIgn Up success block-->
            <alert id="positive">
                <h1>Thank You.</h1>
                <h2>For signing up as a Volunteer</h2>
                <p>Our volunteers will verify your proposal and add you. Only after that you can be access VPanel.</p>
            </alert>
        
        <?php        
                else:
        ?>
            <!--Sign up failure Block-->
            <alert id="negative">
                <h1>Sorry Dude!!</h1>
                <h2>Some Error Occured.Inform this to the Admin through feedback/report box in Homepage<?php echo 'h';?></h2>
            </alert>
        <?php 
                endif; 
                else:
        ?>
            <!--Ordinary Block i.e signup-->
            

            
        
        <form  method='post' action='<?php echo $_SERVER["PHP_SELF"];?>'>
            <h1>SIGN UP</h1>
            <p style="font-family:segoe ui">
                Thank You for signing up. Once you submit this form you will be enrolled
                as a inactive volunteer until an active volunteer approves you. You will
                be get notified through email. These details will be kept secret.
            </p>
            <input required  type='text' name='name'/>
            <label>Your Name</label>
            <select required ng-options="x for x in year track by x"   ng-model="optYear" name="year"></select>
            <label>Year</label>
            <select required ng-options="x.Name for x in dept track by x.Code" ng-change='restrictSec()' ng-model="optDept" name="dept"></select>
            <label >Department</label>
            <select  required ng-options="x for x in sec track by x"  ng-hide="optDept.Code=='CIV'||optDept.Code=='BME'" ng-model="optSec" name="sec"></select>
            <label ng-hide="optDept.Code=='CIV'||optDept.Code=='BME'">Section</label>
            <input required type='email' name='mail'/>
            <label>Mail id</label>
            <input placeholder='No need of country code.' required type='number'  name='mobile'/>
            <label>Mobile number.</label>
            <input required type='password' name='password'/> 
            <label>Password</label>
            <input type='submit' style='align-self:center;padding:20px;'   value='Sign Up'/>
            <p></p>
        </form>
        <?php endif;?>
    </body>
<script>
    var app=angular.module("signup",[]);
    app.controller('control',function($http,$scope){
        /*
         * Defining the scope variables
         * Variables used in the Select as Options
         */
        $scope.dept=[
            {'Name':'CSE','Code':'CSE'},
            {'Name':'IT','Code':'ITO'},
            {'Name':'BME','Code':'BME'},
            {'Name':'EEE','Code':'EEE'},
            {'Name':'ECE','Code':'ECE'},
            {'Name':'MECH','Code':'MEC'},
            {'Name':'CIVIL','Code':'CIV'},
            {'Name':'CHEMICAL','Code':'CHE'}
        ];
        $scope.year=[1,2,3,4];
        $scope.sec=['A','B'];
        console.log("Angular:Content-SYD Variables are Created");
        
        $scope.restrictSec=function(){
            if($scope.optDept.Code=="CIV"||$scope.optDept.Code=="BME"){
                $scope.sec=["A"];
                $scope.optSec=$scope.sec[0];
                }
            else
                $scope.sec=["A","B"];
        }
        
    });
</script>
</html>
<?php
