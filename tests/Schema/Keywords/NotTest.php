<?php

declare(strict_types=1);

namespace League\OpenAPIValidationTests\Schema\Keywords;

use League\OpenAPIValidation\Schema\Exception\KeywordMismatch;
use League\OpenAPIValidation\Schema\SchemaValidator;
use League\OpenAPIValidationTests\Schema\SchemaValidatorTest;

final class NotTest extends SchemaValidatorTest
{
    public function testItValidatesNotGreen() : void
    {
        $spec = <<<SPEC
schema:
  not:
    type: object
    properties:
      name:
        type: string
SPEC;

        $schema = $this->loadRawSchema($spec);
        $data   = ['name' => 10];

        (new SchemaValidator())->validate($data, $schema);
        $this->addToAssertionCount(1);
    }

    public function testItValidatesNotRed() : void
    {
        $spec = <<<SPEC
schema:
  not:
    type: object
    properties:
      name:
        type: string
SPEC;

        $schema = $this->loadRawSchema($spec);
        $data   = ['name' => 'Dima', 'age' => 10];

        try {
            (new SchemaValidator())->validate($data, $schema);
        } catch (KeywordMismatch $e) {
            $this->assertEquals('not', $e->keyword());
        }
    }
}
