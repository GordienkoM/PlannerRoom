<?php
    namespace App\Core;

use Exception;
use PDOException;

abstract class AbstractManager
    {
        protected static $db;

        protected function connect(){
            //connect to MySQL
            if (!self::$db){
                try {
                    self::$db = new \PDO(
                        DB_HOST,
                        DB_USER,
                        DB_PASS,
                        [
                            // PHP will throw a PDOexception if an error occurs
                            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                            // Array indexed by column names
                            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                        ]
                    );
                } catch (PDOException $e){
                    if ( APP_ENV === "prod"){
                    echo "Une erreur est survenue";
                    die();
                    };
                }
            }
        }

          /**
            * Allows you to query the database and get its result
            *
            * @param string $query - the SQL query to execute
            * @param array|null $params - query parameters if needed
            *
            * @return \PDOStatement|null the PDOStatement object related to the query execution
           */
        private static function makeQuery($query, $params = null){
            if($params){
                $statement = self::$db->prepare($query);
                // execute return PDOStatement or null
                $executeResult = $statement->execute($params);
            }
            else{
                // query return PDOStatement or null
                $statement = self::$db->query($query);
                $executeResult = $statement;               
            }

            if(!$executeResult) {
                throw new Exception('PDOStatement execute returns null');
            }
            return $statement;
        }

        /**
          * retrieves an array of objects of the desired entity (1st parameter) corresponding to the request passed to the function (and possibly the necessary parameters).
          *
          * @param string $classname the class name of the result entities
          * @param string $query the SQL query to execute
          * @param array|null $params the optional query parameters
          *
          * @return array the array of entities resulting from the query (empty if the query returned nothing)
         */
        protected function getResults($classname, $query, $params = null){
            $stmt = self::makeQuery($query, $params);
            $results = [];
            foreach($stmt->fetchAll() as $data){
                $results[] = new $classname($data);
            }
            return $results;
        }

        /**
          * Retrieves an object of the specified class or null
          *
          * @param string $classname - the class of the desired object
          * @param string $query - the SQL query to execute
          * @param array|null $params - query parameters if needed
          *
          * @return Object|null the expected class object or null
         */
        protected function getOneOrNullResult($classname, $query, $params = null){
            $stmt = self::makeQuery($query, $params);
            if($data = $stmt->fetch()){
                return new $classname($data);
            }
            return null;
        }

        /**
          * executes an INSERT, UPDATE or DELETE SQL query
          *
          * @param string $query - the SQL query to execute
          * @param array|null $params - query parameters if needed
          *
          * @return bool TRUE if the request was successful, FALSE otherwise
         */
        protected function executeQuery($query, $params = null){
            return self::makeQuery($query, $params);
        }

        /**
          * Retrieves a single value resulting from the desired SQL query
          *
          * @param string $query - the SQL query to execute
          * @param array|null $params - query parameters if needed
          *
          * @return mixed the value resulting from the query
         */
        protected function getOneValue($query, $params = null){
            $stmt = self::makeQuery($query, $params);
            return $stmt->fetchColumn();
        }

        protected function getValues($query, $params = null){
            $stmt = self::makeQuery($query, $params);
            return $stmt->fetchAll();
        }

        protected function getLastInsertId(){
            return self::$db->lastInsertId();
        }
    }