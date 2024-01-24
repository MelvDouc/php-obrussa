<?php

namespace MelvDouc\Obrussa;

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

    $numberOfTests = count(self::$tests);
    $passCount = $numberOfTests - $failCount;
    echo Colorizer::cyan("\nNumber of tests: $numberOfTests.\n");
    echo Colorizer::green("Passed: $passCount.") . " " . Colorizer::red("Failed: $failCount.\n");
  }

  protected function __construct()
  {
  }

  public function assert(mixed $value, ?string $message = null): void
  {
    if ($value !== true)
      throw new AssertionException(true, $value, $message ?? "Expression should evaluate to true.");
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
    $this->assert($value === false, $message ?? "Expression should evaluate to false.");
  }

  public function assertTruthy(mixed $value, ?string $message = null): void
  {
    $this->assert(!!$value, $message ?? "Expression should evaluate to false.");
  }

  public function assertFalsy(mixed $value, ?string $message = null): void
  {
    $this->assert(!$value, $message ?? "Expression should evaluate to false.");
  }

  public function assertEquals(mixed $actual, mixed $expected, ?string $message = null): void
  {
    $this->assert($actual === $expected, $message ?? "$actual should be equal to $expected.");
  }

  public function assertNotEquals(mixed $actual, mixed $expected, ?string $message = null): void
  {
    $this->assert($actual !== $expected, $message ?? "$actual should not be equal to $expected.");
  }

  // ===== ===== ===== ===== =====
  // TYPES
  // ===== ===== ===== ===== =====

  public function assertType(mixed $value, string $type, ?string $message = null): void
  {
    $this->assertEquals(gettype($value), $type, $message ?? "Value is not of type \"$type\".");
  }

  public function assertNotType(mixed $value, string $type, ?string $message = null): void
  {
    $this->assertNotEquals(gettype($value), $type, $message ?? "Value is of type \"$type\".");
  }

  public function assertInstanceOf(object $object, string $className, ?string $message = null): void
  {
    $this->assert($object instanceof $className, $message ?? "Object should be an instance of $className.");
  }

  public function assertNotInstanceOf(object $object, string $className, ?string $message = null): void
  {
    $this->assert(!($object instanceof $className), $message ?? "Object should not be an instance of $className.");
  }

  // ===== ===== ===== ===== =====
  // MATH
  // ===== ===== ===== ===== =====

  public function assertLessThan(int|float $smaller, int|float $bigger, ?string $message = null)
  {
    $this->assert($smaller < $bigger, $message ?? "$smaller should be less than $bigger.");
  }

  public function assertLessThanOrEqualTo(int|float $smaller, int|float $bigger, ?string $message = null)
  {
    $this->assert($smaller <= $bigger, $message ?? "$smaller should be less than or equal to $bigger.");
  }

  public function assertGreaterThan(int|float $bigger, int|float $smaller, ?string $message = null)
  {
    $this->assert($bigger > $smaller, $message ?? "$bigger should be greater than $smaller.");
  }

  public function assertGreaterThanOrEqualTo(int|float $bigger, int|float $smaller, ?string $message = null)
  {
    $this->assert($bigger >= $smaller, $message ?? "$bigger should be greater than or equal to $smaller.");
  }

  // ===== ===== ===== ===== =====
  // STRINGS
  // ===== ===== ===== ===== =====

  public function assertLength(string $string, int $length, ?string $message = null)
  {
    $this->assert(strlen($string) === $length, $message ?? "String should be of length $length.");
  }

  public function assertNotLength(string $string, int $length, ?string $message = null)
  {
    $this->assert(strlen($string) !== $length, $message ?? "String should not be of length $length.");
  }

  public function assertStartsWith(string $string, string $substring, ?string $message = null)
  {
    $this->assert(str_starts_with($string, $substring), $message ?? "\"$string\" should start with \"$substring\".");
  }

  public function assertNotStartsWith(string $string, string $substring, ?string $message = null)
  {
    $this->assert(!str_starts_with($string, $substring), $message ?? "\"$string\" should not start with \"$substring\".");
  }

  public function assertEndsWith(string $string, string $substring, ?string $message = null)
  {
    $this->assert(str_ends_with($string, $substring), $message ?? "\"$string\" should end with \"$substring\".");
  }

  public function assertNotEndsWith(string $string, string $substring, ?string $message = null)
  {
    $this->assert(!str_ends_with($string, $substring), $message ?? "\"$string\" should not end with \"$substring\".");
  }

  public function assertMatches(string $string, string $pattern, ?string $message = null)
  {
    $this->assert(
      preg_match($pattern, $string) === 1,
      $message ?? "\"$string\" should match \"$pattern\"."
    );
  }

  public function assertNotMatches(string $string, string $pattern, ?string $message = null)
  {
    $this->assert(
      !preg_match($pattern, $string),
      $message ?? "\"$string\" should not match \"$pattern\"."
    );
  }

  public function assertEmail(string $string, ?string $message = null)
  {
    $this->assert(
      filter_var($string, FILTER_VALIDATE_EMAIL) !== false,
      $message ?? "\"$string\" should be an email address."
    );
  }

  public function assertNotEmail(string $string, ?string $message = null)
  {
    $this->assert(
      !filter_var($string, FILTER_VALIDATE_EMAIL),
      $message ?? "\"$string\" should not be an email address."
    );
  }

  // ===== ===== ===== ===== =====
  // ARRAYS
  // ===== ===== ===== ===== =====

  public function assertContains(array $arr, mixed $element, ?string $message = null)
  {
    $this->assert(in_array($element, $arr), $message ?? "Array should contain specified element.");
  }

  public function assertNotContains(array $arr, mixed $element, ?string $message = null)
  {
    $this->assert(!in_array($element, $arr), $message ?? "Array should not contain specified element.");
  }

  public function assertCount(array $arr, int $count, ?string $message = null)
  {
    $this->assert(count($arr) === $count, $message ?? "Array should be of length $count.");
  }

  public function assertNotCount(array $arr, int $count, ?string $message = null)
  {
    $this->assert(count($arr) !== $count, $message ?? "Array should not be of length $count.");
  }

  // ===== ===== ===== ===== =====
  // EXPECT
  // ===== ===== ===== ===== =====

  public function expect(mixed $value): Expecter
  {
    return new Expecter($this, $value);
  }
}