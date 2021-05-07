<?php

namespace moussazoungrana\Database;

use moussazoungrana\Database\Config\Config;
use PDO;
use PDOStatement;

class DB
{

    /**
     * @var DB
     */
    private static $instance ;
    /**
     * @var PDO
     */
    private $pdo ;


    /**
     * DB constructor.
     */
    private function __construct()
    {
        $dns = Config::$driver . ':host=' . Config::$servername . ';dbname=' . Config::$dbname . ';charset=' . Config::$charset;
        $this->pdo = new PDO($dns, Config::$username, Config::$password, Config::$options);
    }


    /**
     * @return DB
     */
    public static function getInstance(): DB
    {
        if (is_null(self::$instance)) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    /**
     * Get Connection to the database
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
    }


    /**
     * Perform a database query
     * @param string $statement
     * @param array|null $option
     * @return false|PDOStatement
     */
    public function query(string $statement, ? array $option=null )
    {
        $query = $this->getPDO()->prepare($statement);
        $query->execute($option);

        return $query;
    }

    /**
     * Perform a database query and fetch result
     * @param string $statement
     * @param array|null $option
     * @param null $fetch_style
     * @return mixed
     */
    public function queryFetch(string $statement, ?array $option = null, $fetch_style = null)
    {
        $query = $this->query($statement, $option, $fetch_style);
        return $query->fetch($fetch_style);
    }

    /**
     * Perform a database query and fetch result
     * @param string $statement
     * @param array|null $option
     * @param null $fetch_style
     * @return array
     */
    public function queryFetchAll(string $statement , ? array $option=null , $fetch_style=null): array
    {
        $query = $this->query($statement, $option, $fetch_style);
        return $query->fetchAll($fetch_style);
    }


}
