# Web-IT Complex Number

Object wrapper for Complex Number. Provides immutable Complex and ComplexArray classes.
Supports operations like: adding, subtraction, multiplication, dividing, square root, absolute and multiplication by scalar value.

## Installation
### via Composer

Add the **webit/complex-number** into **composer.json**

```json
{
    "require": {
        "php": ">=5.3.2",
        "webit/complex-number": "~1.0"
    }
}
```

## Usage

```php
$num1 = new Complex(1, 3); // (real, imaginary)
// or
$num2 = Complex::create(5, 5);

$sum = $num1->add($num2);
$diff = $num1->sub($num2);
$prod = $num1->mul($num2);
$quot = $num1->div($num2);
$sqrt = $num1->sqrt();
$abs = $num1->abs(); // scalar
$conjugated = $num1->getConjugated();

$complexArray1 = new ComplexArray(array(23.4, 23.55)); // accepts array of floats or array of Complex
// or
$complexArray2 = ComplexArray::create(array(23.4, 23.55));

foreach ($complexArray1 as $complex) {
    echo $complex ."\n";
}

```