<?php

class Membre
{
    private $id;
    private $fullName;
    private $email;
    private $pseudo;
    private $password;
    private $dateOfBirth;

    public function __construct($fullName, $email, $pseudo, $password, $dateOfBirth)
    {
        $this->id = uniqid();
        $this->fullName = $fullName;
        $this->setEmail($email);
        $this->pseudo = $pseudo;
        $this->setPassword($password);
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    public function getPassword()
    {
        return $this->password;
    }


    
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }
   

    
    // Setter method for setting member's email with validation
    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && strpos($email, '@gmail.com') !== false) {
            $this->email = $email;
        } else {
            throw new Exception("Invalid email format. Please provide a valid Gmail address.");
        }
    }

    // Setter method for setting member's password with validation and hashing
    public function setPassword($password)
    {
        if (preg_match('/^(?=.*\d{2})(?=.*[a-zA-Z]{4}).{6,}$/', $password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->password = $hashedPassword;
        } else {
            throw new Exception("Invalid password format. It should contain at least 2 digits and 4 letters.");
        }
    }
}
?>
