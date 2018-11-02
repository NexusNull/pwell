
function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}

$(document).ready(function () {
    var value = +getCookie("policyAccepted");
    console.log(value);
    if(value){
        $("#policyAttention").remove();
    } else {
        $(".policy > .policyAccept")[0].addEventListener("click",function(){
            document.cookie="policyAccepted = 1";
        });
        $(".policy > .policyDecline")[0].addEventListener("click",function(){
            document.cookie="policyAccepted = 0";
        })
    }
});
