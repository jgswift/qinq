<?php
namespace qinq\Object\Query {
    use qinq;
    
    /**
     * Groups array items according to callback
     */
    class Group extends qinq\Object\Statement {
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $fn = $this->getCallback();
            
            $values = [];
            foreach($arr as $k => $i) {
                $values[$k] = $fn($i);
            }
            
            $group_values = array_unique($values);
            $groups = [];
            
            foreach($group_values as $group_value) {
                if(!isset($groups[$group_value])) {
                    $groups[$group_value] = new qinq\Collection();
                }
                
                foreach($values as $k => $v) {
                    if($v === $group_value) {
                        $groups[$group_value]->add($arr[$k]);
                    }
                }
            }
            
            return $groups;
        }
    }
}
