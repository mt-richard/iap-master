<?php

class mysqldatabase
{
    public $connection;
    public $db;
    private $last_query;
    private $magic_quotes_active;
    private $new_enough_php;

    function __construct($d)
    {
        $this->db = $d;
        $this->open_connection();
        // $this->magic_quotes_active = get_magic_quotes_gpc();
        $this->new_enough_php = function_exists("mysql_real_escape_string");
    }

    public function open_connection()
    {
        $this->connection = mysqli_connect(
            DB_SERVE,
            DB_USER,
            DB_PASS,
            $this->db
        );
        if (!$this->connection) {
            die("User do not match!" . mysqli_connect_error());
        }
        //selecting database
        $select = mysqli_select_db($this->connection, $this->db);
        if (!$select) {
            die("Database do not match!" . mysqli_connect_error());
        }
    }

    public function close_connection()
    {
        if (isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }
	public function fetch($query){
		return mysqli_fetch_all(mysqli_query($this->connection,$query),MYSQLI_ASSOC);
	}
    public function query($sql)
    {
        $this->last_query = $sql;
        $result = mysqli_query($this->connection, $sql);
        $this->comfirm($result);
        return $result;
    }

    public function fetch_array($query)
    {
        return mysqli_fetch_array($query);
    }

    public function num_rows($result)
    {
        return mysqli_num_rows($result);
    }
    public function inset_id()
    {
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows()
    {
        return mysqli_affected_rows($this->connection);
    }

    public function escape_value($value)
    {
        if ($this->new_enough_php) {
            // undo any magic quotes effect so mysql_real_escape_string can do the work
            if ($this->magic_quotes_active) {
                $value = stripslashes($value);
            }
            $value = mysqli_real_escape_string($this->connection, $value);
        } else {
            // before php v4.3.0
            if (!$this->magic_quotes_active) {
                $value = addslashes($value);
            }
        }
        return $value;
    }
    private function comfirm($result)
    {
        if (!$result) {
            $output = "Query Failed.  " . mysqli_error($this->connection);
            $output .= $this->last_query;
            die($output);
        }
    }
// $database->count_all("users where status='1'")
    public function count_all($table)
    {
        $sql = "SELECT COUNT(*) FROM {$table}";
        $result = $this->query($sql);
        $this->comfirm($result);
        $number = $this->fetch_array($result);
        return array_shift($number);
    }

    public function count_alls($table)
    {
        $sql = "SELECT SUM(1) AS total FROM {$table}";
        $result = $this->query($sql);
        $this->comfirm($result);
        $number = $this->fetch_array($result);
        return $number["total"];
    }

    public function create($table, $fields = [])
    {
        $keys = array_keys($fields);
        $values = "";
        $x = 1;
        $fieldsCount = count($fields);

        $sql =
            "INSERT INTO {$table} (`" .
            implode("`,`", $keys) .
            "`) VALUES ('" .
            implode('\',\'', $fields) .
            "')";
        $this->query($sql);
        if ($this->affected_rows()) {
            return true;
        }
        return false;
    }

    public function update($table, $where, $fields = [])
    {
        $sql = "UPDATE $table SET ";
        foreach ($fields as $key => $value) {
            $sql .= "`$key` = '$value',";
        }
        $sql = rtrim($sql, ",");
        $sql .= " WHERE " . $where;

        $this->query($sql);
        if ($this->affected_rows()) {
            return true;
        }
        return false;
    }

    public function getAll($table)
    {
        $this->last_query = "SELECT * FROM $table";
        $result = mysqli_query($this->connection, $this->last_query);
        return (object) mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function getArray($columns, $table, $condition)
    {
        $this->last_query = "SELECT $columns FROM $table WHERE $condition LIMIT 1";
        $result = mysqli_query($this->connection, $this->last_query);
        return mysqli_fetch_array($result);
    }
    
    public function insert($table, $data)
    {
        if (!empty($data) && is_array($data)) {
            $columns = "";
            $values = "";
            $i = 0;
            // if (!array_key_exists("time", $data)) {
            //     $data["time"] = date("Y-m-d H:i:s");
            // }
            // insert into(1,2,4)

            foreach ($data as $key => $val) {
                $pre = $i > 0 ? ", " : "";
                $columns .= $pre . $key;
                $values .= $pre . "'" . $val . "'";
                $i++;
            }
            $query =
                "INSERT INTO " .
                $table .
                " (" .
                $columns .
                ") VALUES (" .
                $values .
                ")";
            $insert = $this->query($query);
            $this->comfirm($insert);
            return $this->inset_id();
        } else {
            return false;
        }
    }

  
    public function get($columns, $table, $condition)
	{
		$this->last_query = "SELECT $columns FROM $table WHERE $condition LIMIT 1";
		$result = mysqli_query($this->connection, $this->last_query);
		return (object)mysqli_fetch_array($result);
	}
      /**
     * Begin a database transaction to a current connection
     */
    public function beginTransaction($dbcon=null)
    {
        if(isset($dbcon)){
            mysqli_begin_transaction($dbcon);
        }else{
            mysqli_begin_transaction($this->connection);
        }
    }
     /**
     * Commit a transaction
     */
    public function commit($dbcon=null)
    {
        if(isset($dbcon)){
            mysqli_commit($dbcon);
        }else{
            mysqli_commit($this->connection);
        }
    }

    /**
     * Roll back a transaction
     */
    public function rollBack($dbcon=null)
    {
        if(isset($dbcon)){
            mysqli_rollback($dbcon);
        }else{
            mysqli_rollback($this->connection);
        }
    }
    public function resultCount($query)
    {
        $this->last_query = "SELECT COUNT(1) as total FROM ($query) AS total";
        $result = mysqli_query($this->connection, $this->last_query);
        return (object) mysqli_fetch_array($result);
    }
    public function incrementColumn($table, $where,$column,$numberTocount=1)
    {
        $sql = "UPDATE $table SET $column = $column + $numberTocount WHERE " . $where;
        $this->query($sql);
        if ($this->affected_rows()) {
            return true;
        }
        return false;
    }
    public function decrementColumn($table, $where,$column,$numberTocount=1)
    {
        $sql = "UPDATE $table SET $column = $column - $numberTocount WHERE " . $where;
        $this->query($sql);
        if ($this->affected_rows()) {
            return true;
        }
        return false;
    }
    public function getDbInfo(){
        	$result = mysqli_query($this->connection, "SHOW TABLE STATUS");
            $data= (object) mysqli_fetch_all($result, MYSQLI_ASSOC);
            $size=0;
            foreach ($data as $key => $row) {
                $size+=$row['Data_length']+$row['Index_length'];
            }
            $mbs=$size/(1024*1024);
            if($mbs>=1024){
                return number_format($mbs/(1024*1024*1024)).' GB';
            }
            return number_format($mbs,2).' MB';
    }
    // function used to generate auto numbering
    public  function getNextCode($lastCode=0,$size=5)
    {
        if(!is_numeric($size))$size=5;
        if ($lastCode!=0 && is_numeric($lastCode)) {
            return  str_pad($lastCode + 1, $size, "0", STR_PAD_LEFT);
        }
        return  str_pad(1, $size, "0", STR_PAD_LEFT);
    }
}

$database = new mysqldatabase(DB_NAME);

// $calendarDB->create()
?>
