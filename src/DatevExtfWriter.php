<?php

namespace ameax\DatevExtf;

class DatevExtfWriter
{

    public static function make(): self {
        return new DatevExtfWriter();
    }

    public function hello(): string {
        return 'hello world';
    }
}