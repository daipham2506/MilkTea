<?php
    $listComment = $data["listComment"];
    $current_user_id = $_SESSION['user_id'];
    foreach($listComment as $item){
        $avatar = $item["avatar"];
        $name = $item["name"];
        $content = $item["content"];
        $createdAt = $item["createdAt"];
        $idComment = $item["idcomment"];
        $iduser = $item["iduser"];

        $idBtnResponse = "btn-add-response-" . $idComment;
        $idValueResponse = "value-response-" .$idComment;
        $idFormResponse = "form-response-" . $idComment;
        $idIconResponse = "icon-response-" . $idComment;
        $idListResponse = "list-response-comment-" . $idComment;
        
        echo <<< _END
        <div class="d-flex mb-3">
            <div class="mr-2">
                <img class="avatar-comment" src="$avatar" alt="">
            </div>
            <div class="">
                <div class="content-comment mr-2">
                    <span class="name-user-comment">$name</span>
                    $content
                </div>
                <div class="d-flex align-items-center like-or-response">
                    <i class="far fa-thumbs-up icon-react-comment"></i>
                    <i class="fas fa-reply icon-react-comment icon-response-comment" id-comment="$idComment"></i>
        _END;

        if($current_user_id == $iduser){
            echo <<< _END
                <i class="far fa-trash-alt icon-react-comment delete-comment" id-comment="$idComment"></i>
            _END;
        }

        echo <<< _END
                    <div class="datetime-comment">$createdAt</div>
                </div>
            </div>
        </div>
        <div class="list-response">
            <div id="$idListResponse"></div>
            <form id="$idFormResponse" class="d-none" action="<?php echo URLROOT; ?>posts/addcomment" method="POST">
                <div class="form-group d-flex">
                    <input type="text" class="form-control mr-2" id="$idValueResponse" name="comment" aria-describedby="emailHelp" placeholder="Trả lời bình luận">
                    <button type="button" id="$idBtnResponse" class="btn btn-info btn-add-comment">Add</button>
                </div>
            </form>
        </div>
        _END;
    }
?>