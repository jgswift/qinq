<?php
namespace qinq\Object\Query {
    use qinq;
    
    class At extends qinq\Object\Statement {
        /**
         * Retrieves value at given index
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $args = $this->getArguments();
            
            if(!empty($args)) {
                return [$arr[array_keys($arr)[$args[0]]]];
            }
        }
    }
}
