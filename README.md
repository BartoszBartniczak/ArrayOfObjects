ArrayObject
===========
An extension of SPL ArrayObject which does not have all array methods E.g. pop, shift, etc.. The other class ArrayOfObject is an extension of this concept. This array can contain only objects of given type.
-----

### Table of contents:
1. [ArrayObject](#class-arrayobject)
2. [ArrayOfObjects](#class-arrayofobjects)
3. [Tests](#tests)

### Class ArrayObject

This class is an extension of the SPL `\ArrayObject` class. It contains all the missing methods. 

#### Description:

#### Methods:

##### __construct()

Exactly this same as SPL `\ArrayObject` constructor.

##### changeKeyCase()

Changes the case of all keys in an ArrayObject

##### chunk()

Split an array into chunks. Every chunk is an ArrayObject object.

##### keys()

Returns ArrayObject with all the keys.

### Class ArrayOfObjects

This array can contain only objects of defined class.

#### Methods:

This class has exactly this same methods as the class above because it extends it. In this chapter are described those methods which are changed somehow.

##### __construct()

The first argument is the class name. The rest of the arguments are this same as above.
Constructor can throw `InvalidArgumentException` if one of objects is not instance of the class.

##### getClassName()
Returns the name of the class which this array can contain.

##### offsetSet()
Overrides the method in class `\ArrayObject`. It can throw `InvalidArgumentException` if the object is not the instance of the class.

This method is used in three methods of adding new object to the array:

```php
$arrayOfObjects = new ArrayOfObjects(\DateTime::class, [new \DateTime(), new \DateTime()]);
 
$arrayOfObjects[] = new \DateTime();
$arrayOfObjects->offsetSet(4, new \DateTime());
$arrayOfObjects->append(new \DateTime());
```

##### chunk()

Split an array into chunks. Every chunk is an ArrayOfObjects object.

### Tests

#### Unit tests
