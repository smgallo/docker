<?php
/**
 * File ComplexTest.php
 * Created at: 2015-03-22 19-39
 *
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */

namespace Webit\Math\ComplexNumber\Tests;

use Webit\Math\ComplexNumber\Complex;

class ComplexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param Complex $complex1
     * @param Complex $complex2
     * @param Complex $expectedResult
     * @test
     * @dataProvider getAdditionData
     */
    public function shouldSupportAddition(Complex $complex1, Complex $complex2, Complex $expectedResult)
    {
        $result = $complex1->add($complex2);
        $this->assertEquals($expectedResult, $result);
    }

    public function getAdditionData()
    {
        return array(
            array(new Complex(0, 0), new Complex(0, 0), new Complex(0, 0)),
            array(new Complex(5.25, -4.25), new Complex(1.25, 1.50), new Complex(6.5, -2.75))
        );
    }

    /**
     * @param Complex $complex1
     * @param Complex $complex2
     * @param Complex $expectedResult
     * @test
     * @dataProvider getSubtractionData
     */
    public function shouldSupportSubtraction(Complex $complex1, Complex $complex2, Complex $expectedResult)
    {
        $result = $complex1->sub($complex2);
        $this->assertEquals($expectedResult, $result);
    }

    public function getSubtractionData()
    {
        return array(
            array(new Complex(0, 0), new Complex(0, 0), new Complex(0, 0)),
            array(new Complex(5.25, -4.25), new Complex(1.25, 1.50), new Complex(4, -5.75))
        );
    }

    /**
     * @param Complex $complex1
     * @param Complex $complex2
     * @param Complex $expectedResult
     * @test
     * @dataProvider getMultiplicationData
     */
    public function shouldSupportMultiplication(Complex $complex1, Complex $complex2, Complex $expectedResult)
    {
        $result = $complex1->mul($complex2);
        $this->assertEquals($expectedResult, $result);
    }

    public function getMultiplicationData()
    {
        return array(
            array(new Complex(0, 0), new Complex(0, 0), new Complex(0, 0)),
            array(new Complex(2, -5), new Complex(3, 9), new Complex(51, 3)),
            array(new Complex(-2.55, 5.23), new Complex(5.44, -7.12), new Complex(23.3656, 46.6072))
        );
    }

    /**
     * @param Complex $complex1
     * @param Complex $expectedResult
     * @param float $precision
     * @test
     * @dataProvider getSquareRootData
     */
    public function shouldSupportSquareRoot(Complex $complex1, Complex $expectedResult, $precision)
    {
        $result = $complex1->sqrt();
        if ($precision) {
            $realDiff = abs($expectedResult->getReal() - round($result->getReal(), 8));
            $imaginaryDiff = abs($expectedResult->getImaginary() - round($result->getImaginary(), 8));
            $this->assertLessThanOrEqual($precision, $realDiff);
            $this->assertLessThanOrEqual($precision, $imaginaryDiff);

            return;
        }

        $this->assertEquals($expectedResult->getReal(), round($result->getReal(), 8));
        $this->assertEquals($expectedResult->getImaginary(), round($result->getImaginary(), 8));
    }

    public function getSquareRootData()
    {
        return array(
            array(new Complex(0, 0), new Complex(0, 0), 0),
            array(new Complex(4, 2), new Complex(2.05817102, 0.48586827), 0.0000001),
            array(new Complex(2, 4), new Complex(1.79890743, 1.11178594), 0.0000001),
            array(new Complex(-2, 4), new Complex(1.11178594, 1.79890743), 0.0000001),
            array(new Complex(-2, -4), new Complex(1.11178594, -1.79890743), 0.0000001)
        );
    }

    /**
     * @param Complex $complex
     * @param $expectedValue
     * @test
     * @dataProvider getAbsoluteData
     */
    public function shouldSupportAbsolute(Complex $complex, $expectedValue)
    {
        $result = $complex->abs();
        $this->assertEquals($expectedValue, $result);
    }

    public function getAbsoluteData()
    {
        return array(
            array(new Complex(0, 0), 0),
            array(new Complex(0, 5), 5),
            array(new Complex(0, -5), 5),
            array(new Complex(3, 0), 3),
            array(new Complex(-3, 0), 3),
            array(new Complex(-3, 4), 5),
            array(new Complex(4, -3), 5),
        );
    }

    /**
     * @param Complex $complex
     * @param Complex $expectedResult
     * @test
     * @dataProvider getConjugationData
     */
    public function shouldSupportConjugation(Complex $complex, Complex $expectedResult)
    {
        $result = $complex->getConjugated();
        $this->assertEquals($expectedResult, $result);
    }

    public function getConjugationData()
    {
        return array(
            array(new Complex(0, 0), new Complex(0, 0)),
            array(new Complex(2, 2), new Complex(2, -2)),
            array(new Complex(2, -2), new Complex(2, 2)),
            array(new Complex(-2, 2), new Complex(-2, -2)),
            array(new Complex(-2, -2), new Complex(-2, 2))
        );
    }

    /**
     * @param Complex $complex
     * @param $scalar
     * @param Complex $expectedResult
     * @test
     * @dataProvider getScalarMultiplicationData
     */
    public function shouldSupportScalarMultiplication(Complex $complex, $scalar, Complex $expectedResult)
    {
        $result = $complex->mulScalar($scalar);
        $this->assertEquals($expectedResult, $result);
    }

    public function getScalarMultiplicationData()
    {
        return array(
            array(new Complex(0, 0), 5, new Complex(0, 0)),
            array(new Complex(3, -1), 5, new Complex(15, -5)),
            array(new Complex(3, -1), -5, new Complex(-15, 5)),
        );
    }

    /**
     * @param Complex $complex1
     * @param Complex $complex2
     * @param Complex $expectedResult
     * @test
     * @dataProvider getDividingData
     */
    public function shouldSupportDividing(Complex $complex1, Complex $complex2, Complex $expectedResult)
    {
        $result = $complex1->div($complex2);
        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function getDividingData()
    {
        return array(
            array(new Complex(0, 0), new Complex(2, 1), new Complex(0, 0)),
            array(new Complex(3, 2), new Complex(2, 1), new Complex(1.6, 0.2))
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function shouldThrowExceptionOnDividingByZero()
    {
        $complex = new Complex(3, 3);
        $complex->div(new Complex(0, 0));
    }

    /**
     * @param Complex $complex
     * @param $expectedString
     * @test
     * @dataProvider getStringCastingData
     */
    public function shouldBeAbleToCastToString(Complex $complex, $expectedString)
    {
        $this->assertEquals($expectedString, (string) $complex);
    }

    public function getStringCastingData()
    {
        return array(
            array(new Complex(0, 0), '0+0i'),
            array(new Complex(3, 5), '3+5i'),
            array(new Complex(-3, -5), '-3-5i'),
            array(new Complex(1.25,-5.67), '1.25-5.67i'),
        );
    }
}
