<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Intersect extends Arrays {
        /**
         * Compute intersection between collection and given arguments
         * @return array
         */
        public function execute() {
            $this->utilFunctionName = 'intersect';
            return parent::execute();
        }
    }
}