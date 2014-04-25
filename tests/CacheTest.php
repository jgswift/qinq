<?php
namespace qinq\Tests {
    use qinq;
    
    class CacheTest extends qinqTestCase {
        function testSerializeQuery() {
            $collection = new \qinq\Collection(range(1,50));
            
            $query = new \qinq\Object\Query($collection);
            
            $query->select(function($n) {
                return $n * 3;
            })->where(function($n) {
                return $n % 2 === 0;
            });
                        
            $query_cache = serialize($query);
            
            $query2 = unserialize($query_cache);
            
            $result = $query->execute();
            
            $this->assertEquals($result,$query2->execute());
        }
    }
}