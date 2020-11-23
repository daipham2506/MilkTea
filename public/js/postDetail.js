$(document).ready(function(){
    // console.log("Run here");
    let idpost = $("#my-btn-add-comment").attr("idpost");
    let URL_ROOT = "http://localhost/milktea/";
    let url = URL_ROOT + "posts/getlistcomments/" + idpost;
    $.get(url,function(data){
        // console.log(data);
        $("#list-comments").html(data);

        getListResponse(URL_ROOT);

        setupDeleteComment(URL_ROOT,url);

    });

    $("#my-btn-add-comment").on("click", function(){
        // console.log("Click here");
        let urlAddComment = URL_ROOT + "posts/addcomment";
        let comment = $("#input-add-comment").val();
        if (comment !== ""){
            $.post(urlAddComment,{comment: comment, idpost: idpost},function(data){
    
            });
        }
        else{
            alert("Vui lòng nhập bình luận!!!");
        }

        // Get list to update
        $.get(url,function(data){
            $("#list-comments").html(data);
            getListResponse(URL_ROOT);

            setupDeleteComment(URL_ROOT,url);

        });

        $("#input-add-comment").val("");
    });


});

function getListResponse(URL_ROOT){
    let arrIconResponse = $(".icon-response-comment");
    // console.log(arrIconResponse);
    for(let i = 0; i < arrIconResponse.length; i++){
        let idComment = arrIconResponse[i].getAttribute("id-comment");

        let idBtnResponse = "#btn-add-response-" + idComment;
        let idValueResponse = "#value-response-" + idComment;

        let urlListResponse = URL_ROOT + "posts/getlistresponse/" + idComment;
        $.get(urlListResponse,function(data){
            // console.log(data);
            let idListResponseComment = "#list-response-comment-" + idComment;
            $(idListResponseComment).html(data);

            setupDeleteResponse(URL_ROOT,idComment);
        });

        arrIconResponse[i].onclick = function(){
            let idFormResponse = "#form-response-" + idComment;
            $(idFormResponse).toggleClass("d-none");
            $(idValueResponse).val("");
        }
        

        $(idBtnResponse).on("click",function(){
            let valueResponse = $(idValueResponse).val();
            console.log(valueResponse);
            if(valueResponse === ""){
                alert("Vui lòng nhập phản hồi!!!");
            }
            else{
                let urlAddResponse = URL_ROOT + "posts/addresponse";

                $.post(urlAddResponse,{content: valueResponse, idcomment: idComment},function(data){
                    if(data === "SUCCESS"){
                        $(idValueResponse).val("");
                    }
                });

                // Get list response to update
                let urlListResponse = URL_ROOT + "posts/getlistresponse/" + idComment;
                $.get(urlListResponse,function(data){
                    // console.log(data);
                    let idListResponseComment = "#list-response-comment-" + idComment;
                    $(idListResponseComment).html(data);
                    setupDeleteResponse(URL_ROOT,idComment);
                });
            }
        });
    }

}

function setupDeleteComment(URL_ROOT,urlGetListComment){
    let listBtnDeleteComment = $(".delete-comment");
    // console.log(listBtnDeleteComment); 
    for(let i = 0; i < listBtnDeleteComment.length; i++){
        // console.log(listBtnDeleteComment[i]);
        listBtnDeleteComment[i].onclick = function(){
            let idComment = listBtnDeleteComment[i].getAttribute("id-comment");
            let urlDeleteComment = URL_ROOT + "posts/deletecomment/" + idComment;
            $.get(urlDeleteComment,function(data){
                // console.log(data);
                // Get list to update
                $.get(urlGetListComment,function(data){
                    $("#list-comments").html(data);
                    getListResponse(URL_ROOT);
                    setupDeleteComment(URL_ROOT,urlGetListComment);
                });
            });
        }
    }
}

function setupDeleteResponse(URL_ROOT,idComment){
    let listBtnDeleteResponse = $(".delete-response-" + idComment);
    for(let i = 0 ; i < listBtnDeleteResponse.length; i++){
        // console.log(listBtnDeleteResponse[i]);
        let idResponse = listBtnDeleteResponse[i].getAttribute("id-response");
        let idComment = listBtnDeleteResponse[i].getAttribute("id-comment");
        // console.log(idResponse);
        // console.log(idComment);
        listBtnDeleteResponse[i].onclick = function(){
            let urlDeleteResponse = URL_ROOT + "posts/deleteresponse/" + idResponse;
            $.get(urlDeleteResponse,function(data){
                console.log(data);
                // Get list response to update
                let urlListResponse = URL_ROOT + "posts/getlistresponse/" + idComment;
                $.get(urlListResponse,function(data){
                    // console.log(data);
                    let idListResponseComment = "#list-response-comment-" + idComment;
                    $(idListResponseComment).html(data);
                });
            });
        }
    }
}