<?php
final class DB {
	function __construct(){
		try {
		    $this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->database, $this->username, $this->pass);
		    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $this->connection->setAttribute(PDO::MYSQL_ATTR_LOCAL_INFILE, true);
		} catch (PDOException $e) {
		    print "Error!: " . $e->getMessage() . "<br/>";
		    die();
		}
	}

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

	public function select(){
		$this->selectables = func_get_args();
        return $this;
	}

	public function from($table){
		$this->table = $table;
		return $this;
	}

	public function where($where){
		$this->where = $where;
		return $this;
	}

	public function limit($limit){
		$this->limit = $limit;
		return $this;
	}

	public function order($order){
		$this->order = $order;
		return $this;
	}

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
        if(!empty($this->order)){
             $query .= " ORDER BY ". $this->order;
        }
        if(!empty($this->limit)){
             $query .= " LIMIT ". $this->limit;
        }
        $this->query = $query;
        return $this;
	}

	public function run(){
		$result = [];
		$query = $this->connection->prepare($this->query);
		$query->execute();
		$result = $query->fetchAll(PDO::FETCH_ASSOC);
	    return $result;
	}

	public function directSaveXml($file){
		$file = str_replace("\\", "/", $file);
		$query = 'LOAD XML INFILE "'.$file.'" INTO TABLE test_table ROWS IDENTIFIED BY "<note>"';
		$this->connection->query($query);
		return true;
	}
}
