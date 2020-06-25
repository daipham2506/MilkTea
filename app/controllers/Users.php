<?php
class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
  }

  public function register()
  {
    // Check for POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Process form

      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Init data
      $data = [
        'name' => trim($_POST['name']),
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      // Validate Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      } else {
        // Check email
        if ($this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = 'Email is already taken';
        }
      }

      // Validate Name
      if (empty($data['name'])) {
        $data['name_err'] = 'Please enter name';
      }

      // Validate Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      } elseif (strlen($data['password']) < 6) {
        $data['password_err'] = 'Password must be at least 6 characters';
      }

      // Validate Confirm Password
      if (empty($data['confirm_password'])) {
        $data['confirm_password_err'] = 'Please confirm password';
      } else {
        if ($data['password'] != $data['confirm_password']) {
          $data['confirm_password_err'] = 'Passwords do not match';
        }
      }

      // Make sure errors are empty
      if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
        // Validated

        // Hash Password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // Register User
        if ($this->userModel->register($data)) {
          flash('register_success', 'You are registered and can log in');
          redirect('users/login');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('users/register', $data);
      }
    } else {
      // Init data
      $data = [
        'name' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      // Load view
      $this->view('users/register', $data);
    }
  }

  public function login()
  {
    // Check for POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      // Process form
      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      // Init data
      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => '',
      ];

      // Validate Email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      }

      // Validate Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      }

      // Check for user/email
      if ($this->userModel->findUserByEmail($data['email'])) {
        // User found
      } else {
        // User not found
        $data['email_err'] = 'No user found';
      }

      // Make sure errors are empty
      if (empty($data['email_err']) && empty($data['password_err'])) {
        // Validated
        // Check and set logged in user
        $loggedInUser = $this->userModel->login($data['email'], $data['password']);

        if ($loggedInUser) {
          // Create Session
          $this->createUserSession($loggedInUser);
        } else {
          $data['password_err'] = 'Password incorrect';

          $this->view('users/login', $data);
        }
      } else {
        // Load view with errors
        $this->view('users/login', $data);
      }
    } else {
      // Init data
      $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => '',
      ];

      // Load view
      $this->view('users/login', $data);
    }
  }

  public function createUserSession($user)
  {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = $user->name;
    redirect('pages/index');
  }

  public function logout()
  {
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    session_destroy();
    redirect('users/login');
  }

  public function isLoggedIn()
  {
    if (isset($_SESSION['user_id'])) {
      return true;
    } else {
      return false;
    }
  }
  public function detail($userId)
  {
    if ($this->userModel->findUserById($userId)) {
      $currentUser = $this->userModel->findUserById($userId);
    }
    $data = [
      "id" => $currentUser -> id,
      "name" => $currentUser -> name,
      "email" => $currentUser -> email,
      "password" => $currentUser -> password,
      "birthday" => $currentUser -> birthday,
      "avatar" => $currentUser -> avatar,
      "isAdmin" => $currentUser -> isAdmin,
      "address" => $currentUser -> address,
      "gender" => $currentUser -> gender
    ];
    $this->view('users/detail', $data);
  }
  public function edit($userId){
    if ($this->userModel->findUserById($userId)) {
      $currentUser = $this->userModel->findUserById($userId);
    }
    $data = [
      "id" => $currentUser -> id,
      "name" => $currentUser -> name,
      "email" => $currentUser -> email,
      "password" => $currentUser -> password,
      "birthday" => $currentUser -> birthday,
      "avatar" => $currentUser -> avatar,
      "isAdmin" => $currentUser -> isAdmin,
      "address" => $currentUser -> address,
      "gender" => $currentUser -> gender
    ];
    $this->view('users/edit', $data);
  }
  public function update($userId){
       // Check for POST
       if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Process form
  
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  
        // Init data
        $data = [
          'id' => $userId,
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'address' =>trim($_POST['address']),
          'birthday' => trim($_POST['birthday']),
          'gender' => trim($_POST['gender']),
          'avatar'=>trim($_POST['current-avatar']),
          'name_err' => '',
          'email_err' => '',
          'avatar_err' => ''
        ];
          // var_dump($_FILES['avatar']);
          // $uploaddir = './image';
          // $avatar_path = $uploaddir.basename($_FILES['avatar']['name']);
          // $avatar_path = $uploaddir;
          // echo $avatar_path;
          if(isset($_FILES['avatar'])){
            $uploaddir ="img/avatar/". $_FILES['avatar']['name'];
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            // echo $ext;
            //check image extension
            if($ext != 'gif' && $ext != 'png' && $ext != 'jpg' && $ext != 'jpeg'){
              $data["avatar_err"] = "Sai định dạng ảnh (.jpg, .jpeg, .png, .gif)";
            //check image size
            }else if( $_FILES['avatar']['size'] > 5242880){
              $data["avatar_err"] = "Vượt kích thước cho phép (5MB)";
            }else{
              if(move_uploaded_file($_FILES['avatar']['tmp_name'], $uploaddir)){
                $data['avatar'] = URLROOT.$uploaddir;
                // echo "Uploaded!";
              }
            }
            // echo $data["avatar_err"];
          }
        // Validate Email
        if (empty($data['email'])) {
          $data['email_err'] = 'Please enter email';
        }
        else {
          // Check email
          if ($this->userModel->findOtherUserByEmail($userId, $data['email'])) {
            $data['email_err'] = 'Email is already taken';
          }
        }
        // Validate Name
        if (empty($data['name'])) {
          $data['name_err'] = 'Please enter name';
        }
  
        // Make sure errors are empty
        if (empty($data['email_err']) && empty($data['name_err']) && empty($data['avatar_err'])) {
          // Validated
  
          // update User
          if ($this->userModel->update($data, $userId)) {
            flash('register_success', 'Your information are updated');
            redirect('users/detail/'.$userId);
          } else {
            print_r($data);
            die('Something went wrong');
          }

        } else {
          // Load view with errors
          $this->view('users/edit', $data);
        }
      } else {  
        $data = [
          'name' => trim($_POST['name']),
          'email' => trim($_POST['email']),
          'address' =>trim($_POST['address']),
          'birthday' => trim($_POST['birthday']),
          'gender' => trim($_POST['gender']),
          'avatar'=> trim($_POST['current-avatar']),
          'name_err' => '',
          'email_err' => '',
          'avatar_err' => ''
        ];
        // Load view
        $this->view('users/edit', $data);
      }
  }
}
