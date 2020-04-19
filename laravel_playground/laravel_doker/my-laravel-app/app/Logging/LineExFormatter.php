<?php
namespace App\Logging;
use Monolog\Formatter\LineFormatter;

class LineExFormatter extends LineFormatter
{
    public function __construct()
    {
        $format = "%datetime% [%channel%.%level_name%] %extra.class%@%extra.function%(%extra.line%) - %message%" . PHP_EOL;
        $dateFormat = "Y/m/d H:i:s";

        parent::__construct($format, $dateFormat, true, true);
    }

    public function format($record): string
    {
        $output = parent::format($record);
        if (is_array($record['context'])) {
            $output = vsprintf($output, $record['context']);
        }
        return $output;
        // return json_encode($record);
    }
}
