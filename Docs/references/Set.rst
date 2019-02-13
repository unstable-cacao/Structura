*************
Set
*************

.. code-block:: php

    class Set implements \IteratorAggregate, \ArrayAccess, \Countable, ICollection
    {
        public function __construct(?iterable $source = null);
    }


Set is a data structure


deepClone
-----------------

.. function:: public deepClone(): Set

    Get a clone of the set


isEmpty
-----------------

.. function:: public isEmpty(): bool

    Check if set empty

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);

``$set->isEmpty()`` will return ``false``


hasElements
-----------------

.. function:: public hasElements(): bool

    Check if set has elements

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);

``$set->hasElements()`` will return ``true``


count
-----------------

.. function:: public count(): int

    Return how many values in the set

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);

``$set->count()`` will return ``3``


has
-----------------

.. function:: public has($value): bool

    Check if value exists in set

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);

``$set->has(1)`` will return ``true``

``$set->has(4)`` will return ``false``


hasAny
-----------------

.. function:: public hasAny(...$value): bool

    Check if any of the values exists in the set

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);

``$set->hasAny(0, 3, 5)`` will return ``true``

``$set->hasAny(0, 8, 10)`` will return ``false``


hasAll
-----------------

.. function:: public hasAll(...$value): bool

    Check if all the values exist in the set

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);

``$set->hasAll(1, 3)`` will return ``true``

``$set->hasAll(0, 3)`` will return ``false``


add
-----------------

.. function:: public add(...$value): void

    Add a value to the set

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);
    $set->add(6, 5, 8);

``$set->toArray()`` will return ``[1, 2, 3, 6, 5, 8]``


addIfMissing
-----------------

.. function:: public addIfMissing($value): bool

    Add a value to the set if missing and return if added

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);
    $set->addIfMissing(1;

``$set->toArray()`` will return ``[1, 2, 3]``


rem
-----------------

.. function:: public rem(...$value): void

    Remove a value from the set

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);
    $set->rem(1);

``$set->toArray()`` will return ``[2, 3]``


clear
-----------------

.. function:: public clear(): void

    Clear the set

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);
    $set->clear();

``$set->isEmpty()`` will return ``true``


toArray
-----------------

.. function:: public toArray(): array

    Get set as array

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);

``$set->toArray()`` will return ``[1, 2, 3]``


merge
-----------------

.. function:: public merge(...$set): void

    Merge set with given iterable objects

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);
    $set->merge([5, 6], [9, 5]);

``$set->toArray()`` will return ``[1, 2, 3, 5, 6, 9]``


intersect
-----------------

.. function:: public intersect(...$set): void

    Intersect set with given iterable objects

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3, 4]);
    $set->intersect([3, 5], [3], [3, 6]);

``$set->toArray()`` will return ``[3]``


diff
-----------------

.. function:: public diff(...$set): void

    Get set diff with given iterable objects

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3, 4]);
    $set->diff([5], [2], [1, 2, 3]);

``$set->toArray()`` will return ``[4]``


symmetricDiff
-----------------

.. function:: public symmetricDiff(...$set): void

    Get symmetric diff set with given iterable objects

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);
    $set->symmetricDiff([2, 3], [5]);

``$set->toArray()`` will return ``[1, 5]``


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

    $set = new Set([1, 2, 3]);

``isset($set[1])`` will return ``true``

``isset($set[5])`` will return ``false``


offsetGet
-----------------

.. function:: public offsetGet($offset)

    Offset to retrieve, see also: http://php.net/manual/en/arrayaccess.offsetget.php

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);

``$set[1]`` will return ``1``


offsetSet
-----------------

.. function:: public offsetSet($offset, $value)

    Offset to set, see also: http://php.net/manual/en/arrayaccess.offsetset.php

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);
    $set[0] = true;

``$set->has(0)`` will return ``0``


offsetUnset
-----------------

.. function:: public offsetUnset($offset)

    Offset to unset, see also: http://php.net/manual/en/arrayaccess.offsetunset.php

*Example:*

.. code-block:: php

    $set = new Set([1, 2, 3]);
    unset($set[1]);

``$set->has(1)`` will return ``false``
