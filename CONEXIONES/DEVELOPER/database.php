<?php
require_once("configdb.php");

class Database {
    private static $db = null;
    private static $pdo;
    public  $countRow   = 0;
    public  $countColumn = 0;
    private $msg = "";

    final public function __construct(){
        try {
            self::getDb();
        } catch (PDOException $e) {
        }
    }

    public static function getInstance(){
        if (self::$db === null) {
            self::$db = new self();
        }
        return self::$db;
    }

    public function getDb(){
        if (self::$pdo == null) {
            try {

                self::$pdo = new PDO(
                    'mysql:dbname=' . DATABASE .
                    ';host=' . HOSTNAME .
                    ';port:' . HOSTPORT . ';',
                    USERNAME,
                    PASSWORD,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch (Exception $e) {
                echo json_encode(array('error'=>'No se puede conectar con el servidor'));
                exit;
            }
        }
        return self::$pdo;
    }

    function _destructor(){
        self::$pdo = null;
    }

    // ADD
    public function query($query){
        $result=array();
        try {
            $statement = self::$pdo->query($query);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $this->countRow = $statement->rowCount();
            $this->countColumn = $statement->columnCount();

        } catch (PDOException $e) {
            $er = $e->getTrace();
            $bug = $er[1]['args'][0];
            $result = array('error'=>'ERROR: <br>SP:: '.$bug);
        }

        return $result;
    }

    public function setMsgErr($_msg) {
        $this->msg = $_msg;
    }

    public function getMsgErr() {
        return $this->msg;
    }
}
?>