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
            
            $args = $this->getArguments();
            
            $split = false;
            if(!empty($args) && is_bool($args[1])) {
                $split = $args[1];
            }
            
            if($split === true) {
                return array_map($fn, array_values($arr), array_keys($arr));
            }
            
            return array_map($fn,$arr);
        }
    }
}
