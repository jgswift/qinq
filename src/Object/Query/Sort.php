<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Sort extends Order {
        /**
         * Helper method to provide default filtering callables
         * @param integer $order
         * @return \Closure
         */
        protected function getDefaultSorter($order) {
            switch($order) {
                case qinq\Order::DESCENDING:
                    return function($a,$b) {
                        return ($a > $b) ? -1 : 1;
                    };
                case qinq\Order::ASCENDING:
                default:
                    return function($a,$b) {
                        return ($a < $b) ? -1 : 1;
                    };
            }
        }
    }
}