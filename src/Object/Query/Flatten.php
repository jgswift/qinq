<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Flatten extends qinq\Object\Statement {
        /**
         * Flatten multi-dimensional array to single-dimensional array
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $return = [];
            array_walk_recursive($arr, function($a) use (&$return) { $return[] = $a; });
            return $return;
        }
    }
}