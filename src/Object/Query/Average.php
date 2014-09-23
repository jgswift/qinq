<?php
namespace qinq\Object\Query {
    class Average extends Map {
        /**
         * Retrieves the sum value of all array values
         * @return integer
         */
        public function execute() {
            $arr = parent::execute();
            
            return array_sum($arr) / count($arr);
        }
    }
}
