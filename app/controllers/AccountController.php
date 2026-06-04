<?php
require_once 'app/config/database.php';
require_once 'app/models/AccountModel.php';

class AccountController
{
    private $accountModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    function register()
    {
        include 'app/views/account/register.php';
    }

    public function login()
    {
        include 'app/views/account/login.php';
    }

    function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';

            $errors = [];
            if (empty($username)) {
                $errors['username'] = "Vui long nhap username!";
            }
            if (empty($fullName)) {
                $errors['fullname'] = "Vui long nhap fullName!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui long nhap password!";
            }
            if ($password != $confirmPassword) {
                $errors['confirmPass'] = "Mat khau nhap lai chua khop!";
            }
            $account = $this->accountModel->getAccountByUsername($username);

            if($account) {
                $errors['account'] = "Tai khoan nay da co nguoi dang ky!";
            }

            if(count($errors) > 0) {
                include_once 'app/views/account/register.php';
            }else{
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

                $result = $this->accountModel->save($username, $fullName, $password);

                if($result){
                    header('Location: /phamgiahuy/account/login');
                }
            }
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        header('Location: /phamgiahuy/product');
    }

    public function checkLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account){
                $pwd_hashed = $account->password;
                if (password_verify($password, $pwd_hashed)) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION['user_id'] = $account->id;
                    $_SESSION['username'] = $account->username;
                    $_SESSION['role'] = $account->role;
                    $_SESSION['fullname'] = $account->fullname;
                    $_SESSION['avatar'] = $account->avatar ?? '';
                    header('Location: /phamgiahuy/product');
                    exit;
                } else {
                    $error = "Mật khẩu không chính xác.";
                    include 'app/views/account/login.php';
                }
            } else {
                $error = "Tài khoản không tồn tại.";
                include 'app/views/account/login.php';
            }
        }
    }

    public function profile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: /phamgiahuy/account/login');
            exit;
        }

        $account = $this->accountModel->getAccountById($userId);
        if (!$account) {
            die("Tài khoản không tồn tại");
        }

        // Setup flash message display
        $flashMessage = $_SESSION['flash_message'] ?? null;
        $flashType = $_SESSION['flash_type'] ?? 'success';
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);

        include 'app/views/account/profile.php';
    }

    public function updateProfile()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: /phamgiahuy/account/login');
            exit;
        }

        $account = $this->accountModel->getAccountById($userId);
        if (!$account) {
            die("Tài khoản không tồn tại");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $actionType = $_POST['action_type'] ?? '';

            if ($actionType === 'update_info') {
                $fullname = trim($_POST['fullname'] ?? '');
                
                if (empty($fullname)) {
                    $_SESSION['flash_message'] = "Họ và tên không được để trống!";
                    $_SESSION['flash_type'] = "danger";
                    header('Location: /phamgiahuy/account/profile');
                    exit;
                }

                $avatar = $account->avatar; // Giữ nguyên avatar cũ mặc định

                // Xử lý upload avatar
                if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['avatar']['tmp_name'];
                    $fileName = $_FILES['avatar']['name'];
                    $fileSize = $_FILES['avatar']['size'];
                    $fileType = $_FILES['avatar']['type'];
                    
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));
                    
                    $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                    if (in_array($fileExtension, $allowedfileExtensions)) {
                        // Tạo tên file ngẫu nhiên để tránh trùng lặp
                        $newFileName = 'avatar_' . $userId . '_' . time() . '.' . $fileExtension;
                        $uploadFileDir = 'uploads/';
                        
                        // Đảm bảo thư mục tồn tại
                        if (!is_dir($uploadFileDir)) {
                            mkdir($uploadFileDir, 0777, true);
                        }
                        
                        $dest_path = $uploadFileDir . $newFileName;
                        if(move_uploaded_file($fileTmpPath, $dest_path)) {
                            // Xóa avatar cũ nếu có và tồn tại
                            if (!empty($avatar) && file_exists($uploadFileDir . $avatar)) {
                                @unlink($uploadFileDir . $avatar);
                            }
                            $avatar = $newFileName;
                        }
                    } else {
                        $_SESSION['flash_message'] = "Định dạng file avatar không hợp lệ. Chỉ hỗ trợ JPG, JPEG, PNG, GIF, WEBP!";
                        $_SESSION['flash_type'] = "danger";
                        header('Location: /phamgiahuy/account/profile');
                        exit;
                    }
                }

                if ($this->accountModel->updateAccount($userId, $fullname, $avatar)) {
                    $_SESSION['fullname'] = $fullname;
                    $_SESSION['avatar'] = $avatar;
                    $_SESSION['flash_message'] = "Cập nhật thông tin tài khoản thành công!";
                    $_SESSION['flash_type'] = "success";
                } else {
                    $_SESSION['flash_message'] = "Có lỗi xảy ra khi lưu thông tin!";
                    $_SESSION['flash_type'] = "danger";
                }
            } 
            elseif ($actionType === 'update_password') {
                $currentPassword = $_POST['current_password'] ?? '';
                $newPassword = $_POST['new_password'] ?? '';
                $confirmNewPassword = $_POST['confirm_new_password'] ?? '';

                if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
                    $_SESSION['flash_message'] = "Vui lòng nhập đầy đủ các trường mật khẩu!";
                    $_SESSION['flash_type'] = "danger";
                    header('Location: /phamgiahuy/account/profile');
                    exit;
                }

                if (!password_verify($currentPassword, $account->password)) {
                    $_SESSION['flash_message'] = "Mật khẩu hiện tại không chính xác!";
                    $_SESSION['flash_type'] = "danger";
                    header('Location: /phamgiahuy/account/profile');
                    exit;
                }

                if ($newPassword !== $confirmNewPassword) {
                    $_SESSION['flash_message'] = "Mật khẩu mới nhập lại không khớp!";
                    $_SESSION['flash_type'] = "danger";
                    header('Location: /phamgiahuy/account/profile');
                    exit;
                }

                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
                if ($this->accountModel->updatePassword($userId, $hashedPassword)) {
                    $_SESSION['flash_message'] = "Đổi mật khẩu thành công!";
                    $_SESSION['flash_type'] = "success";
                } else {
                    $_SESSION['flash_message'] = "Có lỗi xảy ra khi đổi mật khẩu!";
                    $_SESSION['flash_type'] = "danger";
                }
            }
            elseif ($actionType === 'update_security') {
                $a1 = trim($_POST['security_a1'] ?? '');
                $a2 = trim($_POST['security_a2'] ?? '');
                $a3 = trim($_POST['security_a3'] ?? '');

                if (empty($a1) || empty($a2) || empty($a3)) {
                    $_SESSION['flash_message'] = "Vui lòng trả lời đầy đủ cả 3 câu hỏi bảo mật!";
                    $_SESSION['flash_type'] = "danger";
                    header('Location: /phamgiahuy/account/profile');
                    exit;
                }

                if ($this->accountModel->updateSecurityQuestions($userId, $a1, $a2, $a3)) {
                    $_SESSION['flash_message'] = "Cập nhật câu hỏi bảo mật thành công!";
                    $_SESSION['flash_type'] = "success";
                } else {
                    $_SESSION['flash_message'] = "Có lỗi xảy ra khi cập nhật câu hỏi bảo mật!";
                    $_SESSION['flash_type'] = "danger";
                }
            }
        }

        header('Location: /phamgiahuy/account/profile');
        exit;
    }

    public function forgotPassword()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_GET['action']) && $_GET['action'] === 'reset') {
            unset($_SESSION['recovery_step'], $_SESSION['recovery_username'], $_SESSION['recovery_error']);
        }

        // Initialize recovery session if not set
        if (!isset($_SESSION['recovery_step'])) {
            $_SESSION['recovery_step'] = 1;
        }

        $step = $_SESSION['recovery_step'];
        $username = $_SESSION['recovery_username'] ?? '';
        $error = $_SESSION['recovery_error'] ?? null;
        
        unset($_SESSION['recovery_error']);

        include 'app/views/account/forgotPassword.php';
    }

    public function verifyUsername()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');

            if (empty($username)) {
                $_SESSION['recovery_error'] = "Vui lòng nhập tên tài khoản!";
                header('Location: /phamgiahuy/account/forgotPassword');
                exit;
            }

            $account = $this->accountModel->getAccountByUsername($username);
            if (!$account) {
                $_SESSION['recovery_error'] = "Tài khoản không tồn tại!";
                header('Location: /phamgiahuy/account/forgotPassword');
                exit;
            }

            if (empty($account->security_a1) || empty($account->security_a2) || empty($account->security_a3)) {
                $_SESSION['recovery_error'] = "Tài khoản này chưa cài đặt câu hỏi bảo mật. Vui lòng liên hệ Admin để đặt lại mật khẩu!";
                header('Location: /phamgiahuy/account/forgotPassword');
                exit;
            }

            $_SESSION['recovery_step'] = 2;
            $_SESSION['recovery_username'] = $username;
        }

        header('Location: /phamgiahuy/account/forgotPassword');
        exit;
    }

    public function verifyQuestions()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_SESSION['recovery_username'] ?? '';
            if (empty($username)) {
                $_SESSION['recovery_step'] = 1;
                header('Location: /phamgiahuy/account/forgotPassword');
                exit;
            }

            $a1 = strtolower(trim($_POST['security_a1'] ?? ''));
            $a2 = strtolower(trim($_POST['security_a2'] ?? ''));
            $a3 = strtolower(trim($_POST['security_a3'] ?? ''));

            if (empty($a1) || empty($a2) || empty($a3)) {
                $_SESSION['recovery_error'] = "Vui lòng nhập câu trả lời cho cả 3 câu hỏi!";
                header('Location: /phamgiahuy/account/forgotPassword');
                exit;
            }

            $account = $this->accountModel->getAccountByUsername($username);
            if (!$account) {
                $_SESSION['recovery_step'] = 1;
                header('Location: /phamgiahuy/account/forgotPassword');
                exit;
            }

            $db_a1 = strtolower(trim($account->security_a1));
            $db_a2 = strtolower(trim($account->security_a2));
            $db_a3 = strtolower(trim($account->security_a3));

            if ($a1 === $db_a1 && $a2 === $db_a2 && $a3 === $db_a3) {
                $_SESSION['recovery_step'] = 3;
            } else {
                $_SESSION['recovery_error'] = "Câu trả lời bảo mật không đúng! Vui lòng thử lại.";
            }
        }

        header('Location: /phamgiahuy/account/forgotPassword');
        exit;
    }

    public function resetPassword()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_SESSION['recovery_username'] ?? '';
            $step = $_SESSION['recovery_step'] ?? 1;

            if (empty($username) || $step != 3) {
                $_SESSION['recovery_step'] = 1;
                header('Location: /phamgiahuy/account/forgotPassword');
                exit;
            }

            $newPassword = $_POST['new_password'] ?? '';
            $confirmNewPassword = $_POST['confirm_new_password'] ?? '';

            if (empty($newPassword) || empty($confirmNewPassword)) {
                $_SESSION['recovery_error'] = "Vui lòng nhập đầy đủ mật khẩu mới!";
                header('Location: /phamgiahuy/account/forgotPassword');
                exit;
            }

            if ($newPassword !== $confirmNewPassword) {
                $_SESSION['recovery_error'] = "Mật khẩu mới nhập lại không khớp!";
                header('Location: /phamgiahuy/account/forgotPassword');
                exit;
            }

            $account = $this->accountModel->getAccountByUsername($username);
            if (!$account) {
                $_SESSION['recovery_step'] = 1;
                header('Location: /phamgiahuy/account/forgotPassword');
                exit;
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
            if ($this->accountModel->updatePassword($account->id, $hashedPassword)) {
                unset($_SESSION['recovery_step'], $_SESSION['recovery_username']);
                $_SESSION['flash_message'] = "Đặt lại mật khẩu thành công! Hãy đăng nhập bằng mật khẩu mới.";
                $_SESSION['flash_type'] = "success";
                header('Location: /phamgiahuy/account/login');
                exit;
            } else {
                $_SESSION['recovery_error'] = "Có lỗi xảy ra khi đặt lại mật khẩu!";
            }
        }

        header('Location: /phamgiahuy/account/forgotPassword');
        exit;
    }
}
