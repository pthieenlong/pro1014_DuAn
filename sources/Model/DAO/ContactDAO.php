<?php
include_once '/storage/ssd2/188/19378188/public_html/Model/Contact.php';
include_once "/storage/ssd2/188/19378188/public_html/Utils/Utils.php";
include_once "/storage/ssd2/188/19378188/public_html/Utils/Database.php";

//  include '/xampp/htdocs/pro1014_DuAn/sources/Model/Contact.php';
// include_once "/XAMPP/htdocs/pro1014_duan/sources/Utils/Utils.php";
// include_once "/XAMPP/htdocs/pro1014_duan/sources/Utils/Database.php";

class ContactDAO {
    private $database;
    public function __construct()
    {
        $this->database = new Database();
        $this->database = $this->database->getDatabase();
    }
    public function insertNewContact($fullname, $email, $subject, $message, $type) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare("INSERT INTO `contact`(`fullname`,`email`, `subject`, `message`, `type`) VALUES (?, ?, ?, ?, ?)");
            $query->bind_param("sssss", $fullname, $email, $subject, $message, $type);

            return $query->execute();
        }
    }   
    public function insertNewContactToGetNotifications($fullname, $email, $type) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare("INSERT INTO `contact`(`fullname`,`email`, `type`) VALUES (?, ?, ?)");
            $query->bind_param("sss", $fullname, $email, $type);

            return $query->execute();
        }
    }   
    public function removeContactByID($id) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare("DELETE FROM `contact` WHERE `contact`.`id` = ? ");

            $query->bind_param("s", $id);
            return $query->execute();
        }
    }
    public function getAllContacts() {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare("SELECT * FROM `contact`");
            if($query->execute()) {
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    $contacts = [];
                    while($row = $result->fetch_assoc()) {
                        $contact = new Contact($row['id'], $row['fullname'], $row['email'], $row['type'], $row['subject'], $row['message']);

                        $contacts[] = $contact;
                    }
                    return $contacts;
                } else return false;
            } else return false;
        }
    }
    public function getContactByID($id) {
        if($this->database->connect_error) {
            return false;
        } else {
            $query = $this->database->prepare("SELECT * FROM `contact` WHERE `contact`.`id` = ?");
            $query->bind_param('s', $id);

            if($query->execute()) {
                $result = $query->get_result();
                if($result->num_rows > 0) {
                    $contact = $result->fetch_assoc();
                    return new Contact($contact['id'], $contact['fullname'], $contact['email'], $contact['type'], $contact['subject'], $contact['message']);
                } else return false;
            } else return false;
        }
    }
}
?>