<?php
class Product
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }
  public function getAllCategory()
  {
    $sql = "SELECT * FROM `category`";
    $result = $this->db->connection->query($sql);
    if ($result) {
      return $result;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getCategoryById($categoryId)
  {
    $sql = "SELECT * FROM `category` WHERE id = $categoryId";
    $result = $this->db->connection->query($sql);
    if ($result) {
      return $result;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getPriceByProductId($productId){
    $sql = "SELECT sizeofproduct.idproduct, sizeofproduct.price,sizeofproduct.quantity, size.size 
    FROM `sizeofproduct` INNER JOIN `size` ON sizeofproduct.idsize = size.id WHERE sizeofproduct.idproduct = $productId";
    $result = $this->db->connection->query($sql);
    if ($result) {
      return $result;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getProductByCategory($categoryId)
  {
    $sql = "SELECT product.id AS `id_product`, product.idcategory, product.name AS `name_product`,
     product.image, product.description, category.name AS `name_category` 
     FROM `product` INNER JOIN `category` ON product.idcategory = category.id 
     WHERE category.id = $categoryId";
    $result = $this->db->connection->query($sql);

    if ($result) {
      $final_result = []; // list product with price
      while($row = $result->fetch_assoc()){
        $product_price =  $this->getPriceByProductId($row["id_product"]);
        array_push($final_result,[
          "id_product"=> $row["id_product"],
          "image"=>$row["image"], 
          "name_product"=> $row["name_product"],
          "idcategory" => $row["idcategory"],
          "description"=> $row["description"],
          "name_category"=> $row["name_category"],
          "price_list"=>$product_price // need to fetch
        ]);
      }
      return $final_result;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getProductById($productId){
    $sql = "SELECT * FROM `product` WHERE `id` = $productId";
    $result = $this->db->connection->query($sql);
    $product_price = $this->getPriceByProductId($productId);
    $final_result = [];
    if ($result) {
      $row_product = $result->fetch_assoc();
      $final_result = [
        "id"=>$row_product["id"],
        "idcategory"=>$row_product["idcategory"],
        "name"=>$row_product["name"],
        "image"=>$row_product["image"],
        "description"=>$row_product["description"],
        "price_list"=>$product_price
      ];
      return $final_result;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
  public function getAllReviewByProductId($productId){
    $sql = "SELECT review.*, users.name, users.avatar FROM `review` INNER JOIN `users` 
    ON review.iduser = users.id WHERE `idproduct` = $productId ORDER BY createdAt DESC";
    $review = [];
    $result = $this->db->connection->query($sql);
    if($result){
        $review = $result;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
    return $review;
  }
  public function getAverageStarByProductId($productId){
    $sql = "SELECT * FROM (SELECT `idproduct`,AVG(numberstar) 'avgstar' 
    FROM `review` GROUP BY `idproduct`) AS `avgStar` WHERE avgStar.idproduct = $productId;";
    $result = $this->db->connection->query($sql);
    $avgStar = 0;
    if($result){
      if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        //cal start round to 0.5
        $star = round($row["avgstar"],2);
        $floor_star = floor($star);
        if($star - $floor_star >= 0.75){
          $avgStar = $floor_star + 1;
        }elseif($star - $floor_star >= 0.25){
          $avgStar = round(($floor_star + 0.5),1);
        }else{
          $avgStar = $floor_star;
        }
      }
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false; 
    }
    return $avgStar;
  }
  public function addReview($data){
    $productId = $data["productId"];
    $userId = $data["userId"];
    $content = $data["content"];
    $rating_value = $data["rating_value"];
    $sql = "INSERT INTO `review`(`content`, `createdAt`, `numberstar`, `iduser`, `idproduct`) VALUES ('". $content."',NOW(),$rating_value,$userId,$productId);";
    echo $sql;
    if($this->db->connection->query($sql)){
      return true;
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
}
