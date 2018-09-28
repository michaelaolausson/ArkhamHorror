<?php namespace com\arkhamhorrordb\API\MongoDB; 

class Querybuilder {
    /*
    * CONSTRUCTOR
    */
    function __construct() {
    }
    /*
    * @param string
    * create options array
    *  @return array
    */
    public function createOptions( $limit, $skip = null, $arr = null) { // return array
        $len = count($arr);
        if ($len == 1) {
            if ($skip == null) {
                $options = array( 'sort' => array( $arr[0] => 1 ), 'limit' => $limit ); 
                var_dump($options);
            }
            else {
                $options = array( 'sort' => array( $arr[0] => 1 ), 'limit' => $limit, 'skip' => $tskip ); 
                var_dump($options);
            }
        }


        else if ($len == 2) {
            if ($arr[1] == 'asc') {
                if ($skip == null) {
                    $options = array( 'sort' => array( $arr[0] => 1 ), 'limit' => $limit );
                }
                else  {
                $options = array( 'sort' => array( $arr[0] => 1 ), 'limit' => $limit, 'skip' => $skip ); 
                }
            } 
            else if ($arr[1] == 'desc') {
                if ($skip == null) {
                    $options = array( 'sort' => array( $arr[0] => -1 ), 'limit' => $limit );
                }
                else {
                    $options = array( 'sort' => array( $arr[0] => -1 ), 'limit' => $limit, 'skip' => $skip);
                }
            }
        } 
        // if sort array is missing
        else {  
            if ($skip == null) {
             $options = array( 'sort' => array( 'title' => 1 ), 'limit' => $limit);
            } else {
                $options = array( 'sort' => array( 'title' => 1 ), 'limit' => $limit, 'skip' => $skip);
            }
        }
        return $options;
    }
    /*
    * @param string
    * create filter array
    * @return array
    */
    public function createFilter($arr = null) {
        if (!$arr == null) {
            $len = count($arr);
            if ($len == 2 ) {
                $filter = array( $arr[0] => $arr[1] );
            }
        }
        else { $filter =  []; }
        return $filter;
    }
}

?>