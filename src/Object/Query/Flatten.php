<?php
namespace qinq\Object\Query {
    use qtil;
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
            $fn = function($a) use (&$return) { 
                if($a instanceof qtil\Interfaces\Traversable) {
                    $a = $a->toArray();
                } elseif($a instanceof \Iterator) {
                    $a = iterator_to_array($a);
                } elseif($a instanceof \Traversable) {
                    $a = (array)$a;
                }
                
                $return[] = $a; 
            };
            
            while(\qtil\ArrayUtil::isMultidimensional($arr)) {
                array_walk_recursive($arr, $fn);
            }
            
            return $return;
        }
    }
}