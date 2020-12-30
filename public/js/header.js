let listHeader = document.querySelectorAll('.header-select');
let urlString = document.location.href;

for(let i = 0; i < listHeader.length; i++){
    let currentURL = listHeader[i].getAttribute("href");
    if(currentURL.toLowerCase() === urlString.toLowerCase()){
        listHeader[i].className="header-select header-active";
    }
}

$(document).ready(function(){
    // let urlCurrent = document.location.href;
    // let index = urlCurrent.indexOf("listproductsearch");
    // if(index !== -1){
    //     $("#id-form-search-product").toggleClass("d-none");
    // }
    // $("#id-icon-search-product").on("click",function(){
    //     $("#id-form-search-product").toggleClass("d-none");
    // });
});
