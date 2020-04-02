<?php
// set_error_handler_.php のエラーハンドル部分を書き換えて、関数間で共通にしたい場合...
// https://qiita.com/mpyw/items/470f5f660080835f55a0
function handle_error(callable $function, ...$args)
{
    set_error_handler(function($severity, $message) {
        throw new \RuntimeException($message);
    });
    try {
        return $function(...$args);
    } finally {
        restore_error_handler();
    }
}

function read_image_metadata(string $filename)
{
    return handle_error(function () use ($filename) {
        $type = exif_imagetype($filename);
        if ($type !== IMAGETYPE_JPEG) {
            return [];
        }
        return exif_read_data($filename);
    });
}