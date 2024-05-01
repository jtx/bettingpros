<?php

namespace CustomExceptions;

class InvalidFileException extends \Exception
{
    /**
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct(string $message = 'Invalid JSON File', int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}