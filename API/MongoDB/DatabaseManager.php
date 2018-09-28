<?php namespace com\arkhamhorrordb\API\MongoDB; 
//---------------------------------------------------------------------------------
//
// ----- CONNECTION CLASS
//
//---------------------------------------------------------------------------------
class DatabaseManager {
    //---------------------------------------------------------------------------------
    // ----- PRIVATE
    //---------------------------------------------------------------------------------
    private $m_uri = null;
    private $m_username = null;
    private $m_password = null;
    private $m_db = null;
    private $m_coll = null;
    private $m_fullUri = null;
    /*
    * @param string     $uri        Database uri   
    * @param string     $username   Database username
    * @param string     $password   Database password
    * @param string     $db         Database name
    */
    function __construct( $uri, $username, $password, $db ) { //needded for connection
        $this->m_uri = $uri;
        $this->m_username = $username;
        $this->m_password = $password;
        $this->m_db = $db;
        $this->m_fullUri = "mongodb://" . $this->m_username . ":" . $this->m_password . "@" . $this->m_uri;
    }
    /*
    * @param string         $collection     Database collection  
    * @param array|object   $filter         Query-filter
    * @param array|object   $options        Query-options
    * @return void 
    */
    public function find( $collection, $filter, $options ) { // return json array
        $result = [];
        $query = new \MongoDB\Driver\Query( $filter, $options );
        $manager = new \MongoDB\Driver\Manager( $this->m_fullUri );
        $cursor = $manager->executeQuery( "$this->m_db" . "." . $collection, $query);   

        foreach ( $cursor as $doc ) {   
            $doc = json_encode( $doc );
            array_push( $result, $doc );
        } 

        $count = $this->countDocs($collection, $filter);
        array_push( $result, $count );
        //---------------------------------------------------------------------------------
        // ----- API response
        //---------------------------------------------------------------------------------
        $result = json_encode( $result );
        header("content-type:application/json");
        echo $result;
    }
    /*
    * @param string     $collection     Database collection  
    * @return number
    */
    public function countDocs($collection, $filter) {
        $cmd = new \MongoDB\Driver\Command(['count' => $collection, 'query' => $filter]);
        $manager = new \MongoDB\Driver\Manager( $this->m_fullUri );
        $cursor = $manager->executeCommand( "$this->m_db", $cmd);   
        foreach ($cursor as $key) {
            $key = (int)$key->n;
            return $key;
        }   
    }
    /*
    * @param string           $collection     Database collection  
    * @param array|object     $data           Database addition 
    * @return void 
    */
    public function insert( $collection, $data ) {
        // echo "insert";
        $bulk = new \MongoDB\Driver\BulkWrite(['ordered' => true]);
        $bulk->insert( $data );
        $manager = new \MongoDB\Driver\Manager( $this->m_fullUri );
        $writeConcern = new \MongoDB\Driver\WriteConcern( \MongoDB\Driver\WriteConcern::MAJORITY, 1000 );
        $result = $manager->executeBulkWrite( "$this->m_db" . "." . $collection, $bulk, $writeConcern );
    }
    /*
    * update document 
    *
    * @return void
    */
    public function update ( $collection, $data ) {
        // code for updating documents
    }
    /*
    * delete document 
    *
    * @return void
    */
    public function delete ( $collection, $data ) {
        // code for deleting documents
    }
}

?>
