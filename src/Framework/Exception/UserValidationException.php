<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Exception;

use Throwable;

class UserValidationException extends \InvalidArgumentException implements Throwable
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
