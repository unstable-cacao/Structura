<?php
namespace Structura\Exceptions;


class StructuraCallbackNotProvidedException extends StructuraCacheException
{
    public function __construct()
    {
        parent::__construct("Callback must be provided.");
    }
}