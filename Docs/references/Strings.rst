*************
Strings
*************

Strings is a static class


isStartsWith
-----------------

.. function:: public static isStartsWith(string $source, string $start): bool

    Check if string starts with another string


*Examples:*

``Strings::isStartsWith('testString', 'test')`` will return ``true``

``Strings::isStartsWith('testString', 'the')`` will return ``false``


isEndsWith
-----------------

.. function:: public static isEndsWith(string $source, string $end): bool

    Check if string ends with another string


*Examples:*

``Strings::isEndsWith('ending', 'ing')`` will return ``true``

``Strings::isEndsWith('ending', 'eng')`` will return ``false``


replace
-----------------

.. function:: public static replace(string $subject, string $needle, string $with, int $limit = null): string

    Replace string with another string


*Examples:*

``Strings::replace('the test string', 'the', 'a')`` will return ``a test string``

``Strings::replace('the test the string the', 'the', 'a', 2)`` will return ``a test a string the``


endWith
-----------------

.. function:: public static endWith(string $source, string $end): string

    Ensure the string ends with the given string


*Examples:*

``Strings::endWith('ending', 'ing')`` will return ``ending``

``Strings::endWith('end', 'ing')`` will return ``ending``


startWith
-----------------

.. function:: public static startWith(string $source, string $start): string

    Ensure the string starts with the given string


*Examples:*

``Strings::startWith('testString', 'test')`` will return ``testString``

``Strings::startWith('String', 'test')`` will return ``testString``


trimStart
--------------------

.. function:: public static trimStart(string $source, string $start): string

    Ensure the string is not starting with the given string


*Examples:*

``Strings::trimStart('testString', 'test')`` will return ``String``

``Strings::trimStart('String', 'test')`` will return ``String``


trimEnd
------------------

.. function:: public static trimEnd(string $source, string $end): string

    Ensure the string is not ending with the given string


*Examples:*

``Strings::trimEnd('ending', 'ing')`` will return ``end``

``Strings::trimEnd('end', 'ing')`` will return ``end``


contains
-----------------

.. function:: public static contains(string $haystack, string $needle): bool

    Check if string contains another string


*Examples:*

``Strings::contains('testString', 'test')`` will return ``true``

``Strings::contains('String', 'test')`` will return ``false``


cut
-----------------

.. function:: public static cut(string $source, $index, int $length = null): string

    Cuts a string from given index for a given length or 1 by default


*Examples:*

``Strings::cut('hello world', 5)`` will return ``helloworld``

``Strings::cut('hello world', 5, 2)`` will return ``helloorld``

``Strings::cut('hello world', [5, 2])`` will return ``helloorld``
