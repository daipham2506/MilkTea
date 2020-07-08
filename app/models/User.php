<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once ROOT . "/vendor/autoload.php";
class User
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  // Regsiter user
  public function register($data)
  {
    $this->db->query('INSERT INTO users (name, email, password, avatar) VALUES(:name, :email, :password, :avatar)');
    // Bind values
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':password', $data['password']);
    $this->db->bind(':avatar', "https://cdn.icon-icons.com/icons2/1378/PNG/512/avatardefault_92824.png");
    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Login User
  public function login($email, $password)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    $hashed_password = $row->password;
    if (password_verify($password, $hashed_password)) {
      return $row;
    } else {
      return false;
    }
  }

  // Find user by email
  public function findUserByEmail($email)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email');
    // Bind value
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    // Check row
    if ($this->db->rowCount() > 0) {
      return $row;
    } else {
      return false;
    }
  }
  public function findUserById($userId)
  {
    $this->db->query('SELECT * FROM users WHERE id = :userId');
    $this->db->bind(':userId', $userId);
    $row = $this->db->single();
    if ($this->db->rowCount() > 0) {
      return $row;
    } else {
      return false;
    }
  }
  public function findOtherUserByEmail($userId, $email)
  {
    $sql = "SELECT * FROM users WHERE (email = '$email') AND (id != $userId)";
    $result = mysqli_query($this->db->conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      return true;
    } else {
      return false;
    }
  }
  public function update($data, $userId)
  {
    $name = $data["name"];
    $email = $data["email"];
    $birthday = $data["birthday"];
    $address = $data["address"];
    $gender = $data["gender"];
    $avatar = $data["avatar"];
    $phone = $data["phone"];
    $sql = "UPDATE `users` SET `name` = '$name', `email` = '$email', `address` = '$address',
    `birthday` = '$birthday', `gender` = '$gender', `avatar` = '$avatar', `phone` = '$phone' WHERE `id` = $userId";
    if($phone == ""){
      $sql = "UPDATE `users` SET `name` = '$name', `email` = '$email', `address` = '$address',
      `birthday` = '$birthday', `gender` = '$gender', `avatar` = '$avatar' WHERE `id` = $userId";
    }
    if($address == ""){
      $sql = "UPDATE `users` SET `name` = '$name', `email` = '$email', `birthday` = '$birthday', 
      `gender` = '$gender', `avatar` = '$avatar', `phone` = '$phone' WHERE `id` = $userId";
    }
    if($address == "" && $phone == ""){
      $sql = "UPDATE `users` SET `name` = '$name', `email` = '$email',
      `gender` = '$gender', `avatar` = '$avatar' WHERE `id` = $userId";
    }
    if (mysqli_query($this->db->conn, $sql)) {
      return true;
    } else {
      echo ("Error description: " . $this->db->conn->error);
      return false;
    }
  }
  public function findUserPasswordById($userId)
  {
    $sql = "SELECT `id`, `password` FROM `users` WHERE `id` = $userId";
    $result = mysqli_query($this->db->conn, $sql);
    if ($result) {
      $row = $result->fetch_assoc();
      return $row;
    } else {
      echo ("Error description: " . $this->db->conn->error);
      return false;
    }
  }
  public function changePass($userId, $password)
  {
    $sql = "UPDATE `users` SET `password` = '" . $password . "' WHERE `id` = $userId;";
    if (
      mysqli_query($this->db->conn, $sql)

    ) {
      return true;
    } else {
      echo ("Error description: " . $this->db->conn->error);
      return false;
    }
  }

  public function getAllUsers($pageNumber,$num_of_user_per_page)
  {
    $offset = ($pageNumber - 1) * $num_of_user_per_page;
    $sql = "SELECT id, name, email, avatar, address, phone FROM `users` WHERE isAdmin IS NULL ORDER BY id DESC LIMIT $offset,$num_of_user_per_page";
    $result = $this->db->connection->query($sql);
    $res = [];
    while ($row = $result->fetch_assoc()) {
      array_push($res, $row);
    }
    return $res;
  }

  public function deleteUserById($id)
  {
    // $sql = "DELETE FROM `users` WHERE id = $id";
    $sql = "call deleteUser($id)";
    if ($this->db->connection->query($sql)) {
      return true;
    } else {
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }

  public function sendEmail($user, $newPass)
  {
    $mail = new PHPMailer(true); //Argument true in constructor enables exceptions

    $mail->SMTPDebug = 2;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'milktea.dmhn@gmail.com';                 // SMTP username
    $mail->Password = 'Milktea123!';                        // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //From email address and name
    $mail->setFrom("milktea.dmhn@gmail.com", "MilkTeaX");

    //To address and name
    $mail->addAddress($user->email);

    //Address to which recipient will reply
    $mail->addReplyTo('milktea.dmhn@gmail.com');

    // content
    $mail->isHTML(true);

    $mail->Subject = "Reset your password for " . $user->email . " account.";
    $mail->Body = "Hello " . $user->name . "!
    <br>The new password for your account is: <b>$newPass</b>
    <br>If you didn’t ask to reset your password, you can ignore this email.
    <br>
    Thanks,
    <br>
    MilkTeaX Team.
    ";

    try {
      $mail->send();
      return [true, 'Vui lòng kiểm tra Email!'];
    } catch (Exception $e) {
      return [false, $mail->ErrorInfo];
    }
  }

  public function randomPassword()
  {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#%^&*';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }
  public function findAddressUser($id){
    $sql = "SELECT address from Users WHERE id=".$id;
    $result = mysqli_query($this->db->conn, $sql);
    if (mysqli_num_rows($result) == 0){
      return "";
    }
    else return mysqli_fetch_assoc($result)['address'];
  }
  public function getNumOfUser(){
    $sql = "SELECT COUNT(*) AS `num_user` FROM `users`";
    $result = $this->db->connection->query($sql);
    if($result){
      $row = $result->fetch_assoc();
      return $row["num_user"];
    }else{
      echo ("Error description: " . $this->db->connection->error);
      return false;
    }
  }
}
