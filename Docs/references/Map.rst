*************
Map
*************

.. code-block:: php

    class Map implements \IteratorAggregate, \ArrayAccess, \Countable, ICollection
    {
        public function __construct(?iterable $traversable = null);
    }


Map is a data structure


setTransform
-----------------

.. function:: public setTransform(?callable $transform = null): void

    Set a transforming callback to call on a key

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);
    $map->setTransform(function($key) 
    {
        return ++$key;
    });

``$map->get(0)`` will return ``2``


getTransform
-----------------

.. function:: public getTransform(): ?callable


add
-----------------

.. function:: public add($key, $value = null)

    Add a value to the map

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);
    $map->add(0, 5);

``$map->get(0)`` will return ``5``


remove
-----------------

.. function:: public remove($key)

    Remove a value from the map

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);
    $map->remove(0);

``$map->has(0)`` will return ``false``


get
-----------------

.. function:: public get($key)

    Get a value from the map

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->get(0)`` will return ``1``


getIfExists
-----------------

.. function:: public getIfExists($key, $default = null)
    
    Get a value from the map. If no exists, return default

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->getIfExists(0, 5)`` will return ``1``

``$map->getIfExists(3, 5)`` will return ``5``


tryGet
-----------------

.. function:: public tryGet($key, &$value): bool

    Try to get a value from the map, but don't fail if not exists

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->tryGet(0, $value)`` will return ``true`` and *$value* will be ``1``

``$map->tryGet(3, $value)`` will return ``false`` and *$value* will be ``null``


has
-----------------

.. function:: public has($key): bool
    
    Check if key exists in map

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->has(0)`` will return ``true``

``$map->has(3)`` will return ``false``


hasAny
-----------------

.. function:: public hasAny(array $keys): bool

    Check if any of the keys exist in the map

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->hasAny([0, 3, 5])`` will return ``true``

``$map->hasAny([3, 5, 7])`` will return ``false``


hasAll
-----------------

.. function:: public hasAll(array $keys): bool

    Check if all the keys exist in the map

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->hasAll([0, 1])`` will return ``true``

``$map->hasAll([0, 3])`` will return ``false``


count
-----------------

.. function:: public count(): int

    Return how many values in the map

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->count()`` will return ``3``


isEmpty
-----------------

.. function:: public isEmpty(): bool

    Check if map empty

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->isEmpty()`` will return ``false``


hasElements
-----------------

.. function:: public hasElements(): bool

    Check if map has elements

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->hasElements()`` will return ``true``


clear
-----------------

.. function:: public clear()

    Clear the map

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);
    $map->clear();

``$map->isEmpty()`` will return ``true``


keys
-----------------

.. function:: public keys(): array

    Get map keys

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->keys()`` will return ``[0, 1, 2]``


values
-----------------

.. function:: public values(): array

    Get map values

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->values()`` will return ``[1, 2, 3]``


keysSet
-----------------

.. function:: public keysSet(): Set

    Get a set of the map keys


merge
-----------------

.. function:: public merge(...$map): Map

    Merge map with given iterable objects

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);
    $map->merge([5, 6, 7], [9, 5]);

``$map->toArray()`` will return ``[0 => 9, 1 => 5, 2 => 7]``


intersect
-----------------

.. function:: public intersect(...$map): Map

    Intersect map with given iterable objects

*Example:*

.. code-block:: php

    $map = new Map([1 => 1, 2 => 2, 3 => 3]);
    $map->intersect([1 => 3, 3 => 5], [3 => 9], [3 => 15, 16 => 16]);

``$map->toArray()`` will return ``[3 => 3]``


diff
-----------------

.. function:: public diff(...$map): Map

    Get map diff with given iterable objects

*Example:*

.. code-block:: php

    $map = new Map([1 => 1, 2 => 2, 8 => 3]);
    $map->diff([5], [5 => 9], [1, 2, 3, 4]);

``$map->toArray()`` will return ``[8 => 3]``


symmetricDiff
-----------------

.. function:: public symmetricDiff(...$map): Map

    Get symmetric diff map with given iterable objects

*Example:*

.. code-block:: php

    $map = new Map([1 => 1, 2 => 2, 8 => 3]);
    $map->symmetricDiff([5], [5 => 9], [1, 2, 3, 4]);

``$map->toArray()`` will return ``[8 => 3, 5 => 9, 3 => 4]``


toArray
-----------------

.. function:: public toArray(): array

    Get map as array

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map->toArray()`` will return ``[1, 2, 3]``


getIterator
-----------------

.. function:: public getIterator()
    
    Retrieve an external iterator, see also: http://php.net/manual/en/iteratoraggregate.getiterator.php


offsetExists
-----------------

.. function:: public offsetExists($offset)

    Whether a offset exists, see also: http://php.net/manual/en/arrayaccess.offsetexists.php

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``isset($map[0])`` will return ``true``

``isset($map[5])`` will return ``false``


offsetGet
-----------------

.. function:: public offsetGet($offset)

    Offset to retrieve, see also: http://php.net/manual/en/arrayaccess.offsetget.php

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);

``$map[0]`` will return ``1``


offsetSet
-----------------

.. function:: public offsetSet($offset, $value)

    Offset to set, see also: http://php.net/manual/en/arrayaccess.offsetset.php

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);
    $map[0] = 2;

``$map->get(0)`` will return ``2``


offsetUnset
-----------------

.. function:: public offsetUnset($offset)

    Offset to unset, see also: http://php.net/manual/en/arrayaccess.offsetunset.php

*Example:*

.. code-block:: php

    $map = new Map([1, 2, 3]);
    unset($map[0]);

``$map->has(0)`` will return ``false``


mergeMap
-----------------

.. function:: public static mergeMap(...$map): Map

    Merge all given iterable objects and return result as Map

*Example:*

.. code-block:: php

    $map = Map::mergeMap([1, 2, 3], [5, 6, 7], [9, 5]);

``$map->toArray()`` will return ``[0 => 9, 1 => 5, 2 => 7]``


intersectMap
-----------------

.. function:: public static intersectMap(...$map): Map

    Intersect all given iterable objects and return result as Map

*Example:*

.. code-block:: php

    $map = Map::intersectMap([1 => 1, 2 => 2, 3 => 3], [1 => 3, 3 => 5], [3 => 9], [3 => 15, 16 => 16]);

``$map->toArray()`` will return ``[3 => 3]``


diffMap
-----------------

.. function:: public static diffMap(...$map): Map

    Get diff of all given iterable objects and return result as Map

*Example:*

.. code-block:: php

    $map = Map::diffMap([1 => 1, 2 => 2, 8 => 3], [5], [5 => 9], [1, 2, 3, 4]);

``$map->toArray()`` will return ``[8 => 3]``


symmetricDiffMap
-----------------

.. function:: public static symmetricDiffMap(...$map): Map

    Get symmetric diff of all given iterable objects and return result as Map

*Example:*

.. code-block:: php

    $map = Map::symmetricDiffMap([1 => 1, 2 => 2, 8 => 3], [5], [5 => 9], [1, 2, 3, 4]);

``$map->toArray()`` will return ``[8 => 3, 5 => 9, 3 => 4]``
