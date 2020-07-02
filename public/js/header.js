let listHeader = document.querySelectorAll('.header-select');
let urlString = document.location.href;

for(let i = 0; i < listHeader.length; i++){
    let currentURL = listHeader[i].getAttribute("href");
    if(currentURL.toLowerCase() === urlString.toLowerCase()){
        listHeader[i].className="header-select header-active";
    }
}
