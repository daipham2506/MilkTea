const stars = document.querySelector(".ratings").children;
const ratingValue = document.querySelector("#rating-value");
const ratingDescription = document.getElementById("rating-description");
let index;

for (let i = 0; i < stars.length; i++) {
  stars[i].addEventListener("mouseover", function () {
    // console.log(i)
    for (let j = 0; j < stars.length; j++) {
	  stars[j].classList.remove("fas");
      stars[j].classList.add("far");
    }
    for (let j = 0; j <= i; j++) {
      stars[j].classList.remove("far");
      stars[j].classList.add("fas");
    }
  });
  stars[i].addEventListener("click", function () {
    ratingValue.value = i + 1;
    index = i;

    switch(ratingValue.value){
      case "1":
        ratingDescription.innerHTML = "Cực kì không hài lòng";
        break;
      case "2":
        ratingDescription.innerHTML = "Không hài lòng";
        break;
      case "3":
        ratingDescription.innerHTML = "Tạm chấp nhận";
        break;
      case "4":
        ratingDescription.innerHTML = "Tuyệt vời";
        break;
      case "5":
        ratingDescription.innerHTML = "Trên cả tuyệt vời";
        break;
      default:
        ratingDescription.innerHTML = "Cực kì không hài lòng";
    }
  });
  stars[i].addEventListener("mouseout", function () {
    for (let j = 0; j < stars.length; j++) {
      stars[j].classList.remove("fas");
      stars[j].classList.add("far");
    }
    for (let j = 0; j <= index; j++) {
      stars[j].classList.remove("far");
      stars[j].classList.add("fas");
    }
  });
}
function displayRating(){
  document.getElementById("add-rating-container").style.display = "block";
}
