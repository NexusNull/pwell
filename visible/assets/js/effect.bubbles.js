/**
 * Created by patric on 11/15/16.
 */
var canvas;
var actions = 0;
var ctx;
var targetTime = 32;
var elements = [];
$(document).ready(function () {
    canvas = document.getElementById("bubbles");
    if(canvas){
    canvas.width = 345;
    canvas.height = 345;
    var elementCount = 100;
    ctx = canvas.getContext("2d");

    setTimeout(function () {
        for (var i = 0; i < elementCount; i++) {
            elements[i] = new Dot(canvas.width * Math.random(), canvas.height * Math.random());
        }
        setInterval(run, targetTime);
    }, 10);
    }
});

document.addEventListener("mousemove", function () {
    actions++;
});

var run = function () {
    ctx.fillStyle = 0xffffff;
    var took = 0.1;
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    for (var i = 0; i < elements.length; i++) {
        took += actions * 0.002;
        elements[i].update(took);
    }
    for (var j = 0; j < elements.length; j++) {
        elements[j].render();
    }
    dataUrl = canvas.toDataURL();
    ele = document.getElementsByClassName('bubbles');
    for (var k = 0; k < ele.length; k++) {
        ele[k].style.background = "url('" + dataUrl + "')";
    }
    actions = 0;
};
var Dot = function (posX, posY) {
    this.posX = posX;
    this.posY = posY;
    this.velX = -5 + 10 * Math.random();
    this.velY = -5 + 10 * Math.random();
    this.size = 2 + 9 * Math.random();
};
function circle(x, y, size) {
    ctx.beginPath();
    ctx.arc(x, y, size, 0, 2 * Math.PI, false);
    ctx.fill();
    ctx.lineWidth = 1;
    ctx.strokeStyle = '#003300';
    ctx.stroke();
}
Dot.prototype.render = function () {
    if (this.posX - this.size < 0) {
        circle(canvas.width + this.posX, this.posY, this.size);
    }
    if (this.posX + this.size > canvas.width) {
        circle(this.posX - canvas.width, this.posY, this.size);
    }
    if (this.posY - this.size < 0) {
        circle(this.posX, canvas.height + this.posY, this.size);
    }
    if (this.posY + this.size > canvas.height) {
        circle(this.posX, this.posY - canvas.height, this.size);
    }
    circle(this.posX, this.posY, this.size);
};
Dot.prototype.update = function (took) {
    if (this.posX > canvas.width)
        this.posX -= canvas.width;
    else if (this.posX < 0) {
        this.posX += canvas.width;
    }
    if (this.posY > canvas.height)
        this.posY -= canvas.height;
    else if (this.posY < 0) {
        this.posY += canvas.height;
    }
    this.posX += this.velX * took;
    this.posY += this.velY * took;
};
