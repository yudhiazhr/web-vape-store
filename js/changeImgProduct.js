var mainImg = document.getElementById("mainImg");
var smallImg = document.getElementsByClassName("small-img-col");

for (let i = 0; i < 4; i++) {
    smallImg[i].onclick = function () {
        mainImg.src = smallImg[i].children[0].src;
    }
}