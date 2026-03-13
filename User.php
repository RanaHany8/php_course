<?php
class User {
    private $db;
    private $userData;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

  
    public function getAllUsers() {
        try {
            $stmt = $this->db->query("SELECT * FROM users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

 
    public function getUserById($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $this->userData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->userData;
        } catch (PDOException $e) {
            return null;
        }
    }

  
    public function update($id, $data) {
        try {
            $sql = "UPDATE users SET fname=?, lname=?, address=?, country=?, gender=?, skills=?, profile_pic=? WHERE id=?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                $data['fname'], 
                $data['lname'], 
                $data['address'], 
                $data['country'], 
                $data['gender'], 
                $data['skills'], 
                $data['profile_pic'], 
                $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }


    public function delete($id) {
        try {
           
            $user = $this->getUserById($id);
            if ($user && !empty($user['profile_pic']) && file_exists($user['profile_pic'])) {
                unlink($user['profile_pic']);
            }
            
          
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }

  

public function getProfilePic() {
    if (!empty($this->userData['profile_pic'])) {
        $path = $this->userData['profile_pic'];
      
        $path = trim($path);
        
     
        if (file_exists(__DIR__ . '/../' . $path) || file_exists($path)) {
            return $path;
        }
    }
    return 'uploads/default.png'; 
}

}