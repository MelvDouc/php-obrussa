<?php

namespace MelvDouc\Obrussa\Exception;

/**
 * @template T
 */
class AssertionException extends \Exception
{
  /**
   * @var T
   */
  private readonly mixed $expected;
  /**
   * @var T
   */
  private readonly mixed $actual;

  /**
   * @param T $expected
   * @param T $actual
   * @param string|null $message
   */
  public function __construct($expected, $actual, ?string $message)
  {
    parent::__construct($message ?? json_encode(["actual" => $actual, "expected" => $expected], JSON_UNESCAPED_SLASHES));
    $this->expected = $expected;
    $this->actual = $actual;
  }

  /**
   * @return T
   */
  public function getExpected()
  {
    return $this->expected;
  }

  /**
   * @return T
   */
  public function getActual()
  {
    return $this->actual;
  }
}