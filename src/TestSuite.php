<?php

namespace MelvDouc\Obrussa;

use MelvDouc\Obrussa\Exception\AssertionException;
use MelvDouc\Obrussa\Utils\Colorizer;

class TestSuite
{
  /**
   * @var array<string, callable>
   */
  private static array $tests = [];

  /**
   * Register a test.
   * @param string $name The unique test name.
   * @param callable $testFn A function of the type `(TestSuite $testSuite): void`.
   */
  public static function test(string $name, callable $testFn): void
  {
    if (isset(self::$tests[$name])) {
      throw new \Exception("A test named \"$name\" already exists.");
    }

    self::$tests[$name] = $testFn;
  }

  /**
   * Run all tests.
   */
  public static function run(): void
  {
    $testSuite = new self();
    $failCount = 0;

    foreach (self::$tests as $name => $testFn) {
      try {
        $testFn($testSuite);
        echo Colorizer::green("✓ $name\n");
      } catch (\Exception $e) {
        $failCount++;
        $cls = get_class($e);
        $message = $e->getMessage();
        echo Colorizer::red("- $name\n");
        echo Colorizer::bold("  $cls\n");
        echo "  $message\n";
      }
    }

    $failColor = $failCount ? "red" : "green";
    $numberOfTests = count(self::$tests);
    $passCount = $numberOfTests - $failCount;
    echo Colorizer::cyan("\nNumber of tests: $numberOfTests.\n");
    echo Colorizer::green("Passed: $passCount.") . " " . Colorizer::{$failColor}("Failed: $failCount.\n");
  }

  protected function __construct()
  {
  }

  public function assert(mixed $value, ?string $message = null): void
  {
    if ($value !== true)
      throw new AssertionException(expected: true, actual: $value, message: $message);
  }

  /**
   * Alias of `assert`.
   */
  public function assertTrue(mixed $value, ?string $message = null): void
  {
    $this->assert($value, $message ?? "");
  }

  public function assertFalse(mixed $value, ?string $message = null): void
  {
    $this->assert($value === false, $message);
  }

  public function assertTruthy(mixed $value, ?string $message = null): void
  {
    $this->assert(!!$value, $message);
  }

  public function assertFalsy(mixed $value, ?string $message = null): void
  {
    $this->assert(!$value, $message);
  }

  public function assertEquals(mixed $actual, mixed $expected, ?string $message = null): void
  {
    if ($actual !== $expected)
      throw new AssertionException(actual: $actual, expected: $expected, message: $message);
  }

  public function assertNotEquals(mixed $actual, mixed $expected, ?string $message = null): void
  {
    $this->assert($actual !== $expected, $message);
  }

  // ===== ===== ===== ===== =====
  // TYPES
  // ===== ===== ===== ===== =====

  public function assertType(mixed $value, string $type, ?string $message = null): void
  {
    $this->assertEquals(gettype($value), $type, $message);
  }

  public function assertNotType(mixed $value, string $type, ?string $message = null): void
  {
    $this->assertNotEquals(gettype($value), $type, $message);
  }

  public function assertInstanceOf(object $object, string $className, ?string $message = null): void
  {
    $this->assert($object instanceof $className, $message);
  }

  public function assertNotInstanceOf(object $object, string $className, ?string $message = null): void
  {
    $this->assert(!($object instanceof $className), $message);
  }

  // ===== ===== ===== ===== =====
  // MATH
  // ===== ===== ===== ===== =====

  public function assertLessThan(int|float $smaller, int|float $bigger, ?string $message = null)
  {
    $this->assert($smaller < $bigger, $message);
  }

  public function assertLessThanOrEqualTo(int|float $smaller, int|float $bigger, ?string $message = null)
  {
    $this->assert($smaller <= $bigger, $message);
  }

  public function assertGreaterThan(int|float $bigger, int|float $smaller, ?string $message = null)
  {
    $this->assert($bigger > $smaller, $message);
  }

  public function assertGreaterThanOrEqualTo(int|float $bigger, int|float $smaller, ?string $message = null)
  {
    $this->assert($bigger >= $smaller, $message);
  }

  // ===== ===== ===== ===== =====
  // STRINGS
  // ===== ===== ===== ===== =====

  public function assertLength(string $string, int $length, ?string $message = null)
  {
    $this->assertEquals(strlen($string), $length, $message);
  }

  public function assertNotLength(string $string, int $length, ?string $message = null)
  {
    $this->assertNotEquals(strlen($string), $length, $message);
  }

  public function assertStartsWith(string $string, string $substring, ?string $message = null)
  {
    $this->assert(str_starts_with($string, $substring), $message);
  }

  public function assertNotStartsWith(string $string, string $substring, ?string $message = null)
  {
    $this->assert(!str_starts_with($string, $substring), $message);
  }

  public function assertEndsWith(string $string, string $substring, ?string $message = null)
  {
    $this->assert(str_ends_with($string, $substring), $message);
  }

  public function assertNotEndsWith(string $string, string $substring, ?string $message = null)
  {
    $this->assert(!str_ends_with($string, $substring), $message);
  }

  public function assertMatches(string $string, string $pattern, ?string $message = null)
  {
    $this->assert(preg_match($pattern, $string) === 1, $message);
  }

  public function assertNotMatches(string $string, string $pattern, ?string $message = null)
  {
    $this->assert(!preg_match($pattern, $string), $message);
  }

  public function assertEmail(string $string, ?string $message = null)
  {
    $this->assert(filter_var($string, FILTER_VALIDATE_EMAIL) !== false, $message);
  }

  public function assertNotEmail(string $string, ?string $message = null)
  {
    $this->assert(!filter_var($string, FILTER_VALIDATE_EMAIL), $message);
  }

  // ===== ===== ===== ===== =====
  // ARRAYS
  // ===== ===== ===== ===== =====

  public function assertContains(array $arr, mixed $element, ?string $message = null)
  {
    $this->assert(in_array($element, $arr), $message);
  }

  public function assertNotContains(array $arr, mixed $element, ?string $message = null)
  {
    $this->assert(!in_array($element, $arr), $message);
  }

  public function assertHasKey(array $arr, string|int $key, ?string $message = null)
  {
    $this->assert(array_key_exists($key, $arr), $message);
  }

  public function assertNotHasKey(array $arr, string|int $key, ?string $message = null)
  {
    $this->assert(!array_key_exists($key, $arr), $message);
  }

  public function assertCount(array $arr, int $count, ?string $message = null)
  {
    $this->assertEquals(count($arr), $count, $message);
  }

  public function assertNotCount(array $arr, int $count, ?string $message = null)
  {
    $this->assertNotEquals(count($arr), $count, $message);
  }

  // ===== ===== ===== ===== =====
  // EXPECT
  // ===== ===== ===== ===== =====

  public function expect(mixed $value): Expecter
  {
    return new Expecter($this, $value);
  }
}