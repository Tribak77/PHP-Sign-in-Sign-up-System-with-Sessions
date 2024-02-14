<?php
// Include the Membre class
require_once 'Membre.php';

// CommunityManager class for managing members
class CommunityManager
{
    private $members = [];  // Array to store registered members

    // Method to register a new member
    public function registerMember($fullName, $email, $pseudo, $password, $dateOfBirth)
    {
        $member = new Membre($fullName, $email, $pseudo, $password, $dateOfBirth);
        $this->members[$member->getId()] = $member;
    }

    // Method to handle user login
    public function login($pseudo, $password)
    {
        foreach ($this->members as $member) {
            // Check if pseudo matches and password is verified
            if ($member->getPseudo() === $pseudo && password_verify($password, $member->getPassword())) {
                $_SESSION['user'] = $member->getId();  // Set user session
                return $member;  // Return the logged-in member
            }
        }
    }

    public function loginAdmin($pseudo, $password)
    {
        foreach($this->members as $member) {
            if( $member->getPseudo() === $pseudo && password_verify($password, $member->getPassword()) && str_starts_with($member->getPseudo(), 'admin_') !== false) {
                $_SESSION['user'] = $member->getId();  
                return $member;
            }
        }
    }
    
    // Method to get member ID to use it in the edit
    public function getMemberById($memberId){
        foreach ($this->members as $member) {
            if ($member->getId() === $memberId) {
                return $member;
            }
        }
    }

    // Method to show all members
    public function showAllMembers()
    {
        return $this->members;
    }

    public function deleteMember($memberId)
    {
        // Check if the member with the specified ID exists
        if (isset($this->members[$memberId])) {
            // Remove the member from the array
            unset($this->members[$memberId]);
        }
    }

}
?>
