<?php

declare(strict_types=1);

namespace app\components\exceptions;

final class ModelValidationException extends \RuntimeException
{
    public function __construct(public readonly array $errors, string $message = 'Validation failed')
    {
        parent::__construct($message);
    }
}
