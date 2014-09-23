<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Random extends qinq\Object\Statement {
        /**
         * Filters array values
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $args = $this->getArguments();
            
            $num = 1;
            if(isset($args[0]) && is_numeric($args[0])) {
                $num = (int)$args[0];
            }
            
            $result = [];
            for($i=1;$i<=$num;$i++) {
                $result[] = $arr[array_rand($arr)];
            }
            
            return $result;
        }
    }
}
