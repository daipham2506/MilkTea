<?php
class Posts extends Controller
{
  public function __construct()
  {
    $this->postModel = $this->model('Post');
  }

  public function listposts(){
      $pageNumber = 1;
      $numOfPost = $this->postModel->getNumOfPost();
      $user_id = $_SESSION['user_id'];
      $listPost = $this->postModel->getListPost($pageNumber,$numOfPost);
      // var_dump($listPost);
      // echo $numOfPost;
      $data = [
        "numOfPost" => $numOfPost,
        "listPost" => $listPost
      ];
      $this->view("posts/listposts",$data);
  }

  public function postdetail($id){
      $postDetail = $this->postModel->getPostDetail($id);
      $listComment = $this->postModel->getListComment($id);
      $data = [
        "postDetail" => $postDetail,
        "listComment" => $listComment
      ];
      $this->view("posts/postdetail",$data);
  }

  public function addcomment(){
    $user_id = $_SESSION['user_id'];
    $content = $_POST["comment"];
    $idpost =  $_POST["idpost"];
    $rs = $this->postModel->addComment($content,$user_id,$idpost);
    // if($rs){
    //   redirect("posts/postdetail/$idpost");
    // }
    // else{
    //   echo "Have error when add comment";
    // }
  }

  public function addresponse()
  {
    $user_id = $_SESSION['user_id'];
    $content = $_POST["content"];
    $idcomment =  $_POST["idcomment"];

    $rs = $this->postModel->addResponse($user_id,$content,$idcomment);

    if($rs){
      echo "SUCCESS";
    }
    else{
      echo "FAILED";
    }
  }

  public function addpost(){
    $data = [
      'post_title' => '',
      'post_content' => '',
      'post_img' => '',
      'post_title_err' => '',
      'post_content_err' => '',
      'post_img_err' => ''
    ];
    $this->view("posts/addpost",$data);
  }

  public function getlistcomments($id)
  {
    $listComment = $this->postModel->getListComment($id);
    $data = [
      "listComment" => $listComment
    ];
    $this->view("posts/listcomment",$data);
  }

  public function getlistresponse($idcomment)
  {
    $listResponse = $this->postModel->getListResponse($idcomment);
    $data = [
      "listResponse" => $listResponse,
      "idComment" => $idcomment
    ];
    $this->view("posts/listresponse",$data);
  }

  public function deletecomment($idcomment)
  {
    $rs= $this->postModel->deleteComment($idcomment);
    if($rs){
      echo "SUCCESS";
    }
    else{
      echo "FAILED";
    }
  }

  public function deleteresponse($idResponse)
  {
    $rs= $this->postModel->deleteResponse($idResponse);
    if($rs){
      echo "SUCCESS";
    }
    else{
      echo "FAILED";
    }
  }

  public function numcomment(){
    $idPost = $_GET["idpost"];
    $idComment = $_GET["idcomment"];
    $numComment = $this->postModel->getNumComment($idPost);
    $numResponse = $this->postModel->getNumResponse($idComment);
    echo $numComment;
    echo "<br/>";
    echo $numResponse;
  }


  public function addnewpost(){
    if(isset($_POST['post_title'])){
      // echo $_POST['post_title'];
      // echo $_POST['post_content'];
      // var_dump( $_FILES['post_img']);

      // Init data
      $data = [
        'post_title' => trim($_POST['post_title']),
        'post_content' => trim($_POST['post_content']),
        'post_img' => '',
        'post_title_err' => '',
        'post_content_err' => '',
        'post_img_err' => ''
      ];

      if (!$_POST['post_title']){
        $data['post_title_err'] = "Please enter title for post!";
      }
      if (!$_POST['post_content']){
        $data['post_content_err'] = "Please enter content for post!";
      }

      if($_FILES['post_img']['name'] == ""){
        $data['post_img_err'] = "Please choose image for post!";
      }

      if (isset($_FILES['post_img']) && $_FILES['post_img']['name'] != "") {
        $ext = pathinfo($_FILES['post_img']['name'], PATHINFO_EXTENSION);
        $filename = pathinfo($_FILES['post_img']['name'], PATHINFO_FILENAME);
        // $uploaddir = "img/avatar/" . $_FILES['avatar']['name'];
        $uploaddir = "img/posts/" . $filename . uniqid(rand(), true). ".".$ext ;
        // echo $ext;
        //check image extension
        if ($ext != 'gif' && $ext != 'png' && $ext != 'jpg' && $ext != 'jpeg') {
          $data["post_img_err"] = "Sai định dạng ảnh (.jpg, .jpeg, .png, .gif)";
          //check image size
        } else if ($_FILES['post_img']['size'] > 5242880) {
          $data["post_img_err"] = "Vượt kích thước cho phép (5MB)";
        } else {
          if (move_uploaded_file($_FILES['post_img']['tmp_name'], $uploaddir)) {
            $data['post_img'] = URLROOT . $uploaddir;
            
          }
        }
        
      }

      // Make sure errors are empty
      if (empty($data['post_title_err']) && empty($data['post_content_err']) && empty($data['post_img_err'])) {
        // Validated

        // Add new post
        if ($this->postModel->addPost($data)) {
          flash('update_success', 'Add post thành công');
          redirect('posts/listposts');
        } else {
          
          echo "Add post have error with sql";
        }
      } else {
        // Load view with errors
        $this->view('posts/addpost', $data);
        // echo $data['post_title_err'];
        // echo "ERROR";
      }
    }
  }
}