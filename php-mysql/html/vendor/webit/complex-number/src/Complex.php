<?php
namespace Webit\Math\ComplexNumber;

/**
 * @author Daniel Bojdo<daniel.bojdo@web-it.eu>
 */
class Complex
{

    /**
     * @var float
     */
	private $real;

    /**
     * @var float
     */
	private $imaginary;
	
	/**
	 * @param float $real
	 * @param float $imaginary
	 */
	public function __construct($real, $imaginary) {
		$this->real = $real;
		$this->imaginary = $imaginary;
	}

    /**
     * @return float
     */
    public function getReal() {
        return $this->real;
    }

    /**
     * @return float
     */
    public function getImaginary() {
        return $this->imaginary;
    }

    /**
     * @param Complex $complex
     * @return Complex
     */
    public function add(Complex $complex) {
        return new static(
            $this->getReal() + $complex->getReal(),
            $this->getImaginary() + $complex->getImaginary()
        );
    }

    /**
     * @param Complex $complex
     * @return Complex
     */
    public function sub(Complex $complex) {
        return new static(
            $this->getReal() - $complex->getReal(),
            $this->getImaginary() - $complex->getImaginary()
        );
    }

    /**
     * @param Complex $complex
     * @return Complex
     */
    public function mul(Complex $complex)
    {
        $real = $this->getReal() * $complex->getReal() - $this->getImaginary() * $complex->getImaginary();
        $imaginary = $this->getImaginary() * $complex->getReal() + $this->getReal() * $complex->getImaginary();

        return new static($real, $imaginary);
    }

    /**
     * @param Complex $complex
     * @return Complex
     */
    public function div(Complex $complex)
    {
        $denominator = (pow($complex->getReal(), 2) + pow($complex->getImaginary(), 2));
        if ($denominator == 0) {
            throw new \InvalidArgumentException('Can not divide be 0.');
        }

        $real = ($this->getReal() * $complex->getReal() + $this->getImaginary() * $complex->getImaginary()) / $denominator;
        $imaginary = ($this->getImaginary() * $complex->getReal() - $this->getReal() * $complex->getImaginary()) / $denominator;

        return new Complex($real, $imaginary);
    }

    /**
     * @return ComplexSqrt
     */
    public function sqrt()
    {
        if ($this->getImaginary() == 0) {
            return new Complex(sqrt($this->getReal()), 0);
        }

        $x = $this->getReal();
        $y = $this->getImaginary();

        $delta = pow($x, 2) + pow($y, 2);
        $sgn = $y >= 0 ? 1 : -1;

        $real = sqrt(($x + sqrt($delta)) / 2);
        $imaginary = $sgn * sqrt((sqrt($delta) - $x) / 2);

        return new Complex($real, $imaginary);
    }

    /**
     * @return float
     */
    public function abs()
    {
        $x = abs($this->getReal());
        $y = abs($this->getImaginary());

        if ($x == 0 || $y == 0) {
            return max($x, $y);
        }

        return sqrt(pow($x, 2) + pow($y, 2));
    }

    /**
     * @return Complex
     */
    public function getConjugated()
    {
        return new Complex(
            $this->getReal(),
            -$this->getImaginary()
        );
    }

    /**
     * @param float $scalar
     * @return Complex
     */
    public function mulScalar($scalar)
    {
        return new Complex(
            $this->getReal() * $scalar,
            $this->getImaginary() * $scalar
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s%s%si', $this->getReal(), ($this->getImaginary() >= 0 ? '+' : ''), $this->getImaginary());
    }
}
