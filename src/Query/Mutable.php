<?php
namespace qinq\Query {
    use qinq;
    use qtil;
    
    class Mutable extends qinq\Query {
        /**
         * Query execution
         * source collection will be updated with results
         * @return \qinq\Query\Statement
         */
        function execute() {
            $links = $this->getLinks();
            
            $result = null;
            foreach($links as $link) {
                if(is_callable($link)) {
                    $l = call_user_func_array($link,func_get_args());
                    if($l instanceof Statement) {
                        $result = $l;
                    } elseif(qtil\ArrayUtil::isIterable($l)) {
                        $this->collection->from($l);
                    } elseif(!is_null($l)) {
                        $result = $l;
                    }
                }
            }
            
            if(!is_null($result)) {
                return $result;
            }
            
            return $this->collection;
        }
    }
}
