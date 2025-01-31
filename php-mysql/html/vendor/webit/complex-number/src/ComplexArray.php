<?php
/**
 * File ComplexArray.php
 * Created at: 2015-03-23 16-25
 *
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */

namespace Webit\Math\ComplexNumber;

class ComplexArray implements \IteratorAggregate, \Countable, \ArrayAccess
{
    /**
     * @var array
     */
    private $items = array();

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        ksort($items);
        foreach ($items as &$element) {
            if (! ($element instanceof Complex)) {
                $element = new Complex($element, 0);
            }
        }

        $this->items = array_values($items);
    }

    /**
     * @param array $items
     * @return ComplexArray
     */
    public static function create(array $items)
    {
        return new self($items);
    }

    /**
     * @param ComplexArray $complexArray
     * @return ComplexArray
     */
    public function merge(ComplexArray $complexArray)
    {
        return new ComplexArray(array_merge($this->items, $complexArray->items));
    }

    /**
     * @param int $i
     * @return Complex
     */
    public function getItem($i)
    {
        return isset($this->items[$i]) ? $this->items[$i] : null;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return \Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return Complex
     */
    public function offsetGet($offset)
    {
        return $this->getItem($offset);
    }

    /**
     * ComplexArray is immutable
     * @throws \LogicException
     */
    public function offsetSet($offset, $value)
    {
        throw new \LogicException('Can not set new value as long as ComplexArray is immutable.');
    }

    /**
     * ComplexArray is immutable
     * @throws \LogicException
     */
    public function offsetUnset($offset)
    {
        throw new \LogicException('Can not unset value as long as ComplexArray is immutable.');
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->items);
    }
}
