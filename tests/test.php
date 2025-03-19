<?php

use ameax\DatevExtf\DatevExtfWriter;

it('returns the correct greeting', function () {
    expect(DatevExtfWriter::make()->hello())->toBe('hello world');
});