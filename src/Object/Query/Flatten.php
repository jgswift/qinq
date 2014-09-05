<?php
namespace qinq\Object\Query {
    use qtil;
    use qinq;
    
    class Flatten extends qinq\Object\Statement {
        
        const COLLECTION = 1;
        const ITERATOR = 2;
        const TRAVERSABLE = 4;
        const ARRAYONLY = 8;
        
        /**
         * Flatten multi-dimensional array to single-dimensional array
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $flags = self::COLLECTION | self::ITERATOR | self::TRAVERSABLE;
            $args = $this->getArguments();
            if(isset($args[0])) {
                $flags = (int)$args[0];
            }
            
            $return = [];
            $fn = function($a) use (&$return, $flags) { 
                $return[] = $this->flatten($a,$flags);
            };
            
            array_walk_recursive($arr, $fn);
            
            while(\qtil\ArrayUtil::isMultidimensional($return)) {
                $compare = $return;
                $return = [];
                array_walk_recursive($compare, $fn);
            }
            
            return $return;
        }
        
        public function flatten($a,$flags) {
            if($flags & self::ARRAYONLY) {
                if($flags & self::COLLECTION && 
                   $a instanceof qtil\Interfaces\Traversable) {
                    $a = $a->toArray();
                } elseif($flags & self::ITERATOR && 
                         $a instanceof \Iterator) {
                    $a = iterator_to_array($a);
                } elseif($flags & self::TRAVERSABLE && 
                         $a instanceof \Traversable) {
                    $a = (array)$a;
                }
            }

            return $a;
        }
    }
}