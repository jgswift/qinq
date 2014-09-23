<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Index extends qinq\Object\Statement {
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
            
            foreach($arr as $k => $i) {
                $nkey = $fn($i,$k);
                $narr[$nkey] = $i;
            }
            
            return $narr;
        }
    }
}
