$("#termsheet").ready(function select()
{
    
    $.getJSON("../include/search0.php?type=4",function(result){
        console.log(result["rows"]);
        $.each(result["rows"],function(i,val){
            var txt="<option>"+val["tbsheet_Name"]+"</option>";
            $("#termsheet").append(txt);
        })
    });
});
 
function termsub() {
    $.ajax({  
            type: "POST",   //提交的方法
            url:"../include/cat/translate/translation.php?action=addterm", //提交的地址  
            data:$('#form_data').serialize(),// 序列化表单值  
            async: false,  
            error: function(request) {  //失败的话
                 alert("Connection error");  
            },  
            success: function(data) {  //成功
                alert("添加成功");  
            }  
         });
       };  