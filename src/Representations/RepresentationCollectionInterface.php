<?php
namespace Scito\Keycloak\Admin\Representations;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Iterator;

/**
 * Interface RepresentationCollectionInterface
 * @package Keycloak\Admin\Representations
 * @template <T> The type of the individual elements
 */
interface RepresentationCollectionInterface extends Countable, IteratorAggregate, ArrayAccess
{
    /**
     * @param callable $filter
     * @return RepresentationCollectionInterface
     */
    public function filter(callable $filter);
    /**
     * @param callable $callback
     * @return RepresentationCollectionInterface
     */
    public function map(callable $callback);

    /**
     * @return Iterator<T>
     */
    public function getIterator();

    public function toArray();

    /**
     * @param callable|null $callback
     * @param bool $default
     * @return T
     */
    public function first(?callable $callback = null, $default = false);
}
