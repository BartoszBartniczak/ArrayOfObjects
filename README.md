Bartosz Bartniczak / ArrayOfObjects 
===========
Array object may contain only objects of given type.
-----

### Table of contents:
1. [Class ArrayOfObjects](#class-arrayofobjects)
2. [Tests](#tests)

### Class ArrayOfObjects

Class `ArrayOfObjects` is the extension of the `\ArrayObject` concept. This array may contain only objects of given type.

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

### Tests

#### Unit tests

The code has been tested by unit tests. You can run unit test in console (tested only on Linux Ubuntu):

```bash
php vendor/phpunit/phpunit/phpunit --configuration tests/unit-tests/configuration.xml
```