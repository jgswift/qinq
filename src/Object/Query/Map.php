<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Map extends qinq\Object\Statement {
        /**
         * maps array content given callable
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $fn = $this->getCallback();
            
            if(empty($fn)) {
                return $arr;
            }
            
            return array_map($fn,$arr);
        }
    }
}
