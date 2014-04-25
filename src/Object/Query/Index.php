<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Map extends qinq\Object\Statement {
        /**
         * maps array keys using callable
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $fn = $this->getCallback();
            
            if(empty($fn)) {
                return $arr;
            }
            
            $narr = [];
            
            foreach($arr as $i) {
                $nkey = $fn($i);
                $narr[$nkey] = $i;
            }
            
            return $narr;
        }
    }
}