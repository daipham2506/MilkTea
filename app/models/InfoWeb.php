<?php
class InfoWeb
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }
  public function getContact(){
      $sql = "SELECT * FROM `contact`";
      $result = $this->db->connection->query($sql);
      $row = $result -> fetch_assoc();
      if ($row) {
        return [
        "address"=>$row["address"], 
        "phone"=> $row["phone"], 
        "email"=> $row["email"], 
        "facebook" => $row["facebook"],
        "instagram" => $row["instagram"]
        ];
      } else {
        echo ("Error description: " . $this->db->connection->error);
        return false;
      }
  }
  public function updateContact($data){
    $address = $data["address"];
    $phone = $data["phone"];
    $email = $data["email"];
    $facebook = $data["facebook"];
    $instagram = $data["instagram"];
    $sql = "UPDATE `contact` SET `address` = '$address', `phone` = '$phone', `email` = '$email', 
    `facebook` = '$facebook', `instagram` = '$instagram' WHERE id = 1";
    if($this->db->connection->query($sql)){
        return true;
    }else{
        echo ("Error description: " . $this->db->connection->error);
        return false;
    }
  }
}