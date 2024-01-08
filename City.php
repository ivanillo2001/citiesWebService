<?php
require_once "./Connection.php";
    class City
    {
        private $id;
        private $name;
        private  $population;
        private $country;

        /**
         * @param $id
         * @param $name
         * @param $population
         * @param $country
         */
        public function __construct( $name, $population, $country)
        {
            $this->name = $name;
            $this->population = $population;
            $this->country = $country;
        }

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param mixed $name
         */
        public function setName($name)
        {
            $this->name = $name;
        }

        /**
         * @return mixed
         */
        public function getPopulation()
        {
            return $this->population;
        }

        /**
         * @param mixed $population
         */
        public function setPopulation($population)
        {
            $this->population = $population;
        }

        /**
         * @return mixed
         */
        public function getCountry()
        {
            return $this->country;
        }

        /**
         * @param mixed $country
         */
        public function setCountry($country)
        {
            $this->country = $country;
        }

        public function __toString()
        {
            return "Id: ".$this->id." - Name: ".$this->name." - Population: ".$this->population." - Country:".$this->country;
        }

        public function create()
        {

            $conn = (new Connection())->getPdo();
            $consCreate =$conn ->prepare("Insert into cities (name,population,country)values (:name,:population,:country)");
            $consCreate->bindParam(":name",$this->name);
            $consCreate->bindParam(":population",$this->population);
            $consCreate->bindParam(":country", $this->country);
            $consCreate->execute();
            echo json_encode($consCreate->fetchAll());
        }

        public static function getCities()
        {
            $conn = (new Connection())->getPdo();
            $content = $conn->prepare("Select * from cities");
            $content->execute();
            echo json_encode($content->fetchAll());
        }

        //TODO Terminar funcion updateCity
        public static function updateCity($id,$newName, $population,$country)
        {
            try {
                $conn = (new Connection())->getPdo();
                $content = $conn->prepare("Update cities set name = :name, population = :newPopulation, country = :newCountry where id = :id");
                $content->bindParam(":name",$newName);
                $content->bindParam(":newPopulation",$population);
                $content->bindParam(":newCountry",$country);
                $content->bindParam(":id",$id);
                $content->execute();
                echo json_encode(['message'=>'City updated successfully']);
            }catch (Exception $e){
                echo ' ',$e->getMessage(),"\n";
            }
        }

        public static function deleteCity($name)
        {
            try {
                $conn = (new Connection())->getPdo();
                $consDel = $conn->prepare("Delete from cities where name = :name");
                $consDel->bindParam(":name",$name);
                $consDel->execute();
                echo json_encode(['message'=>'City deleted successfully']);
            }catch (Exception $e){
                echo ' ',$e->getMessage(),"\n";
            }
        }

    }

?>