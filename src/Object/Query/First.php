<?php
namespace qinq\Object\Query {
    use qinq;
    
    class First extends qinq\Object\Statement {
        /**
         * Update collection to only contain first item
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            return [$arr[array_keys($arr)[0]]];
        }
    }
}