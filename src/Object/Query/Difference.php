<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Difference extends Arrays {
        /**
         * Compute difference between collection and given array
         * @return array
         */
        public function execute() {
            $this->utilFunctionName = 'diff';
            return parent::execute();
        }
    }
}