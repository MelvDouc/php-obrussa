# Obrussa

A simple PHP unit test library meant to resemble the native test module from NodeJS.

## Examples

Write some tests.

```php
// tests/index.php

require_once dirname(__DIR__) . "/vendor/autoload.php";

use MelvDouc\Obrussa\TestSuite;

function add(int $a, int $b): int
{
  return $a + $b;
}

TestSuite::test("1 + 1 = 2", function (TestSuite $testSuite) {
  $testSuite->assertEquals(add(1, 1), 2);
});

TestSuite::test("instanceof", function (TestSuite $testSuite) {
  $testSuite->expect($testSuite)->toBeInstanceOf(TestSuite::class);
  $testSuite->expect($testSuite)->not()->toBeInstanceOf(\stdClass::class);
});

TestSuite::test("email", function (TestSuite $testSuite) {
  $testSuite->assertEmail("example@mail.com");
  $testSuite->assertNotEmail("example@mail");
  $testSuite->expect("example.com")->not()->toBeEmail();
});

TestSuite::run();
```

Run the tests.

```bash
php tests/index.php
```

Output:

```unknown
✓ 1 + 1 = 2
✓ instanceof
✓ email

Number of tests: 3.
Passed: 3. Failed: 0.
```
