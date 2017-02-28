console.log("AngularExecution");
var app=angular.module("vpanel",[]);
app.controller('vpanelctrl',function($http,$scope){
//    /*
//     * Ajaxing using Ajax It Function
//     */
    function ajaxit(obj,success,failure){
        var paramData=$.param(obj);
        $http({method:"POST",url:"../scripts/ajaxvpanel.php",data:paramData,headers:{'content-Type':'application/x-www-form-urlencoded'}})         
        .then(success,failure);
    }
//    /*
//     * Auto Execution
//     * TO update tree with subject and its section
//     */
////    
    $scope.updateTree=function(sub,sec){
            ajaxit({purpose:"getTree"},function(response){
                $scope.tree=response.data;
                if(!sub){
                    $scope.selectSubject=$scope.tree[0];
                    $scope.updateSection();
                }
                else{
                    $scope.selectSubject=sub;
                    $scope.updateSection(sec);
                }
                $scope.addSubjectSec=$scope.tree[0];
                console.log("Select subject initialized");
                
            },function(){

            });
            
    };
    
    
    $scope.updateNotification=function(){
            ajaxit({purpose:"getNotifications"},function(response){
                $scope.notifications=response.data;
            },function(){

            });
            
    };
    $scope.updateVolunteers=function(){
            ajaxit({purpose:"getClassVolunteers"},function(response){
                $scope.vol=response.data;
            },function(){

            });
            
    };
    $scope.volApprove=function(volids){
        ajaxit({purpose:"acceptVolApproval",volid:volids},function(response){
                $scope.updateNotification();
            },function(){
            });
    };
    
    $scope.getAllVolNotifications=function(){
        ajaxit({purpose:"getAllVolNotifications"},function(response){
                $scope.notifications=response.data;
            },function(){

            });
    };
    
    $scope.delNotice=function(notid){
        ajaxit({purpose:"deleteNotification",Notid:notid},function(response){
                $scope.updateNotification();
            },function(){

            });
    };
//
    $scope.updateSection=function(sec){
        ajaxit({purpose:"getFiles",subid:$scope.selectSubject.SubjectId},function(response){
            $scope.filelist=response.data;
            if(!sec)
            $scope.selectSection=$scope.selectSubject.Section[0];
            else
            $scope.selectSection=sec;
            $scope.updateFiles();
//            $scope.files=response.data[0].Files;
            
        },function(){
        });
    };
//    
    $scope.updateFiles=function(){
//        alert($scope.filelist.findIndex(x=>x.Section==$scope.selectSection));
        if($scope.filelist.findIndex(x=>x.Section==$scope.selectSection)!=-1)
//            $scope.$apply(
                $scope.files=$scope.filelist[$scope.filelist.findIndex(x=>x.Section==$scope.selectSection)].Files;
//            );
        else
//            $scope.$apply(
                $scope.files=[];
//            );
            
    
    };
            
            $scope.updateVolDetails=function(){
                ajaxit({
                    purpose:"getVolDetails"
                },function(response){
                    $("body").append(response.data);
                    $scope.volunteer=response.data;
                    
                },function(){
                    alert("filad");
                });
            };
//    
//    $scope.addSubject=function(){};
//    $scope.addSection=function(){};
//    $scope.updateName=function(){};
    (function(){
        $scope.updateTree();
        $scope.updateVolDetails();
        $scope.updateNotification();
        $scope.updateVolunteers();
    })();
//    
//  

    $(document).ready(function(){
        $("#addSubjectForm,#addSectionForm").ajaxForm({
            complete:function(response){
                $("#addSubjectForm,#addSectionForm").trigger("reset");
                $scope.updateTree();
                location.reload();
                $("body").append(response.data);

            }
        });
        
        
        $("#upload").ajaxForm({
            dataType:'json',
            beforeSend:function(){
                $("progress").attr("value","0");
            },
            uploadProgress:function(event,position,total,percentComplete){
                $("progress").attr("value",percentComplete);
                
            },
            complete:function(data){
                $scope.$apply(function(){
                    $scope.uploadStatus=data.responseJSON;
                    $("[type=file").val("");
                    $scope.updateSection($scope.selectSection);
                });
            }
        });
        
});
        $scope.moveup=function($index){
            
            curFileId=$("."+$index+" [name=fileid]");
            prevFileId=$("."+$index).prev().children("td").children("[name=fileid]");
            if(prevFileId.val()!=undefined)
            ajaxit({purpose:"swapFileId",
                    subject:$scope.selectSubject.SubjectId,
                    one:curFileId.val(),
                    two:prevFileId.val()}
                    ,function(response){
                        temp=curFileId.val();
                        curFileId.val(prevFileId.val());
                        prevFileId.val(temp);
                        
                        $("."+$index).slideUp('fast').insertBefore($("."+$index).prev()).show('slow');
//                $scope.updateTree($scope.selectSubject,$scope.selectSection);

                    });
                    
        };
        $scope.updateList=function($index){
            ajaxit({purpose:"updateFile",
                    filename:$("."+$index+" [name=filename]").val(),
                    name:$("."+$index+" [name=name]").val(),
                    subject:$scope.selectSubject.SubjectId,
                    section:$scope.selectSection
            },function(response){
                $("body").append(response.data);
//                $scope.updateTree($scope.selectSubject,$scope.selectSection);
            });
        };
        $scope.deleteFile=function($index){
//            alert($("."+$index+" [name=filename]").val());
            ajaxit({purpose:"deleteFile",
                    fileid:$("."+$index+" [name=fileid]").val(),
                    filename:$("."+$index+" [name=filename]").val()
            },function(response){
                  $("."+$index).hide("slow");
//                $scope.updateTree($scope.selectSubject,$scope.selectSection);
            });
            
        };
        $scope.deleteSubject=function(){
            ajaxit({purpose:"deleteSubject",
                    subid:$scope.selectSubject.SubjectId
            },function(response){
                    $scope.updateTree();
                    alert('deleted');
                    $("body").append(response.data);
        });
        
        };
        $scope.deleteSection=function(){
            ajaxit({purpose:"deleteSection",
                    subid:$scope.selectSubject.SubjectId,
                    section:$scope.selectSection
            },function(response){
                    $scope.updateTree();
                    alert('deleted');
                    $("body").append(response.data);
        });
        
        }
});


function trig(sel){
    $(sel).click();//('click');
}
function triggerUpload(){
    $("#uploadButton").trigger('click');
}
 function trig(){
    $("[type=file]").trigger('click');
}
        