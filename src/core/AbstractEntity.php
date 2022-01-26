<?php
    namespace App\Core;

    abstract class AbstractEntity
    {
        /**
          * hydrates an object with the desired data
          *
          * @param array $data - the data coming out of the database
          * @param Object $object - the object to hydrate
         */
        protected static function hydrate($data, $object){
            
            foreach($data as $field => $value){
                $explodedField = explode("_", $field);
                if(count($explodedField) > 1 && $explodedField[1] == "id"){
                    $field = $explodedField[0];
                    $managerClass = 'App\\Model\\Manager\\'.ucfirst($field).'Manager';
                    $manager = new $managerClass;
                    $value = $manager->getOneById($value);
                }
                
                $setter = "set".ucfirst($field);
                if(method_exists($object, $setter)){
                    $object->$setter($value);
                }
            }
        }
    }