<?php
namespace Hayvanlar;
use \PDO;

class Database
{
    private $POSTGRE_HOST = 'localhost';
    private $POSTGRE_USER = 'postgres';
    private $POSTGRE_PASS = '43211234';
    private $POSTGRE_DB = 'Hayvanlar';
    private $POSTGRE_PORT = '5432';
    private $CHARSET = 'UTF8';

    // PDO bağlantısı ve diğer değişkenler
    private $pdo = NULL;
    private $isConn;
    private $stmt = NULL;

    public function __construct()
    {
        // Bağlantı açma
        $this->isConn = TRUE;
        $SQL = 'pgsql:host=' . $this->POSTGRE_HOST . ';port=' . $this->POSTGRE_PORT . ';dbname=' . $this->POSTGRE_DB;

        try {
            // PDO bağlantısını başlat
            $this->pdo = new PDO($SQL, $this->POSTGRE_USER, $this->POSTGRE_PASS);

            // PostgreSQL'de "SET NAMES" ve "COLLATE" kullanılmaz, bu satırları kaldırıyoruz
            $this->pdo->exec("SET client_encoding TO '" . $this->CHARSET . "'");

            // PDO hata modunu ve diğer ayarları yapılandır
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (\PDOException $e) {
            die('Cannot connect to Database with PDO. ' . $e->getMessage());
        }
    }

    public function MyTransaction()
    {
        $this->pdo->beginTransaction();
    }

    public function MyCommit()
    {
        $this->pdo->commit();
    }

    public function MyRollBack()
    {
        $this->pdo->rollBack();
    }

    public function __destruct()
    {
        // Bağlantıyı kapatma
        $this->pdo = NULL;
        $this->isConn = FALSE;
    }

    public function myQuery($query, $params = null)
    {
        // Sorgu çalıştırma
        if (is_null($params)) {
            $this->stmt = $this->pdo->query($query);
        } else {
            $this->stmt = $this->pdo->prepare($query);
            $this->stmt->execute($params);
        }
        return $this->stmt;
    }

    public function getColumn($query, $params = null)
    {   // Tek bir değer almak için kullanılır
        try {
            return $this->myQuery($query, $params)->fetchColumn();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getRow($query, $params = null)
    {   // Tek bir satır almak için kullanılır
        try {
            return $this->myQuery($query, $params)->fetch();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function getRows($query, $params = null)
    {   // Tüm satırları almak için kullanılır
        try {
            return $this->myQuery($query, $params)->fetchAll();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Insert($query, $params = null)
    {   // Veri Eklemek için
        try {
            $this->myQuery($query, $params);
            return $this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Update($query, $params = null)
    {   // Veri Güncellemek için
        try {
            return $this->myQuery($query, $params)->rowCount();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    public function Delete($query, $params = null)
    {   // Veri Silmek için
        return $this->Update($query, $params);
    }

    public function TableOperations($query)
    {
        // Tablo operasyonları için
        $myTable = $this->pdo->query($query);
        return $myTable;
    }
}
?>