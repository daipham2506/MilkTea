<?php

class Post{
    private $db;
    public function __construct(){
        $this->db = new Database;
    }

    public function addPost($data){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("Y-m-d H:i:s");
        $content = $data['post_content'];
        $title = $data['post_title'];
        $img = $data['post_img'];
        if($img == ''){
            $img = "Empty link";
        }
        $user_id = $_SESSION['user_id'];
        
        $query_add_post = "INSERT INTO `post`( `content`, `createdAt`, `image`, `iduser`, `title`) VALUES ('$content','$date','$img',$user_id,'$title')";

        $rs = $this->db->connection->query($query_add_post);
        if($rs){
            return true;
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

    public function editPost($data)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("Y-m-d H:i:s");
        $content = $data['content'];
        $title = $data['title'];
        $img = $data['image'];
        $idPost = $data['id'];

        $user_id = $_SESSION['user_id'];
        
        $query_update_post = "UPDATE `post` SET content='$content',createdAt='$date',image='$img', iduser='$user_id',title='$title' where id=$idPost";

        $rs = $this->db->connection->query($query_update_post);
        if($rs){
            return true;
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

    public function getNumOfPost(){
        $query = "SELECT COUNT(*) AS num_post from post";
        $rs = $this->db->connection->query($query);
        if($rs){
            $row = $rs->fetch_assoc();
            return $row['num_post'];
        }
        else{
            echo $this->db->connection->error;
            return -1;
        }
    }

    public function getListPost($pageNumber,$num_of_post_per_page){
        $offset = ($pageNumber - 1) * $num_of_post_per_page;

        $query = "SELECT * FROM POST order by createdAt desc LIMIT $offset,$num_of_post_per_page";
        $rs = $this->db->connection->query($query);
        $listPost = [];
        if($rs){
            while($row = $rs->fetch_assoc()){
                array_push($listPost,$row);
            }   
            return $listPost;
        }
        else{
            echo $this->db->connection->error;
            return $listPost;
        }
    }

    public function getRecentlyPost($numPost)
    {
        $query = "SELECT * FROM POST order by createdAt desc LIMIT $numPost";
        $rs = $this->db->connection->query($query);
        $listPost = [];
        if($rs){
            while($row = $rs->fetch_assoc()){
                array_push($listPost,$row);
            }   
            return $listPost;
        }
        else{
            echo $this->db->connection->error;
            return $listPost;
        }
    }

    public function getPostDetail($postId){
        $query = "SELECT users.id as iduser,users.name, users.avatar, post.id as idpost, post.content, post.createdAt, post.image, post.title FROM post,users where post.id=$postId AND post.iduser = users.id";
        $rs = $this->db->connection->query($query);
        if($rs){
            $postDetail = $rs->fetch_assoc();
            return $postDetail;
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

    public function addComment($content, $iduser, $idpost){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("Y-m-d H:i:s");
        $query = "INSERT INTO comment (content,createdAt,iduser,idpost) values ('$content','$date',$iduser,$idpost)";
        $rs = $this->db->connection->query($query);
        if($rs){
            return true;
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

    public function getListComment($postId)
    {
        $query = "SELECT comment.id as idcomment, content, createdAt,comment.iduser,comment.idpost,name,avatar FROM comment,users WHERE idpost='$postId' and comment.iduser = users.id order by createdAt asc";
        $rs = $this->db->connection->query($query);
        $listComment = [];
        if($rs){
            while($row = $rs->fetch_assoc()){
                array_push($listComment,$row);
            }   
            return $listComment;
        }
        else{
            echo $this->db->connection->error;
            return $listComment;
        }
    }

    public function addResponse($user_id,$content,$idcomment)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("Y-m-d H:i:s");
        $query = "INSERT INTO response (content,createdAt,iduser,idcomment) values ('$content','$date',$user_id,$idcomment)";
        $rs = $this->db->connection->query($query);
        if($rs){
            return true;
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

    public function getListResponse($idcomment)
    {
        $query = "SELECT users.name,users.avatar,iduser,content,createdAt,response.id as idresponse FROM users,response WHERE users.id = response.iduser and response.idcomment=$idcomment order by createdAt asc";
        $rs = $this->db->connection->query($query);
        $listResponse = [];
        if($rs){
            while($row = $rs->fetch_assoc()){
                array_push($listResponse,$row);
            }   
            return $listResponse;
        }
        else{
            echo $this->db->connection->error;
            return $listResponse;
        }
    }

    public function deleteComment($idcomment)
    {
        $query = "CALL deleteComment($idcomment)";
        $rs = $this->db->connection->query($query);
        if($rs){
            return true;
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

    public function deleteResponse($idResponse)
    {
        $query = "DELETE FROM response where id = $idResponse";
        $rs = $this->db->connection->query($query);
        if($rs){
            return true;
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

    public function getNumComment($idPost)
    {
        $query = "SELECT COUNT(*) as numcomment FROM post,comment WHERE post.id = $idPost and post.id = comment.idpost";
        $rs = $this->db->connection->query($query);
        if($rs){
            return $rs->fetch_assoc()["numcomment"];
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

    public function getNumResponse($idComment)
    {
        $query = "SELECT COUNT(*) as numresponse FROM response WHERE idcomment=$idComment";
        $rs = $this->db->connection->query($query);
        if($rs){
            return  $rs->fetch_assoc()["numresponse"];
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

    public function deletePost($idPost)
    {
        $query = "CALL deletePost($idPost)";
        $rs = $this->db->connection->query($query);
        if($rs){
            return true;
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

    public function getPostInfo($idPost)
    {
        $query = "SELECT * FROM post where id=$idPost";
        $rs = $this->db->connection->query($query);
        if($rs){
            return $rs->fetch_assoc();
        }
        else{
            echo $this->db->connection->error;
            return false;
        }
    }

}

?>