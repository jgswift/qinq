<?php
namespace qinq\Tests {
    use qinq;
    
    class ObjectTest extends qinqTestCase {
        function testIntegratedQueryFrom() {
            $numbers = new qinq\Collection(range(1,10));
            
            $query = $numbers->getQuery();
            
            $matches = range(1,4);
            
            foreach($query->from(range(1,4))->execute() as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryKeys() {
            $numbers = new qinq\Collection([
                1 => 'animal',
                2 => 'item',
                3 => 'bob',
                4 => 'cat'
            ]);
            
            $matches = range(1,4);
            foreach($numbers->keys() as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryValues() {
            $numbers = new qinq\Collection([
                'animal' => 1,
                'item' => 2,
                'bob' => 3,
                'cat' => 4
            ]);
            
            $matches = range(1,4);
            foreach($numbers->values() as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryShuffle() {
            $numbers = new qinq\Collection(range(1,4));
            
            $this->assertEquals(4,count($numbers->shuffle()));
        }
        
        function testIntegratedQueryReduce() {
            $numbers = new qinq\Collection(range(1,4));
            
            $numbers->reduce(function($carry,$item) {
                return $carry += $item;
            });
            
            $this->assertEquals(10,$numbers[0]);
        }
        
        function testIntegratedQueryFirst() {
            $numbers = new qinq\Collection(range(1,4));
            
            $query = $numbers->getQuery();
            
            foreach($query->first()->execute() as $number) {
                $this->assertEquals(1,$number);
            }
        }
        
        function testIntegratedQueryLast() {
            $numbers = new qinq\Collection(range(1,4));
            
            $query = $numbers->getQuery();
            
            foreach($query->last()->execute() as $number) {
                $this->assertEquals(4,$number);
            }
        }
        
        function testIntegratedQueryFlatten() {
            $numbers = new qinq\Collection([
                1,
                [2,3,[4]],
            ]);
            
            $matches = range(1,4);
            foreach($numbers->flatten() as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryIntersect() {
            $numbers = new qinq\Collection(range(1,4));
            $compare = new qinq\Collection(range(2,3));
            
            $matches = [2,3];
            foreach($numbers->intersect($compare) as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryExcept() {
            $numbers = new qinq\Collection(range(1,4));
            
            $matches = [1,4];
            foreach($numbers->except([2,3]) as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryDifference() {
            $numbers = new qinq\Collection(range(1,4));
            
            $matches = [1,4];
            foreach($numbers->difference([2,3]) as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryWhere() {
            $numbers = new qinq\Collection(range(1,4));
            
            foreach($numbers->where(function($n) {
                return $n % 2 === 0;
            }) as $number) {
                $this->assertEquals(0,$number % 2);
            }
        }
        
        function testIntegratedQueryWhereKeys() {
            $numbers = new qinq\Collection([
                'bob' => 1,
                'jim' => 2,
                'sam' => 3,
                'joe' => 4,
                'jack' => 5
            ]);
            
            $numbers->where(function($n,$k) {
                return strlen($k) == 3;
            });
            
            $this->assertEquals(4,count($numbers));
        }
        
        function testIntegratedQuerySelect() {
            $numbers = new qinq\Collection(range(1,2));
            
            foreach($numbers->select(function($n) {
                return $n * 10;
            }) as $number) {
                $this->assertEquals(0,$number % 10);
            }
        }
        
        function testIntegratedQueryAggregate() {
            $numbers = new qinq\Collection(range(1,5));
            
            foreach($numbers->aggregate(function($n,$k) {
                return $n * $k;
            }) as $number) {
                $this->assertEquals(0,$number % 2);
            }
        }
        
        function testIntegratedQueryGroup() {
            $numbers = new qinq\Collection(range(1,4));
            
            foreach($numbers->group(function($n) {
                return $n % 2;
            }) as $group) {
                $this->assertEquals(2,count($group));
            }
        }
        
        function testIntegratedQueryGroupString() {
            $strings = new qinq\Collection([
                'bob',
                'bed',
                'fun',
                'fuzz',
                'jack',
                'jeep'
            ]);
            
            foreach($strings->group(function($s) {
                return $s[0];
            }) as $group) {
                $this->assertEquals(2,count($group));
            }
        }
        
        function testIntegratedQuerySort() {
            $numbers = new qinq\Collection(range(1,3));
            
            $matches = range(3,1);
            foreach($numbers->sort(qinq\Order::Descending) as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
            
            $matches = range(3,1);
            foreach($numbers->sort(function($a,$b) {
                    return ($a > $b) ? -1 : 1;
                }) as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryOrder() {
            $numbers = new qinq\Collection(range(1,3));
            
            $matches = range(3,1);
            foreach($numbers->order(qinq\Order::Descending) as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
            
            $numbers = new qinq\Collection(range(1,3));
            
            $matches = range(1,3);
            foreach($numbers->order(qinq\Order::Ascending) as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedFrom() {
            $numbers = new qinq\Collection();
            
            $matches = [10,20,30];
            foreach($numbers->from(range(1,3))->select(function($n) {
                return $n * 10;
            }) as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryUnion() {
            $numbers = new qinq\Collection([
                1,2,5,7,7
            ]);
            
            $union = new qinq\Collection([
                2,2,3,5
            ]);
            
            $matches = [1,2,3,5,7];
            foreach($numbers->union($union) as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryUnique() {
            $numbers = new qinq\Collection([
                1,1,2,2,2,4,4,4,5,5,5
            ]);
            
            $matches = [1,2,4,5];
            foreach($numbers->unique() as $number) {
                $match = array_shift($matches);
                $this->assertEquals($match,$number);
            }
        }
        
        function testIntegratedQueryJoin() {
            $numbers = new qinq\Collection(range(1,3));
            
            $joined = new qinq\Collection(range(1,3));
            
            foreach($numbers
                    ->join($joined)
                    ->on(function($outer,$inner) {
                        return ($outer >= $inner) ? true : false;
                    })
                    ->to(function($outer,qinq\Collection $innerGroup) {
                        return $outer.':'.implode(',',$innerGroup->toArray());
                    }) as $number ) {
                        $outer = explode(':',$number);
                        
                        $i=0;
                        $k = null;
                        foreach($outer as $o) {
                            if($i%2) {
                                $inner = explode(',',$o);
                                
                                $this->assertEquals($k,count($inner));
                            } else {
                                $k = $o;
                            }
                            
                            $i++;
                        }
                    }
        }
        
        function testIntegratedQueryJoinBoth() {
            $numbers = new qinq\Collection(range(1,100));
            
            $joined = new qinq\Collection(range(10,20));
            
            foreach($numbers
                    ->join($joined)
                    ->on(function($outer) {
                        return $outer*2;
                    }, function($inner) {
                        return $inner;
                    })
                    ->to(function($outer,$inner) {
                        return $outer.':'.$inner;
                    }) as $number ) {
                        $parts = explode(':',$number);
                        $this->assertEquals($parts[0],$parts[1]/2);
                    }
        }
        
        function testIntegratedQueryJoinStringBoth() {
            $numbers = new qinq\Collection(range(1,7));
            $strings = new qinq\Collection([
                'foo',
                'bar',
                'bink',
                'bean',
                'jacob',
                'johnson'
            ]);
            
            foreach($numbers
                    ->join($strings)
                    ->on(function($outer) {
                        return $outer;
                    }, 'strlen')
                    ->to(function($outer,$inner) {
                        return $outer.':'.$inner;
                    }) as $number ) {
                        $parts = explode(':',$number);
                        $this->assertEquals($parts[0],strlen($parts[1]));
                    }
        }
        
        function testIntegratedQuerySelectCallback() {
            $strings = new qinq\Collection([
                'foo',
                'bar',
                'bink',
                'bean',
                'jacob',
                'johnson'
            ]);
            
            $matches = [3,3,4,4,5,7];
                
                
            foreach($strings->select('strlen') as $length ) {
                $match = array_shift($matches);
                
                $this->assertEquals($match,$length);
            }
        }
        
        function testIntegratedQueryAny() {
            $strings = new qinq\Collection([
                'foo',
                'bar',
                'bink',
                'bean',
                'jacob',
                'johnson'
            ]);
            
            $this->assertEquals(true, $strings->any('jacob'));
            $this->assertEquals(false, $strings->any('donald'));
        }
        
        function testIntegratedQueryAll() {
            $strings = new qinq\Collection([1,1,1,1,1,1]);
            
            $this->assertEquals(true, $strings->all(1));
            $this->assertEquals(false, $strings->all(2));
        }
        
        function testIntegratedQueryAverage() {
            $strings = new qinq\Collection([1,2,3,4,5]);
            
            $this->assertEquals(true, $strings->average(3));
        }
        
        function testIntegratedQueryMin() {
            $strings = new qinq\Collection([1,2,3,4,5]);
            
            $this->assertEquals(true, $strings->min(1));
        }
        
        function testIntegratedQueryMax() {
            $strings = new qinq\Collection([1,2,3,4,5]);
            
            $this->assertEquals(true, $strings->max(5));
        }
        
        function testIntegratedQuerySum() {
            $strings = new qinq\Collection([1,2,3,4,5]);
            
            $this->assertEquals(15, $strings->sum());
        }
    }
}