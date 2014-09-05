<?php
namespace qinq\Object\Query {
    use qinq;
    use qtil;
    
    class Join extends qinq\Object\Statement {
        
        private $group;
        private $innerGroup;
        private $innerEquality;
        
        /**
         * starts join
         * @return \qinq\Object\Query\Join
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $fn = $this->getCallback();
            
            $arr = $collection->toArray();
            
            $args = $this->getArguments();
            
            if(empty($fn) && count($args) === 1) {
                $this->group = [new qinq\Collection($arr),new qinq\Collection($args[0])];
            } elseif(!empty($fn)) {
                $arr1 = array_filter($arr,$fn);
            
                $arr2 = array_diff($arr,$arr1);

                $this->group = [new qinq\Collection($arr),new qinq\Collection($arr2)];
            }
            
            if(qtil\ArrayUtil::isIterable($this->group) && 
               qtil\ArrayUtil::isMultiObject($this->group)) {
                return $this;
            }
        }
                
        /**
         * map on join
         * @param callable $callable
         * @return \qinq\Object\Query\Join
         */
        public function on(callable $callable, callable $equality = null) {
            list($inner,$outer) = $this->group;
            
            if(is_null($equality)) {
                $this->mapOn($inner,$outer,$callable);
            } else {
                $this->mapOnBoth($inner, $outer, $callable, $equality);
            }
            
            return $this;
        }
        
        /**
         * Helper method to perform actual mapping
         * @param array|\Traversable $inner
         * @param array|\Traversable $outer
         * @param callable $outerCallable
         * @param callable $innerCallable
         */
        private function mapOnBoth($inner, $outer, callable $outerCallable, callable $innerCallable) {
            $this->innerEquality = [];
            
            foreach($inner as $k => $i) {
                $innerValue = $outerCallable($i);
                
                $group = new qinq\Collection();
                foreach($outer as $o) {
                    $outerValue = $innerCallable($o);
                    if($innerValue == $outerValue) {
                        $group->add($o);
                    } 
                }
                
                $this->innerEquality[$k] = $group;
            }
        }
        
        /**
         * Helper method to perform actual mapping
         * @param array|\Traversable $inner
         * @param array|\Traversable $outer
         * @param callable $callable
         */
        private function mapOn($inner, $outer, callable $callable) {
            $this->innerGroup = [];
            
            foreach($outer as $k => $o) {
                $group = new qinq\Collection();
                foreach($inner as $i) {
                    $check = $callable($o,$i);
                    if($check === true) {
                        $group->add($i);
                    }
                }
                
                $this->innerGroup[$k] = $group;
            }
        }
        
        /**
         * Finish join
         * @param \qinq\Object\Query\callable $callable
         * @return \qinq\Collection
         */
        public function to(callable $callable) {
            list($inner,$outer) = $this->group;
            
            $result = [];
            if(!empty($this->innerGroup)) { // MAP ON
                foreach($this->innerGroup as $o => $innerGroup) {
                    if(isset($outer[$o])) {
                        $result[] = $callable($outer[$o],$innerGroup);
                    }
                }
            } 
            elseif(!empty($this->innerEquality)) { // MAP ON BOTH
                foreach($this->innerEquality as $k => $outerGroup) {
                    if(isset($inner[$k])) {
                        foreach($outerGroup as $o) {
                            $result[] = $callable($inner[$k],$o);
                        }
                    }
                }
            }
            
            $query = $this->getQuery();
            
            $collection = $this->getCollection();
            
            if($query instanceof qinq\Query\Immutable) {
                $collection = new qinq\Collection($result);
            } elseif($query instanceof qinq\Query\Mutable) {
                $collection->from($result);
            }
            
            return $collection;
        }
    }
}