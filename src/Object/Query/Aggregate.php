<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Aggregate extends qinq\Object\Statement {
        /**
         * Aggregates all array values
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $narr = [];
            $hasValue = false;
            $aggregateValue = null;
            
            $fn = $this->getCallback();
            
            foreach($arr as $k => $value) {
                if(!$hasValue) {
                    $aggrValue = $value;
                    $hasValue = true;
                    continue;
                }
                
                $aggrValue = call_user_func_array($fn,[$aggrValue,$value]);
                $narr[$k] = $aggrValue;
            }
            
            return $narr;
        }
    }
}