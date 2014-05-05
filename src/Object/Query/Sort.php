<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Sort extends qinq\Object\Statement {
        /**
         * Sorts array values using callable filter
         * @return array
         */
        function execute() {
            $collection = $this->getCollection();
            $arr = $collection->toArray();
            $fn = $this->getCallback();
            $args = $this->getArguments();
            
            if(empty($fn) && !empty($args)) {
                $fn = $this->getDefaultSorter($args[0]);
            }
            
            if(is_callable($fn)) {
                usort($arr,$fn);
            }
            
            return $arr;
        }
        
        /**
         * Helper method to provide default filtering callables
         * @param integer $order
         * @return callable
         */
        private function getDefaultSorter($order) {
            if($order === qinq\Order::Descending) {
                return function($a,$b) {
                    return ($a > $b) ? -1 : 1;
                };
            } elseif($order === qinq\Order::Ascending) {
                return function($a,$b) {
                    return ($a < $b) ? -1 : 1;
                };
            }
        }
    }
}