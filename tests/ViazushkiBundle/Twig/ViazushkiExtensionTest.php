<?php

namespace Tests\ViazushkiBundle\Twig;

use PHPUnit\Framework\TestCase;
use ViazushkiBundle\Twig\ViazushkiExtension;

class ViazushkiExtensionTest extends TestCase
{
    public function testModifyDate()
    {
        // arrange
        $extension = new ViazushkiExtension();

        // act
        $result = $extension->modifyDate("2018-03-21", "+ 2 day");

        // assert
        $this->assertSame("2018-03-23", $result);
    }

    /**
     * @dataProvider calculatorDataProvider
     *
     * @param string $first
     * @param string $second
     * @param string $expectedResult
     */
    public function testAddWidthDataProvider($first, $second, $expectedResult)
    {
        $extension = new ViazushkiExtension();
        $result = $extension->modifyDate($first, $second);
        $this->assertSame($expectedResult, $result);
    }
    /**
     * @return array
     */
    public function calculatorDataProvider()
    {
        return [
            ["2018-03-21", "+ 2 day", "2018-03-23"],
            ["2018-03-01", "+ 30 day", "2018-03-31"],
            ["2018-03-01", "+ 31 day", "2018-04-01"],
        ];
    }

    /**
     * @dataProvider notValidParametersProvider
     * @expectedException \InvalidArgumentException
     *
     * @param string $first
     * @param string $second
     */
    public function testAddExceptionIfParametersIsNotString($first, $second)
    {
        $extension = new ViazushkiExtension();
        $extension->modifyDate($first, $second);
    }

    /**
     * @return array
     */
    public function notValidParametersProvider()
    {
        return [
            ["2018-03-21", null],
            ["2018-03-01", "30 day"],
            ["2018/03/01", "+ 30 day"],
            [["2018-03-01"], "+ 31 day"],
            [true, "+ 31 day"],
            [true, ""],
        ];
    }

    /**
     * @dataProvider notValidParametersProvider
     *
     * @param string $first
     * @param string $second
     */
    public function testAddExceptionIfParametersIsNotStringWithExpectException($first, $second)
    {
        $extension = new ViazushkiExtension();
        $this->expectException(\InvalidArgumentException::class);
        $extension->modifyDate($first, $second);
    }
}
