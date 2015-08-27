<?php

/**
 * @package   Simple PDO Class
 * @author    Said Abdul Aziem, CairoCoder.com, CairoCoder@gmail.com
 * @copyright Copyright June 2013
 */

class db {
	private $host   = 'localhost';
	private $user   = 'root';
	private $pass   = '';
	private $dbname = 'tameras_tasksapp';

	protected $dbh;
	private $error;
	protected $stmt;

	public function __construct(){
 		// Set DSN
		$dsn = 'mysql:host=' . $this->host . '; dbname=' . $this->dbname;
		// Set options
		$options = array(
		    PDO::ATTR_PERSISTENT => true,
		    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);
		// Create a new PDO instanace
		try {
		    $this->dbh = new PDO($dsn, $this->user, $this->pass,$options);
		    $this->dbh->exec("set names utf8");
		}
		//Catch any errors
		catch (PDOException $e) {
		    $this->error = $e->getMessage();
		}

		if($this->dbh == NULL){
			echo '<script>window.location.href="http://www.iravin.com/devteam/app/serverError.php";</script>';
		}
	}

	public function query($query){
	    $this->stmt = $this->dbh->prepare($query);
	}

	public function bind($param, $value, $type = null){
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
				  $type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}

	public function execute(){
		return $this->stmt->execute();
	}

	public function fetchAll(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function fetch(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function rowCount(){
		return $this->stmt->rowCount();
	}

	public function lastInsertId(){
		return $this->dbh->lastInsertId();
	}

	public function beginTransaction(){
		return $this->dbh->beginTransaction();
	}

	public function endTransaction(){
		return $this->dbh->commit();
	}

	public function cancelTransaction(){
		return $this->dbh->rollBack();
	}

	public function debugDumpParams(){
		return $this->stmt->debugDumpParams();
	}

	public function getProdByCat($catId)
	{
		$this->query('SELECT * FROM products
					  WHERE qty > 50
					  AND cat_id = :catId
					  ORDER BY cat_id');
		$this->bind(':catId', $catId);
		$result = $this->fetchAll();
		return $result;
	}

	public function getCurCats()
	{
		$this->query('SELECT DISTINCT(`cat_id`) FROM products');
		$result = $this->fetchAll();
		foreach ($result as $key => $value) {
			$this->query('SELECT * FROM categories WHERE cat_id = :catId');
			$this->bind(':catId', $value['cat_id']);
			$curCats[] = $this->fetch();
		}
		return $curCats;
	}

	public function getCatDesc($mainCatId)
	{
		$this->query('SELECT `cat_id`, `desc` FROM categories WHERE main_cat_id = :mainCatId');
		$this->bind(':mainCatId', $mainCatId);
		$result = $this->fetchAll();
	}

	public function getProdBySize($catId, $priceX, $priceY)
	{
		$this->query('SELECT * FROM products
					  WHERE cat_id = :catId
					  AND rtp BETWEEN :priceX
					  AND :priceY');
		$this->bind(':catId', $catId);
		$this->bind(':priceX', $priceX);
		$this->bind(':priceY', $priceY);
		$result = $this->fetchAll();
		return $result;
	}

	public function getProdImages($itemId)
	{
		$this->query('SELECT `img` FROM product_images WHERE item_id = :itemId');
		$this->bind(':itemId', $itemId);
		$result = $this->fetchAll();
		return $result;
	}

	public function getProdDetails($itemId)
	{
		$this->query('SELECT `item_id`, `desc`, `rtp`, `msrp`, `qty` FROM products WHERE item_id = :itemId');
		$this->bind(':itemId', $itemId);
		$result = $this->fetch();
		return $result;
	}

	public function closeConn(){
		$this->dbh = NULL;
	}
}

// Instantiate database.
$db = new db();