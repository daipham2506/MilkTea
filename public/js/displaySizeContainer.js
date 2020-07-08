// window.onload = initSizeDisplay();

    if(document.getElementById("sizeM")){
        let sizeM = document.getElementById("sizeM").checked;
        if(sizeM){
            if(document.getElementById("containerM")){
                document.getElementById("qualityMInput").style.display = "block";
                document.getElementById("priceMInput").style.display = "block";
            }
        }else{
            if(document.getElementById("containerM")){
                document.getElementById("qualityMInput").style.display = "none";
                document.getElementById("priceMInput").style.display = "none";
            }
        }
    }

    if(document.getElementById("sizeL")){
        let sizeL = document.getElementById("sizeL").checked;
        if(sizeL){
            if(document.getElementById("containerL")){
                document.getElementById("qualityLInput").style.display = "block";
                document.getElementById("priceLInput").style.display = "block";
            }
        }else{
            if(document.getElementById("containerL")){
                document.getElementById("qualityLInput").style.display = "none";
                document.getElementById("priceLInput").style.display = "none";
            }
        }
    }


function sizeMChangeHandler(){
    let isSizeM = false;
    if(document.getElementById("sizeM")){
        isSizeM = document.getElementById("sizeM").checked;
        if(isSizeM){
            if(document.getElementById("containerM")){
                document.getElementById("qualityMInput").style.display = "block";
                document.getElementById("priceMInput").style.display = "block";
            }
        }else{
            if(document.getElementById("containerM")){
                document.getElementById("qualityMInput").style.display = "none";
                document.getElementById("priceMInput").style.display = "none";
            }
        }
    }
}
function sizeLChangeHandler(){
    let isSizeL = false;
    if(document.getElementById("sizeL")){
        isSizeL = document.getElementById("sizeL").checked;
        if(isSizeL){
            if(document.getElementById("containerL")){
                document.getElementById("qualityLInput").style.display = "block";
                document.getElementById("priceLInput").style.display = "block";
            }
        }else{
            if(document.getElementById("containerL")){
                document.getElementById("qualityLInput").style.display = "none";
                document.getElementById("priceLInput").style.display = "none";
            }
        }
    }
}


