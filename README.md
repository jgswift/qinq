qinq
====
PHP 5.5+ quasi integrated query 

[![Build Status](https://travis-ci.org/jgswift/qinq.png?branch=master)](https://travis-ci.org/jgswift/qinq)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jgswift/qinq/badges/quality-score.png?s=4c1433cd4686440e0a8a2eb2a0d3aac9d2a62337)](https://scrutinizer-ci.com/g/jgswift/qinq/)

## Installation

Install via cli using [composer](https://getcomposer.org/):
```sh
php composer.phar require jgswift/qinq:0.1.*
```

Install via composer.json using [composer](https://getcomposer.org/):
```json
{
    "require": {
        "jgswift/qinq": "0.1.*"
    }
}
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
    ->where(function($person) { return $person['money'] > 1000000; })
    ->order(function($personA,$personB) { return ($personA['money'] < $personB['money']) ? -1 : 1; })
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
// Retrieve all integers divisible by 5
foreach($integers->where(function($n) { return $n % 5 === 0; }) as $integer) {
    // 5, 10, 15, 20 ...
}

// Retrieve all names with a character length of 3
foreach($names->where(function($n) { return strlen($n) === 3; }) as $name) {
    // bob, joe, sam
}
```

**Order**
```php
// Retrieves all integers in descending order
foreach($integers->order(qinq\Order::Descending) as $integer) {
    // 50, 49, 48, 47 ...
}

// Retrieves all names in order of character length
foreach($names->order(function($n) { return strlen($n); } ) as $name ) {
    // john, jake, bob ...
}
```

**Sort**
```php
// Retrieve all names in order of character length (with compare function)
foreach($names->sort(function($a,$b) { return (strlen($a) > strlen($b)) ? -1 : 1; } ) as $name ) {
    // john, jake, bob ...
}
```

**Group**
```php
// Group values by divisibility of 2
foreach($integers->group(function($n) { return $n % 2; }) as $group) {
    // [ 2, 4, 6, 8 ... ], [ 1, 3, 5, 7 ... ]
}

// Group names by to character length
foreach($names->group(function($n) { return strlen($n); }) as $group) {
    // [ bob, joe, sam ], [ john, jake ]
}
```

**Join**
```php
// Join integer collections using comparison method (on) and output method (to)
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

// Join integer and name collection, grouping names with integer that matches the character length
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

**Difference**

Computes the difference between collection and argument
```php
foreach($integers
    ->difference(range(25,50))
    as $number) {
        // 1, 2, 3, ..., 24
    }
```

**Except** 

Alias of *Difference*
```php
foreach($integers
    ->except(range(25,50))
    as $number) {
        // 1, 2, 3, ..., 24
    }
```

**First**

Retrieves first item in collection.
```php
foreach($integers
    ->first()
    as $number) {
        // 1
    }
```

**Last**

Retrieves last item in collection
```php
foreach($integers
    ->last()
    as $number) {
        // 50
    }
```

**Flatten**

Retrieves every value from a multidimensional collection tree and transforms it into a single dimensional collection
```php
$tree = new qinq\Collection([
    [1,2,[8,9],3,4],
    [4,5,6,[1,2,3]],
    [8,[9,10],[4,5]]
]);

foreach($tree
    ->flatten()
    as $number) {
        // 1, 2, 8, 9, 3, 4, 4, 5..
    }
```

**From**

Replaces entire collection with given arguments.  A single array/Iterator/Collection may also be given.
```php
foreach($integers
    ->from([3,4])
    as $number) {
        // 3, 4
    }
```

```php
foreach($integers
    ->from(3,4,5)
    as $number) {
        // 3, 4, 5
    }
```

**Intersect**

Retrieves values that exist in both arrays
```php
foreach($integers
    ->intersect(range(25,100))
    as $number) {
        // 25, 26, 27, ..., 50
    }
```

**Keys**

Retrieves all collection keys
```php
foreach($integers
    ->keys()
    as $number) {
        // 1, 2, 3, ..., 50
    }
```

**Pack**

Removes all data from collection that is weakly equivalent to false or 0
```php
$junk = new qinq\Collection([
    false, 0, false, '0', 'hello'
]);

foreach($junk
    ->pack()
    as $item) {
        // 'hello'
    }
```

**Reduce**

Reduces array to single value using callback function
```php
$q = new qinq\Collection([1,2,3,4,5]);

foreach($q
    ->reduce(function($carry,$item) {
        return $carry * $item; // 1 * 2 * 3 * 4 * 5
    })
    as $result) {
        // 120
    }
```

**Shuffle**

Mix all items in collection to new random positions
```php
foreach($integers
    ->shuffle()
    as $result) {
        // random number between 1 and 50
    }
```

**Values**

Retrieves all values from collection
```php
foreach($integers
    ->values()
    as $result) {
        // 1, 2, 3, ..., 50
    }
```

**Random**

Selects a number of random items from collection
```php
foreach($integers
    ->random(5)
    as $result) {
        // 5 random items from array
    }
```

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

*Note*: Query storing relies on *eval* to unserialize Closures.  
Do not rely on users to provide serialized queries to your application as this 
can make your application vulnerable to code injection.  
You can verify a queries authenticity by performing a cryptographic checksum on 
the serialized contents every time a client sends the query.  
However said functionality is not implemented in this package.