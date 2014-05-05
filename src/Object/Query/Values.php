<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Values extends qinq\Object\Statement {
        /**
         * Retrieve all values of collection
         * @return array
         */
        public function execute() {
            $arr = $this->getCollection()->toArray();
            
            return array_values($arr);
        }
    }
}