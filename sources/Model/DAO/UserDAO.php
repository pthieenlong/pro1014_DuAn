<?php
include "/storage/ssd2/188/19378188/public_html/Model/User.php";
// include "C:/xampp/htdocs/pro1014_DuAn/sources/Model/User.php";
class UserDAO {
    private $database; 
    public function __construct() {
        $this->database = new Database();
        $this->database = $this->database->getDatabase();
    }

    public function getUserByID($id) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare("SELECT * FROM `user` WHERE `user`.`id` = ?");
            $query->bind_param('s', $id);

            if($query->execute()) {
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    return new User($user['id'], $user['username'], $user['password'], $user['email'], $user['fullname'], $user['phone_number'], $user['currency'], $user['role_id'], $user['avatar']);
                } else return false;
            } else return false;
        }
    }
    public function getUserByEmail($email) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user` WHERE `user`.`email` = ?');
            $query->bind_param('s', $email);
            if($query->execute()) {
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    return new User($user['id'], $user['username'], $user['password'], $user['email'], $user['fullname'], $user['phone_number'], $user['currency'], $user['role_id'], $user['avatar']);
                } else return false;
            } else return false;
        }
    }
    public function getUserByUsername($username) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user` WHERE `user`.`username` = ?');
            $query->bind_param('s', $username);
            if($query->execute()) {
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    return new User($user['id'], $user['username'], $user['password'], $user['email'], $user['fullname'], $user['phone_number'], $user['currency'], $user['role_id'], $user['avatar']);
                } else return false;
            } else return false;
        }
    }
    public function getAllUsers() {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user`');
            if($query->execute()) {
                $users = [];
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $user = new User($row['id'], $row['username'], $row['password'], $row['email'], $row['fullname'], $row['phone_number'], $row['currency'], $row['role_id'], $row['avatar']);
                        $users[] = $user;
                    }
                    return $users;
                } else return false;
            } else return false;
        }
    }
    public function addUser($username,$password,$email,$fullname) {//var_dump("$username,$password,$email,$fullname");
        if($this->database->connect_error){
            return false;
        } else {
            $query = $this->database->prepare('INSERT INTO `user`(`username`, `password`, `email`, `fullname`,`phone_number`) VALUES (?,?,?,?,0)');
            $query->bind_param("ssss",$username,$password,$email,$fullname);
            if($query->execute()){
                return true;
            }
            else return false;
        }
    }
    public function isUserExist($id) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user` WHERE `user`.`id` = ?');
            $query->bind_param("s", $id);

            if($query->execute()) {
                $result = $query->get_result();
                return $result->num_rows > 0;
            } else return false;
        }
    }
    public function isUsernameExist($username) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user` WHERE `user`.`username` = ?');
            $query->bind_param("s", $username);

            if($query->execute()) {
                $result = $query->get_result();
                return $result->num_rows > 0;
            } else return false;
        }
    }
    public function isEmailExist($username) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user` WHERE `user`.`email` = ?');
            $query->bind_param("s", $username);

            if($query->execute()) {
                $result = $query->get_result();
                return $result->num_rows > 0;
            } else return false;
        }
    }
    public function isPhonenumberExist($phonenumber) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('SELECT * FROM `user` WHERE `user`.`phone_number` = ?');
            $query->bind_param("s", $phonenumber);

            if($query->execute()) {
                $result = $query->get_result();
                return $result->num_rows > 0;
            } else return false;
        }
    }
    public function depositByUserID($id, $amount) {
        if($this->database->connect_error){
            return false;
        }else {
            $query = $this->database->prepare("UPDATE `user` SET `user`.`currency` = `user`.`currency` + ? WHERE ? > 0 AND `user`.`id`=? ");
            $query->bind_param("sss", $amount, $amount, $id);
            return $query->execute();
        }
    }
    public function UpdateUser($fullname,$email,$phonenumber,$role,$id){
        if($this->database->connect_error){
            return false;
        }else {
            $query = $this->database->prepare("UPDATE `user` SET `fullname`=?,`email`=?,`phone_number`=?,`role_id`=? WHERE `user`.`id`=?");
            $query->bind_param("sssss",$fullname,$email,$phonenumber,$role,$id);
            if($query->execute()){
                return true;
            }
            else return false;
        }
    }
    public function DeleteUser($id){
        if($this->database->connect_error){
            return false;
        } else {
            $query = $this->database->prepare("DELETE FROM `user` WHERE `id`='$id'");
            if($query->execute()){
                return true;
            }
            else return false;
        }
    }
    public function addUserAdmin($username,$password,$email,$fullname,$phonenumber,$role) {
        if($this->database->connect_error){
            return false;
        } else {
            $query = $this->database->prepare('INSERT INTO `user`(`role_id`,`username`, `password`, `email`, `fullname`,`phone_number`, `avatar`) VALUES (?,?,?,?,?,?, "./assets/userImg/man.png")');
            $query->bind_param("ssssss",$username,$password,$email,$fullname,$phonenumber,$role);
            if($query->execute()){
                return true;
            }
            else return false;
        }
    }
    public function widthdraw($amount, $userID) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare('UPDATE `user` SET `user`.`currency` = `user`.`currency` - ? WHERE `user`.`id` = ? AND `user`.`currency` > ?');
            $query->bind_param('sss', $amount, $userID, $amount);

            return $query->execute();
        }
    }
    public function UserChangePhone($phonenumber,$id){
        if($this->database->connect_error){
            return false;
        }else {
            $query = $this->database->prepare("UPDATE `user` SET `phone_number`=? WHERE `id`=?");
            $query->bind_param("ss",$phonenumber,$id);
            if($query->execute()){
                return true;
            }
            else return false;
        }
    }
    public function UserChangeEmail($email,$id){
        if($this->database->connect_error){
            return false;
        }else {
            $query = $this->database->prepare("UPDATE `user` SET `email`=? WHERE `id`=?");
            $query->bind_param("ss",$email,$id);
            if($query->execute()){
                return true;
            }
            else return false;
        }
    }
    public function UserChangePassword($password,$id){
        if($this->database->connect_error){
            return false;
        }else {
            $query = $this->database->prepare("UPDATE `user` SET `password`=? WHERE `id`=?");
            $query->bind_param("ss",$password,$id);
            if($query->execute()){
                return true;
            }
            else return false;
        }
    }
    public function UserChangeFullname($fullname,$id){
        if($this->database->connect_error){
            return false;
        }else {
            $query = $this->database->prepare("UPDATE `user` SET `fullname`=? WHERE `id`=?");
            $query->bind_param("ss",$fullname,$id);
            if($query->execute()){
                return true;
            }
            else return false;
        }
    }
    public function UserChangeImg($img_url, $id){
        if($this->database->connect_error){
            return false;
        }else {
            $query = $this->database->prepare("UPDATE `user` SET `avatar`=? WHERE `user`.`id`=?");
            $query->bind_param("ss",$img_url,$id);
            if($query->execute()){
                return true;
            }
            else return false;
        }
    }
    public function UserUpdateCurrency($currency,$id){
        if($this->database->connect_error){
            return false;
        }else {
            $query = $this->database->prepare("UPDATE `user` SET `currency`=? WHERE `id`=?");
            $query->bind_param("ss",$currency,$id);
            if($query->execute()){
                return true;
            }
            else return false;
        }
    }
    public function getUserBySearch($keyword){
        if($this->database->connect_error){
            return false;
        } else {
            $query = $this->database->prepare("SELECT * FROM `user` WHERE `fullname` LIKE '%".$keyword."%' or `phone_number` LIKE '%".$keyword."%' or `email` LIKE '%".$keyword."%' ");     
            if($query->execute()) {
                $users = [];
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $user = new User($row['id'], $row['username'], $row['password'], $row['email'], $row['fullname'], $row['phone_number'], $row['currency'], $row['role_id'], $row['avatar']);
                        $users[] = $user;
                    }
                    return $users;
                 } else return false;
            } else return false;
        }
    }
    public function updateUserPassword($id, $password) {
        if($this->database->connect_error){
            return false;
        }else {
            $query = $this->database->prepare("UPDATE `user` SET `user`.`password`=? WHERE `user`.`id`=?");
            $query->bind_param("ss",$password,$id);
            return $query->execute();
        }
    }
}

?>