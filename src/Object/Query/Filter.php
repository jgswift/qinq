<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Filter extends qinq\Object\Statement {
        /**
         * Filters array values
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            return array_filter($arr,$this->getCallback());
        }
    }
}