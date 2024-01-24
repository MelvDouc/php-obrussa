<?php

require_once dirname(__DIR__) . "/vendor/autoload.php";

use MelvDouc\Obrussa\TestSuite;

function add(int $a, int $b): int
{
  return $a + $b;
}

TestSuite::test("1 + 1 = 2", function (TestSuite $testSuite) {
  $testSuite->assertEquals(add(1, 1), 2);
});

TestSuite::test("2 + 2 = 5", function (TestSuite $testSuite) {
  $testSuite->assert(add(2, 2) === 5, "2+2 is 4");
});

TestSuite::test("2 + 2 != 22", function (TestSuite $testSuite) {
  $result = add(2, 2);
  $testSuite->expect($result)->toBeGreaterThan(3.9);
  $testSuite->expect($result)->not()->toEqual(22);
});

TestSuite::test("arrays", function (TestSuite $testSuite) {
  $arr = [1, 2, 3];
  $testSuite->assertTruthy($arr);
  $testSuite->assertType($arr, gettype([]));
  $testSuite->expect($arr)->toHaveCount(3);
  $testSuite->expect($arr)->not()->toContain(0);
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