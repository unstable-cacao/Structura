*************
URL
*************

.. code-block:: php

    /**
     * @property string			$Scheme
     * @property string			$Host
     * @property int			$Port
     * @property string			$User
     * @property string			$Pass
     * @property string			$Path
     * @property array			$Query
     * @property string|null    $Fragment
     */



setQueryParams
-----------------

.. function:: public setQueryParams(array $params): void

    Set the query params of the request


addQueryParams
-----------------

.. function:: public addQueryParams(array $params): void

    Add query params


addQueryParam
-----------------

.. function:: public addQueryParam(string $key, string $value): void

    Add a query param


url
-----------------

.. function:: public url(): string

    Get the full assembled url

*Example:*

.. code-block:: php

    $url = new URL();
    $url->Scheme	= 'http';
    $url->User		= 'test';
    $url->Pass		= 'pass';
    $url->Host		= 'hello.world.com';
    $url->Port		= 80;
    $url->Path		= '/hi.html';
    $url->Query		= ['a' => 3];
    $url->Fragment	= 'menu';

``$url->url()`` will return ``http://test:pass@hello.world.com/hi.html?a=3#menu``


setUrl
-----------------

.. function:: public setUrl(string $url): void

    Set the url

*Example:*

.. code-block:: php

    $url = new URL();
    $url->setUrl('http://hello.world.com/hi.php?a=3#menu');

``$url->Scheme`` will return ``http``

``$url->Host`` will return ``hello.world.com``

``$url->Query`` will return ``['a' => '3']``
