<?php

namespace App\Exceptions;

use Exception;

class CommentValidationException extends Exception
{
    protected $message = 'Comment limit exceeded.';
}
