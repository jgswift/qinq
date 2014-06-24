<?php
namespace qinq {
    use qtil;
    
    class Collection extends qtil\Collection implements Interfaces\Collection {
        
        /**
         * Stores collection data
         * @var array
         */
        public $data;
        
        /**
         * Builds default query
         * @return \qinq\Object\Query
         */
        public function getQuery() {
            return new Object\Query($this);
        }
        
        /**
         * Helper method to perform query operations
         * @param string $name
         * @param array $arguments
         * @return mixed
         */
        public function __call($name, array $arguments) {
            $query = $this->getQuery();
            
            call_user_func_array([$query,$name],$arguments);
            
            return $query->execute();
        }
    }
}