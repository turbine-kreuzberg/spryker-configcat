<?php

namespace TurbineKreuzberg\Client\FeatureFlag\Exception;

use Exception;
use Psr\SimpleCache\InvalidArgumentException as InvalidArgumentExceptionInterface;

class InvalidArgumentException extends Exception implements InvalidArgumentExceptionInterface
{
}
