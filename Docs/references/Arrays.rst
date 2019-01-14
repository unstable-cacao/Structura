*************
Arrays
*************

Arrays is a static class



toArray
-----------------

.. function:: public static toArray($data): array


*Examples:*

``Arrays::toArray(['a' => 5, 'b' => 8])`` will return

.. code-block:: php

    ['a' => 5, 'b' => 8]


``Arrays::toArray(5)`` will return

.. code-block:: php

    [5]



asArray
-----------------

.. function:: public static asArray(&$data): array

    Same as toArray but data is a reference



first
-----------------

.. function:: public static first(array $data)


*Examples:*

``Arrays::first(['a' => 5, 'b' => 8])`` will return

.. code-block:: php

    5


``Arrays::first([9, 6, 9])`` will return

.. code-block:: php

    9


``Arrays::first([])`` will return

.. code-block:: php

    null



last
-----------------

.. function:: public static last(array $data)


*Examples:*

``Arrays::last(['a' => 5, 'b' => 8])`` will return

.. code-block:: php

    8


``Arrays::last([9, 6, 9])`` will return

.. code-block:: php

    9


``Arrays::last([])`` will return

.. code-block:: php

    null



isNumeric
-----------------

.. function:: public static isNumeric(array $data): bool


*Examples:*

``Arrays::isNumeric(['a' => 5, 'b' => 8])`` will return

.. code-block:: php

    false


``Arrays::isNumeric([9, 6, 9])`` will return

.. code-block:: php

    true


``Arrays::isNumeric([])`` will return

.. code-block:: php

    true


``Arrays::isNumeric([0 => 5, 2 => 6, 3 => 7])`` will return

.. code-block:: php

    false



isAssoc
-----------------

.. function:: public static isAssoc(array $data): bool


*Examples:*

``Arrays::isAssoc(['a' => 5, 'b' => 8])`` will return

.. code-block:: php

    true


``Arrays::isAssoc([9, 6, 9])`` will return

.. code-block:: php

    false


``Arrays::isAssoc([])`` will return

.. code-block:: php

    true


``Arrays::isAssoc([0 => 5, 2 => 6, 3 => 7])`` will return

.. code-block:: php

    true



firstKey
-----------------

.. function:: public static firstKey(array $data)


*Examples:*

``Arrays::firstKey(['a' => 5, 'b' => 8])`` will return

.. code-block:: php

    'a'


``Arrays::firstKey([9, 6, 9])`` will return

.. code-block:: php

    0


``Arrays::firstKey([])`` will return

.. code-block:: php

    null



lastKey
-----------------

.. function:: public static lastKey(array $data)


*Examples:*

``Arrays::lastKey(['a' => 5, 'b' => 8])`` will return

.. code-block:: php

    'b'


``Arrays::lastKey([9, 6, 9])`` will return

.. code-block:: php

    2


``Arrays::lastKey([])`` will return

.. code-block:: php

    null



mergeRecursiveAssoc
----------------------

.. function:: public static mergeRecursiveAssoc(array $main, array ...$arrays): array


*Examples:*

``Arrays::mergeRecursiveAssoc(['a' => 1, 'b' => 2], ['b' => 3, 'c' => 4])`` will return

.. code-block:: php

    [
        'a' => 1,
        'b' => 2,
        'c' => 3, 
        'd' => 4
	]


``Arrays::mergeRecursiveAssoc(['a' => 1], ['b' => 2, 'c' => [5]], [3])`` will return

.. code-block:: php

    [
        'a' => 1,
        'b' => 2,
        'c' => [5]
    ]



toArrayRecursive
-----------------

.. function:: public static toArrayRecursive(iterable $input): array 



merge
-----------------

.. function:: public static merge(...$with): array


*Examples:*

``Arrays::merge(['a'], 'b', [1, 2], 3)`` will return

.. code-block:: php

    ['a', 'b', 1, 2, 3]


``Arrays::merge(['key' => 'a'], 'b', ['key' => 1, 2], 3)`` will return

.. code-block:: php

    ['key' => 1, 'b', 2, 3]
