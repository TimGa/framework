<?php

namespace Framework\Http;

/**
 * Description of RequestFactory
 *
 * @author timofey
 */
class RequestFactory
{
    public static function fromGlobals(array $query = null, array $body = null): Request
    {
        return (new Request())
            ->setQueryParams($query ?: $_GET)
            ->setParsedBody($body ?: $_POST);
    }
}
