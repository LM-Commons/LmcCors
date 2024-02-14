<?php

namespace LmcCors\Exception;

use DomainException;

/**
 * @license MIT
 * @author  Max Bösing <max@boesing.email>
 */
class InvalidOriginException extends DomainException implements ExceptionInterface
{
    /**
     * @return self
     */
    public static function fromInvalidHeaderValue(): InvalidOriginException
    {
        return new self('Provided header value supposed to be invalid.');
    }
}
