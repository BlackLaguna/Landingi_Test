<?php
declare(strict_types=1);

namespace RecruitmentApp\Framework\Exception;

use JetBrains\PhpStorm\Pure;
use Throwable;

class ApiValidationException extends \InvalidArgumentException implements Throwable
{
    #[Pure] public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
