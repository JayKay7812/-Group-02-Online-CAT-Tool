$("#termsheet").ready(function select()
{
    
    $.getJSON("../include/search0.php?type=4",function(result){
        $.each(result,function(i,val){
            var txt="<option>"+val["tbsheet_Name"]+"</option>";
            $("#termsheet").append(txt);
        })
    });
});
 
$("#termsubmit").click(function addterm()
{
    var ts=$("#termsheet").val();
    var zh=$("#zh").val();
    var en=$("#en").val();
    var def=$("#definition").val();
    var stopword=$("input:radio:checked").val();
    $.post("translation.php?action=addterm", { termsheet: ts, zh_CN: zh, en_US:en, definition:def, property:stopword } );
});
function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}