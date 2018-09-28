<?php namespace com\arkhamhorrordb\API\System; 
//--------------------------------------------------------------------------
// Public class
//--------------------------------------------------------------------------

/**
*  ...
*
*  @version    1.0
*  @copyright  Copyright (c) 2017.
*  @license    Creative Commons (BY-NC-SA)
*  @since      Feb 13, 2017
*  @author     Michaela Olausson <michaelaolausson@gmail.com>
*/
class Main {
    //-------------------------------------------------------------
    // CONSTANTS
    //------------------------------------------------------------- 
    /**
	*  Database - uri 
	*
	*  @default localhost 127.0.0.1
    *  @external ip 31.44.228.141
	*/
    const DATABASE_URI = '127.0.0.1/';
    /**
	*  Database - name 
	*
	*  @default mo222tj     Port: 62684
	*/
    const USERNAME = 'michaela.olausson';
    /**
	*  Database - name 
	*
	*  @default mo222tj     Port: 62684
	*/
    const PASSWORD = '!XDytgQ6';
    /**
	*  Database - name 
	*
	*  @default mo222tj     Port: 62684
	*/
    const DATABASE =  'mo222tj';
    /**
	*  Database collection 
	*
	*  @default arkham_horror
	*/
    const COLLECTION = 'arkham_horror';
    //-------------------------------------------------------------
    // PRIVATE
    //-------------------------------------------------------------
    /*
    *  
    */
    private $manager = null;
    /*
    *  
    */
    //-------------------------------------------------------------
    // CONSTRUCTOR
    //-------------------------------------------------------------
    /*
    * empty
    */
    function __construct() {
        $this->initManager();
    }
    //----------------------------------------------------------------------
	// Public methods
	//----------------------------------------------------------------------
    function initManager() {
        $this->manager = new \com\arkhamhorrordb\API\MongoDB\DatabaseManager( self::DATABASE_URI, self::USERNAME, self::PASSWORD, self::DATABASE, self::COLLECTION );
    }
    /*
    * @return cursor object
    */
    public function connect() {
        $result = $this->checkRequest(); 
    }
    private function checkRequest() {
        //----------------------------------------------------------------------
	    // GET
	    //----------------------------------------------------------------------
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $availableParams = array("filter","search","sort","limit"); // supported GET parameters

            foreach ($_GET as $key => $value) {
                //----------------------------------------------------------------------
                // makes sure that limit is an int
                //----------------------------------------------------------------------
                if ($key  == "limit") {
                    $arr = $this->createArray($_GET['limit']);
                    if(count($arr) > 2) {
                        echo "Error: limit has to many values. Supported syntax: limit=limit+skip.";
                    }
                    if (isset($arr[1])) {
                        $page = (int)$arr[1];
                    }
                    $limit = (int)$arr[0];
                }
                //----------------------------------------------------------------------
                // checks if requested parameters is supported by the api.
                //----------------------------------------------------------------------
                if (!in_array($key, $availableParams)) {
                     echo "Error: parameter " . '"' . $key  . '"' . " is not supported";
                     return;
                }
            }
            //----------------------------------------------------------------------
            // limit has to be set.
            //----------------------------------------------------------------------
            if (isset($_GET['limit'])) {
                if(count($arr) == 2) {
                    $skip = $page * $limit;
                    $filter = $this->getFilter();
                    $options = $this->getOptions($limit, $skip);
                    $result = $this->manager->find( 'arkham_horror', $filter, $options ); 
                }
                else {
                    $filter = $this->getFilter();
                    $options = $this->getOptions($limit);
                    $result = $this->manager->find( 'arkham_horror', $filter, $options );
                }
            }
            else { echo "Error: set limit."; }
        }
        //----------------------------------------------------------------------
        // POST
        //----------------------------------------------------------------------
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->postData();
            $result = $this->manager->insert( $data );
        }
        //----------------------------------------------------------------------
        // PUT
        //----------------------------------------------------------------------
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $data = $this->putData();
            $result = $this->manager->update( $id, $data );
        }
        //----------------------------------------------------------------------
        // DELETE
        //----------------------------------------------------------------------
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $data = $this->deleteData();
            $result = $this->manager->delete( $data );
        }
    }
    /*
    * returns if limit is missning
    * @return  
    */
    private function getOptions($limit, $skip = null) {
        $q = new \com\arkhamhorrordb\API\MongoDB\Querybuilder();   
        //----------------------------------------------------------------------
        // sort
        //----------------------------------------------------------------------
        if (isset($_GET['sort'])) { 
            $arr = $this->createArray($_GET['sort']); // creates array.
            $options = $q->createOptions( $limit, $skip, $arr ); 
        }
        //----------------------------------------------------------------------
        // create default
        //----------------------------------------------------------------------
        else { 
            $options = $q->createOptions($limit, $skip); 
        }
        return $options;
    }    
    /*
    * returns if limit is missning
    * @return  
    */
    private function getFilter() {
        $q = new \com\arkhamhorrordb\API\MongoDB\Querybuilder();   
        //----------------------------------------------------------------------
        // filter
        //----------------------------------------------------------------------
        if (isset($_GET['filter'])) {  
            $arr = $this->createArray($_GET['filter']); // creates array.
            $filter = $q->createFilter($arr); 
        }
        //----------------------------------------------------------------------
        // create default
        //----------------------------------------------------------------------
        else { 
            $filter = $q->createFilter(); 
        } 
        return $filter;
    }
    /*
    * @return  array
    */
    private function postData() {}
    /*
    * @return  array
    */
    private function putData() {}
    /*
    * @return  array 
    */
    private function deleteData() {}
    /*
    * @param string
    * create array from string
    * @return array
    */
    private function createArray($string) { 
        $array = explode(' ', $string);
        return $array;
    }
}

?>