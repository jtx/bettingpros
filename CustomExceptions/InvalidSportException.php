<?php

namespace CustomExceptions;

class InvalidSportException extends \Exception
{
    /**
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct(string $message = 'Invalid Sport Type', int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}