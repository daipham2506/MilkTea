<?php 
    $idComment = $data["idComment"];
    $listComment = $data["listResponse"];
    $current_user_id = $_SESSION['user_id'];
    foreach($listComment as $item){
        $avatar = $item["avatar"];
        $name = $item["name"];
        $content = $item["content"];
        $createdAt = $item["createdAt"];
        $iduser = $item["iduser"];
        $idresponse = $item["idresponse"];

        $classDeleteResponse = "delete-response-" . $idComment;

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
                    <!--<i class="far fa-thumbs-up icon-react-comment"></i> -->
        _END;

        if($current_user_id == $iduser){
            echo <<< _END
                <i class="far fa-trash-alt icon-react-comment $classDeleteResponse" id-response="$idresponse" id-comment="$idComment"></i>
            _END;
        }

        echo <<< _END
                    <div class="datetime-comment">$createdAt</div>
                </div>
            </div>
        </div>
        _END;
    }
?>