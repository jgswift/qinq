qinq
====
PHP 5.5+ quasi integrated query 

[![Build Status](https://travis-ci.org/jgswift/qinq.png?branch=master)](https://travis-ci.org/jgswift/qinq)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jgswift/qinq/badges/quality-score.png?s=4c1433cd4686440e0a8a2eb2a0d3aac9d2a62337)](https://scrutinizer-ci.com/g/jgswift/qinq/)

## Installation

Install via [composer](https://getcomposer.org/):
```sh
php composer.phar require jgswift/qinq:dev-master
```

## Description

qinq is a lightweight array handling component that provides support for
complex array manipulation with queries and built-in query caching

This package does not parse PHP or do any AST handling.  qinq only manipulates
arrays using php's built-in array functionality.

## Usage

The following is a basic example
```php
$richPeople = $people
    ->where(function($person) { return $person['money'] > 1000000; }
    ->order(function($personA,$personB) { return ($personA['money'] < $personB['money']) ? -1 : 1; } )
    ->index(function($person) { return $person['lastName']; })
    ->select(function($person) {
        return [
            'fullName' => $person['firstName'].' '.$person['lastName'],
            'money' => $person['money'],
            'networth' => $person['money'] - $person['debt']
        ];
    });
```

Populating a qinq collection

```php
$integers = new qinq\Collection(range(1,50));
$names = new qinq\Collection(['bob','joe','sam','john','jake']);
```

**Filter**

```php
foreach($integers->where(function($n) { return $n % 5 === 0; }) as $integer) {
    // 5, 10, 15, 20 ...
}

foreach($names->where(function($n) { return strlen($n) === 3; }) as $name) {
    // bob, joe, sam
}
```

**Order**

```php
foreach($integers->order(qinq\Order::Descending) as $integer) {
    // 50, 49, 48, 47 ...
}

foreach($names->order(function($n) { return strlen($n); } ) as $name ) {
    // john, jake, bob ...
}
```

**Sort**

```php
foreach($names->sort(function($a,$b) { return (strlen($a) > strlen($b)) ? -1 : 1; } ) as $name ) {
    // john, jake, bob ...
}
```

**Group**

```php
foreach($integers->group(function($n) { return $n % 2; }) as $group) {
    // [ 2, 4, 6, 8 ... ], [ 1, 3, 5, 7 ... ]
}

foreach($names->group(function($n) { return strlen($n); }) as $group) {
    // [ bob, joe, sam ], [ john, jake ]
}
```

**Join**

```php
foreach($integers
    ->join($integers)
    ->on(function($outer,$inner) {
        return ($outer >= $inner) ? true : false;
    })
    ->to(function($outer,qinq\Collection $innerGroup) {
        return $outer.':'.implode(',',$innerGroup->toArray());
    }) as $integer ) {
        // 1:1 , 2:1,2 , 3:1,2,3 ...
    }

foreach($integers
    ->join($names)
    ->on(function($outer) {
        return $outer;
    }, 'strlen')
    ->to(function($outer,$inner) {
        return $outer.':'.$inner;
    }) as $number ) {
        // 3:bob, 3:joe, 3:sam, 4:john, 4:jake
    }
```

**Additional Operations**

* Difference
* Except
* First
* Flatten
* From
* Intersect
* Keys
* Last
* Pack
* Reduce
* Shuffle
* Values

**Storing**

```php
$query = new \qinq\Object\Query($integers);

$query->select(function($n) {
    return $n * 3;
})->where(function($n) {
    return $n % 2 === 0;
});

$query_to_cache = serialize($query);

$query_from_cache = unserialize($query_to_cache);

var_dump( $query_from_cache->execute() === $query->execute() ) // true
```

Note: Query storing relies on eval to unserialize Closures.  Do not rely on users to provide serialized queries to your application as this can make your application vulnerable to code injection.