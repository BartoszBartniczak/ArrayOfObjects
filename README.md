BartoszBartniczak/ArrayOfObjects [![Build Status](https://travis-ci.org/BartoszBartniczak/ArrayOfObjects.svg?branch=master)](https://travis-ci.org/BartoszBartniczak/ArrayOfObjects) [![Coverage Status](https://coveralls.io/repos/github/BartoszBartniczak/ArrayOfObjects/badge.svg?branch=master)](https://coveralls.io/github/BartoszBartniczak/ArrayOfObjects?branch=master)
===========
ArrayOfObjects is the extension of the SPL ArrayObject concept. ArrayOfObjects may contain only objects of given type.
-----

### Table of contents:
1. [Class ArrayObject](#class-arrayobject)
1. [Class ArrayOfObjects](#class-arrayofobjects)
2. [Tests](#tests)

### Class ArrayObject

#### Methods:

##### filter()
Iterates over each value in the array passing them to the callback function.
If the callback function returns true, the current value from array is returned into the result ArrayObject. Array keys are preserved.

##### shift()
Shifts an element off the beginning of array.

##### pop()
Pops the element off the end of array.

##### merge()
Merges two arrays.

##### isEmpty()
Checks if array is empty.

##### isNotEmpty()
Checks if array is not empty.

##### keys()
Returns all the keys of the array.

##### first()
Returns the first element, ignoring the type of the keys.

##### last()
Returns the last element, ignoring the type of the keys.

### Class ArrayOfObjects

Class `ArrayOfObjects` is the extension of the `ArrayObject` concept. This array may contain only objects of given type.

#### Methods:

##### __construct()

The first argument is the class name. The rest of the arguments are this same as in class `\ArrayObject`.
Constructor can throw `InvalidArgumentException` if one of objects is not instance of the class.

##### getClassName()
Returns the name of the class which this array may contain.

##### offsetSet()
Overrides the method in class `\ArrayObject`. It can throw `InvalidArgumentException` if the object is not the instance of the class.

This method is used in three methods of adding new object to the array:

```php
$arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
 
$arrayOfObjects[] = new \DateTime();
$arrayOfObjects->offsetSet(4, new \DateTime());
$arrayOfObjects->append(new \DateTime());
```

__NOTICE:__ `exchangeArray()` method does not use any of those methods. So, it has to be overwrite.

##### exchangeArray()

Exchange the array for another one.

##### throwExceptionIfObjectIsNotInstanceOfTheClass()
You can overwrite this protected method if you want to throw your own exception.

### Key Naming Strategy

Since version 1.3 this library delivers new functionality - Key Naming Strategy. It allows you to choose how the keys of array are generated.

#### StandardStrategy

Default strategy is [StandardStrategy](src/ArrayObject/KeyNamingStrategy/StandardStrategy.php). Which behaves exactly like PHP arrays key naming strategy.

```php
<?php
use BartoszBartniczak\ArrayObject\ArrayObject;
use BartoszBartniczak\ArrayObject\KeyNamingStrategy\StandardStrategy;

$arrayObject = new ArrayObject([], ArrayObject::DEFAULT_FLAGS, ArrayObject::DEFAULT_ITERATOR_CLASS, new StandardStrategy());

$arrayObject[] = 'a';
$arrayObject[] = 'b';
$arrayObject[] = 'c';
```

Keys in this ArrayObject are: `0`, `1` and `2`.

In fact you do not need to deliver this object to constructor. By default `ArrayObject::__construct` will create this object for you.

#### ValueAsKeyStrategy

The second strategy is [ValueAsKeyStrategy](src/ArrayObject/KeyNamingStrategy/ValueAsKeyStrategy.php). Which forces array to store values as keys.

```php
<?php
use BartoszBartniczak\ArrayObject\ArrayObject;
use BartoszBartniczak\ArrayObject\KeyNamingStrategy\ValueAsKeyStrategy;

$arrayObject = new ArrayObject([], ArrayObject::DEFAULT_FLAGS, ArrayObject::DEFAULT_ITERATOR_CLASS, new ValueAsKeyStrategy());

$arrayObject[] = 'a';
$arrayObject[] = 'b';
$arrayObject[] = 'c';
```
Keys in this ArrayObject are: `a`, `b` and `c`.

#### ClosureStrategy

The last one, but probably the most useful is [ClosureStrategy](src/ArrayObject/KeyNamingStrategy/ClosureStrategy.php). You need to determine Closure function which will be extracting keys. This strategy fits to working with objects.

```php
<?php
use BartoszBartniczak\ArrayObject\ArrayOfObjects;
use BartoszBartniczak\ArrayObject\KeyNamingStrategy\ClosureStrategy;

$closureStrategy = new ClosureStrategy(
    function ($key, \DateTime $dateTime){
        return $dateTime->format('Y-m-d');
    }
);

$arrayOfObjects = new ArrayOfObjects(\DateTime::class, [], ArrayOfObjects::DEFAULT_FLAGS, ArrayOfObjects::DEFAULT_ITERATOR_CLASS, $closureStrategy);

$arrayOfObjects = new \DateTime('2017-03-15');
$arrayOfObjects = new \DateTime('2017-03-16');
$arrayOfObjects = new \DateTime('2017-03-17');
```

Keys in this ArrayObject are: `2017-03-15`, `2017-03-16` and `2017-03-17`.


### Tests

#### Unit tests

The code has been tested by unit tests. You can run unit test in console (tested only on Linux Ubuntu):

```bash
php vendor/phpunit/phpunit/phpunit --configuration tests/unit-tests/configuration.xml
```

