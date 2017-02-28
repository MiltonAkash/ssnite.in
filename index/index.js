function snackbar(msg){
        
        $("#snackbar").show();
        $("#snackbar").html(msg);
        $("#snackbar").addClass('show');
        setTimeout(function(){
            $("#snackbar").removeClass('show');

        },3000);
}

console.log("Angular:Execution");
var app=angular.module("homepage",[]);
app.controller('homectrl',function($http,$scope){
    console.log("Angular:Controller")
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
    $scope.sec=["A","B"];
    console.log("Angular:Content-SYD Variables are Created");

    /*
     * Restricting the Sections for Civil and Mechanical
     */

    function restrictSections(){
        console.log("Angular:Sections are Restriced");
        if($scope.optDept.Code=="CIV"||$scope.optDept.Code=="BME"){
            $scope.sec=["A"];
            $scope.optSec=$scope.sec[0];
            }
        else
            $scope.sec=["A","B"];
    }


    /*
     * Ajaxing using Ajax It Function
     */
    function ajaxit(obj,success,failure){
        var paramData=$.param(obj);
        $http({
            method:"POST",
            url:"scripts/ajaxhome.php",
            data:paramData,
            headers:{'content-Type':'application/x-www-form-urlencoded'}
        })         
        .then(success,failure);
    }


    /*
     * UpdateSub() is to Update the Subject <select>
     */
    $scope.updateSub=function(){
        //Getting the Updated VAlue
        console.log("Angular:UpdateSub function is called.");
        var classid=""+(21-$scope.optYear)+$scope.optDept.Code+$scope.optSec;
        ajaxit({purpose:"getSubjects",classid:classid},function(response){
                if(!response.data.length){
                    $scope.sub=[{"SubjectName":"No subjects added"}];
                    response.data=$scope.sub;
                }
                $scope.sub=response.data;
                console.log("Angular sub:"+response.data);
                console.log("Angular optSub:"+response.data[0]);
                $scope.optSub=response.data[0];
                $scope.updateFiles();
        },function(){});
                restrictSections();
    };
    /*
     *Assigning the Prefered SYD variables based on the Sessions 
     */

    ajaxit({purpose:"getSessionClassid"},function(response){
        console.log("PREFFERED USER")
        $scope.optDept=$scope.dept[$scope.dept.findIndex(x=>x.Code==response.data.dept)];
        $scope.optSec=response.data.sec;
        $scope.optYear=response.data.year;
        console.log("optDept:"+$scope.optDept+"optSec:"+$scope.optSec+"optYear:"+$scope.optYear);
        $scope.updateSub();
    },function(){
        console.log("NO PREFFERED USER FOUND");
        $scope.optDept=$scope.dept[7];
        $scope.optSec="B";
        $scope.optYear=1;
        $scope.updateSub();
    });
    
    
    $scope.updateFiles=function(){
        $scope.filelist=[];
            ajaxit({purpose:"getFiles",subid:$scope.optSub.SubjectId},function(response){
                $scope.filelist=response.data;
            },function(){
//                    $scope.filelist=[];
            });
    };
    });
    
$(document).ready(function(){
   
    
    curr=0;
    count=$("slideshow img").size();
    showcase();
   function showcase(){
        $("slideshow img").hide();
        $("slideshow img").eq(curr%count).show();
        $("navbox").removeClass("active");
        $("navbox").eq(curr%count).addClass("active");
        curr++
    }
    
    setInterval(showcase,2000);
});
//
//$("close").click(function(){
//    $(this).parent().hide();
//    console.log("close is clicked");
//    
//    
//});
//$(document).ready(function(){
//    
//$("openclose").click(function(){
//    $(this).toggleClass("active");    
//});
//
//var num=$("#vno").text();


//
//
//});