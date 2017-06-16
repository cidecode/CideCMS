<?php

/*
* This is class for database settings. 
*/

class Database
{
	private $db_host;
	private $db_username;
	private $db_passwd;
	private $db_name;
	private $db_link;

	// Create constructor
    public function __construct($db_host,$db_username,$db_passwd,$db_name) 
    {
        $this->db_host = $db_host;
        $this->db_username = $db_username;
        $this->db_passwd = $db_passwd;
        $this->db_name = $db_name;
    }

    public function CreateConnectionLink()
    {
       // Create connection to MySQL database
        try
        {

            $this->db_link = new mysqli($this->db_host, $this->db_username, $this->db_passwd, $this->db_name);
            
            if($this->db_link->connect_errno)
            {
               die('Could not connect to database server, please contact your administrator!'.$this->db_link->connect_errno); 
            }
            else
            {
               return $this->db_link; 
            }  
        }
        catch(Exception $e)
        {
            die('Could not connect to database server, please contact your administrator!');
        }    
    }

    // Create destructor
    public function __destruct() 
    {
        if($this->db_link != null)
        {
            $this->db_link->close();
        }
    }

    public function getDb_link() 
    {
        return $this->db_link;
    }

    public function CheckInstallDB()
    {
        if($data = $this->db_link->query('SHOW TABLES'))
        { 
            if($data->num_rows == 0) return false;
            else return true;
        }
        else
        {
            die("This is crazy but something went wrong with the database, please contact your administrator!");
        }
    }
}

# Try to create MySQL connection object
try
{
	$database = new Database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    $c = $database->CreateConnectionLink(); 
}
catch(Exception $e)
{
	die($e->getMessage());
}

?>