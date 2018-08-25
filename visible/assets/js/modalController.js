goog.provide("pwell.modalController");

/**
 * Created by Nexus on 11.12.2017.
 */
if (typeof pwell === "undefined")
    pwell = {};

pwell.ModalController = function(){
    this.userId = 0;
    this.username = "";

};

pwell.ModalController.prototype.confirmBan = function(){
    var modal = $("#ban");



};

pwell.ModalController.prototype.confirmDelete = function(){
    var modal = $("#delete");


};

pwell.ModalController.prototype.permission = function(){
    var self = this;
    var modal = $("#permission");
    $.ajax({
        type: "POST",
        url: "/Api/getPerms",
        dataType: "json",
        data: "id="+self.userId,
        success: function (json) {
            var data = json.data;
            var html = "";
            for(var key in data){
                html += "<div class='row'><div class='col-xs-4'>"+key+":</div><input type='hidden' value='0' name='"+key+"'><input type='checkbox' value='1' name='"+key+"' class='col-xs-2' "+(data[key]==1?"checked":"")+"></div>";
            }
            modal.find("input.id")[0].value = self.userId;
            modal.find(".content")[0].innerHTML = html;
            modal.find(".username")[0].innerHTML = self.username;
            modal.modal("show");
        }
    });
};