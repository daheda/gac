<?php
namespace Gac\Dao;

class Connexion
{
    protected static $_instance = null;
   
    static public function getInstance() 
    {
        
        if ( !isset( self::$_instance ) ) {
            self::$_instance = new Connexion();
        }
        return self::$_instance;
    }
 
    protected function __construct() {}
    
    public function getConnection() {
        $connection = null;
        try {
            $connection = new \PDO(\Config::DB_DSN, \Config::DB_USER, \Config::DB_PASS);
            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $connection;
            
        } catch (PDOException $e) {
			echo $e->getMessage();
            throw $e;
            
        }
        catch(Exception $e) {
			echo $e->getMessage();
            throw $e;
        }
    }

    public function __clone()
    {
        return false;
    }

    public function __wakeup()
    {
        return false;
    }
}
