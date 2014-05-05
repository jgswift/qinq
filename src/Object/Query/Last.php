<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Last extends qinq\Object\Statement {
        /**
         * Update collection to only contain last item
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            return [$arr[array_keys($arr)[count($arr)-1]]];
        }
    }
}