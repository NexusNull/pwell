
function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

$(document).ready(function () {
    var value = getCookie("policyAccepted");
    if(value){
        $("#policyAttention").remove();
    } else {
        $("#policyAttention > .close")[0].addEventListener("click",function(){
            document.cookie="policyAccepted = true";
        })
    }
});
