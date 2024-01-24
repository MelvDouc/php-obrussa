<?php

namespace MelvDouc\Obrussa;

class Expecter
{
  protected bool $useTrue = true;

  public function __construct(protected readonly TestSuite $testSuite, protected readonly mixed $value)
  {
  }

  public function not(): static
  {
    $this->useTrue = !$this->useTrue;
    return $this;
  }

  public function toBeTrue(?string $message = null): void
  {
    $this->assert("assertTrue", "assertFalse", $this->value, $message);
  }

  public function toBeFalse(?string $message = null): void
  {
    $this->assert("assertFalse", "assertTrue", $this->value, $message);
  }

  public function toBeTruthy(?string $message = null): void
  {
    $this->assert("assertTruthy", "assertFalsy", $this->value, $message);
  }

  public function toBeFalsy(?string $message = null): void
  {
    $this->assert("assertFalsy", "assertTruthy", $this->value, $message);
  }

  public function toEqual(mixed $expected, ?string $message = null): void
  {
    $this->assert("assertEquals", "assertNotEquals", $this->value, $expected, $message);
  }

  // ===== ===== ===== ===== =====
  // TYPES
  // ===== ===== ===== ===== =====

  public function toBeOfType(string $type, ?string $message = null)
  {
    $this->assert("assertType", "assertNotType", $this->value, $type);
  }

  public function toBeBoolean(?string $message = null)
  {
    $this->toBeOfType("bool", $message);
  }

  public function toBeInteger(?string $message = null)
  {
    $this->toBeOfType("int", $message);
  }

  public function toBeFloat(?string $message = null)
  {
    $this->toBeOfType("double", $message);
  }

  public function toBeString(?string $message = null)
  {
    $this->toBeOfType("string", $message);
  }

  public function toBeArray(?string $message = null)
  {
    $this->toBeOfType("array", $message);
  }

  public function toBeObject(?string $message = null)
  {
    $this->toBeOfType("object", $message);
  }

  public function toBeNull(?string $message = null)
  {
    $this->toEqual(null, $message);
  }

  public function toBeInstanceOf(string $className, ?string $message = null): void
  {
    $this->assert("assertInstanceOf", "assertNotInstanceOf", $this->value, $className, $message);
  }

  // ===== ===== ===== ===== =====
  // MATH
  // ===== ===== ===== ===== =====

  public function toBeLessThan(int|float $bigger, ?string $message = null): void
  {
    $this->assert("assertLessThan", "assertGreaterThanOrEqualTo", $this->value, $bigger, $message);
  }

  public function toBeLessThanOrEqualTo(int|float $bigger, ?string $message = null): void
  {
    $this->assert("assertLessThanOrEqualTo", "assertGreaterThan", $this->value, $bigger, $message);
  }

  public function toBeGreaterThan(int|float $smaller, ?string $message = null): void
  {
    $this->assert("assertGreaterThan", "assertLessThanOrEqualTo", $this->value, $smaller, $message);
  }

  public function toBeGreaterThanOrEqualTo(int|float $smaller, ?string $message = null): void
  {
    $this->assert("assertGreaterThanOrEqualTo", "assertLessThan", $this->value, $smaller, $message);
  }

  // ===== ===== ===== ===== =====
  // STRINGS
  // ===== ===== ===== ===== =====

  public function toHaveLength(int $length, ?string $message = null): void
  {
    $this->assert("assertLength", "assertNotLength", $this->value, $length, $message);
  }

  public function toStartWith(string $substring, ?string $message = null): void
  {
    $this->assert("assertStartsWith", "assertNotStartsWith", $this->value, $substring, $message);
  }

  public function toEndWith(string $substring, ?string $message = null): void
  {
    $this->assert("assertEndsWith", "assertNotEndsWith", $this->value, $substring, $message);
  }

  public function toMatch(string $pattern, ?string $message = null): void
  {
    $this->assert("assertMatches", "assertNotMatches", $this->value, $pattern, $message);
  }

  public function toBeEmail(?string $message = null): void
  {
    $this->assert("assertEmail", "assertNotEmail", $this->value, $message);
  }

  // ===== ===== ===== ===== =====
  // ARRAYS
  // ===== ===== ===== ===== =====

  public function toContain(mixed $element, ?string $message = null)
  {
    $this->assert("assertContains", "assertNotContains", $this->value, $element, $message);
  }

  public function toHaveKey(int|string $key, ?string $message = null)
  {
    $this->assert("assertHasKey", "assertNotHasKey", $this->value, $key, $message);
  }

  public function toHaveCount(int $count, ?string $message = null)
  {
    $this->assert("assertCount", "assertNotCount", $this->value, $count, $message);
  }

  // ===== ===== ===== ===== =====
  // INTERNAL
  // ===== ===== ===== ===== =====

  protected function assert(string $method, string $opposite, mixed ...$args): void
  {
    if ($this->useTrue) {
      $this->testSuite->{$method}(...$args);
      return;
    }

    $this->testSuite->{$opposite}(...$args);
  }
}