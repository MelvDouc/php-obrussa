<?php

namespace MelvDouc\Obrussa\Utils;

class Colorizer
{
  protected const FG_BOLD = 1;
  protected const FG_BLACK = 30;
  protected const FG_RED = 31;
  protected const FG_GREEN = 32;
  protected const FG_YELLOW = 33;
  protected const FG_BLUE = 34;
  protected const FG_MAGENTA = 35;
  protected const FG_CYAN = 36;
  protected const FG_LIGHT_GRAY = 37;
  protected const FG_DARK_GRAY = 90;

  public static function bold(string $message): string
  {
    return static::colorize(static::FG_BOLD, $message);
  }

  public static function red(string $message): string
  {
    return static::colorize(static::FG_RED, $message);
  }

  public static function green(string $message): string
  {
    return static::colorize(static::FG_GREEN, $message);
  }

  public static function yellow(string $message): string
  {
    return static::colorize(static::FG_YELLOW, $message);
  }

  public static function blue(string $message): string
  {
    return static::colorize(static::FG_BLUE, $message);
  }

  public static function magenta(string $message): string
  {
    return static::colorize(static::FG_MAGENTA, $message);
  }

  public static function cyan(string $message): string
  {
    return static::colorize(static::FG_CYAN, $message);
  }

  public static function lightGray(string $message): string
  {
    return static::colorize(static::FG_LIGHT_GRAY, $message);
  }

  public static function darkGray(string $message): string
  {
    return static::colorize(static::FG_DARK_GRAY, $message);
  }

  protected static function colorize(int $color, string $message): string
  {
    return "\033[$color" . "m" . $message . "\033[0m";
  }
}