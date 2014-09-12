<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Sort extends Order {
        /**
         * Helper method to provide default filtering callables
         * @param integer $order
         * @return callable
         */
        protected function getDefaultSorter($order) {
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