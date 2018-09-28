<?php namespace com\arkhamhorrordb\API\MongoDB; 

class User {
    //---------------------------------------------------------------------------------
    // ----- Public
    //---------------------------------------------------------------------------------
    public $username = null; // string
    public $password = null; // salted string
    public $email = null; // string
    //---------------------------------------------------------------------------------
    // ----- Constructor
    //---------------------------------------------------------------------------------
    function __construct($username, $password, $email) {
        $this->username = $username; // string
        $this->password = $password; // salted string SEND TO SALT METHOD. (create static class?)
        $this->email = $email; // string
    }
    /*
    * 
    * @return array containing json-objects
    */
    private function delete() {

    }
    private function create() {
        $m = 
    }
}

    function __construct() {
        $this->checkPost();
    }
    /*
    * 
    * 
    */
    private function checkPost() {
        //echo "checkPost<br><hr>";
        if ( isset( $_POST['username'] ) ) {
            if ( htmlspecialchars( $_POST['password1'] ) == htmlspecialchars( $_POST['password2'] )) {
                $username = htmlspecialchars( $_POST['username'] );
                $password = htmlspecialchars( $_POST['password1'] );
                $email = htmlspecialchars( $_POST['email'] );
                $this->create( $username, $password, $email );
            } else {
                echo "error: passwords do not match";
            }
        }
    }
    /*
    * 
    * 
    */
    private function createUser( $username, $password, $email ) {
        //echo "createUser<br><hr>";
        $user = new User( $username, $password, $email );
        [
            'username' => $user->username,
            'password' => $password = hash("ripemd128", "?tBm?" . $user->password . "*mo22tj"),
            'email' => $user->email
        ]
        $this->checkAvailability($user);
    }
    /*
    * 
    * 
    */
    private function checkAvailability($user) {
        //echo "checkUsername<br><hr>";
       /* $filter = [];
        $query = new \MongoDB\Driver\Query($filter);
        $manager = new \MongoDB\Driver\Manager();
        $cursor = $manager->executeQuery( "mo222tj.users", $query ); */
        $m = new Manager();
        $allUsers = new 

        foreach ( $cursor as $u ) {
            $count++;
            if ( $u->username == $user->username ) {
                echo "error: a user with that name already exists";
            }
            else if ( $u->email == $user->email ) {
                echo "error: a user with that email already exists";
            }
            else { $this->insertUser($user); }
        }
        if ($count < 1) {
           $this->insertUser($user); 
        }
    }

?>