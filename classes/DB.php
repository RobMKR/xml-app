<?php
final class DB {

	/* Connecting to DB when object created	
	* Crating object only from inside of Class
	*/
	private function __construct(){
		try {
		    $this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->pass);
		    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $this->connection->setAttribute(PDO::MYSQL_ATTR_LOCAL_INFILE, true);
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}

	// Static Object
    private static $inst = null;

	// Singleton D.P.
 	public static function Instance(){
        if (self::$inst === null) {
            self::$inst = new DB();
        }
        return self::$inst;
    }
    // Params
	private $connection;
	private $username = 'root';
	private $pass = '';
	private $host = 'localhost';
	private $database = 'xml';
	private $selectables = [];
	private $table;
	private $where;
	private $limit;
	private $query;
	private $order;
	private $having;

	// Select fields
	public function select(){
		$this->selectables = func_get_args();
        return $this;
	}

	// Select Table
	public function from($table){
		$this->table = $table;
		return $this;
	}

	// Where Clause
	public function where($where){
		$this->where = $where;
		return $this;
	}

	// Records Limit
	public function limit($limit){
		$this->limit = $limit;
		return $this;
	}

	// Results order
	public function order($order){
		$this->order = $order;
		return $this;
	}

	public function having($having){
		$this->having = $having;
		return $this;
	}

	// Making a query
	public function prepare(){
		$query = "SELECT ";
        // if the selectables is empty select all
        if(empty($this->selectables)){
            $query .= "*";  
        }
        //else select upon selectables and proceeding with building the query
        $query .= join(', ', $this->selectables). " FROM ". $this->table;
        if(!empty($this->where)){
            $query .= " WHERE ". $this->where;
        }
        if(!empty($this->having)){
        	$query .= " HAVING ". $this->having;
        }
        if(!empty($this->order)){
            $query .= " ORDER BY ". $this->order;
        }
        if(!empty($this->limit)){
            $query .= " LIMIT ". $this->limit;
        }
        $this->query = $query;
        return $this;
	}

	// Run query
	public function run(){
		$result = [];
		$query = $this->connection->prepare($this->query);
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}

	// Direct XML import to mysql
	public function directSaveXml($file){
		$file = str_replace("\\", "/", $file);
		$query = 'LOAD XML INFILE "'.$file.'" INTO TABLE emails ROWS IDENTIFIED BY "<note>"';
		$this->connection->query($query);
		return true;
	}
}
