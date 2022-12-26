<?php declare(strict_types=1);

namespace Myposter\Logger\Formatter;

use Monolog\Formatter\LineFormatter;

class FileFormatter extends LineFormatter
{
    private const RECORD_FORMAT = "%datetime% - %level_name%: %message% %context% %extra%\n";
    private const DATE_FORMAT = 'Y-m-d\TH:i:s.uP';

    public function __construct()
    {
        parent::__construct(static::RECORD_FORMAT, static::DATE_FORMAT, true, true, true);
    }
}