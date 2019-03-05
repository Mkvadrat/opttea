var imgUp = new Image(50,50);
var imgDown = new Image(50,50);
var imgUpOn = new Image(50,50);
var imgDownOn = new Image(50,50);

imgUp.src = "img/buttonUp.png";
imgUpOn.src = "img/buttonUpOn.png";
imgDown.src = "img/buttonDown.png";
imgDownOn.src = "img/buttonDownOn.png";

function imgOn(imgName) {
	if (imgName == 'imgUp') document.images[imgName].src = imgUpOn.src;
	if (imgName == 'imgDown') document.images[imgName].src = imgDownOn.src;
}

function imgOff(imgName) {
	if (imgName == 'imgUp') document.images[imgName].src = imgUp.src;
	if (imgName == 'imgDown') document.images[imgName].src = imgDown.src;
}