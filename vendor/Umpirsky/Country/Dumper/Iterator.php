<?php


/**
 * This file is part of the Country List project.
 *
 *  (c) Саша Стаменковић <umpirsky@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Umpirsky\Country\Dumper;

use Symfony\Component\Finder\Finder;

/**
 * Iterates through various dumper formats.
 *
 * @author Саша Стаменковић <umpirsky@gmail.com>
 */
class Iterator implements \Iterator {

    protected $dumpers;

    public function __construct() {

        $finder = new Finder();
        $iterator = $finder
            ->files()
            ->name('*.php')
            ->depth(0)
            ->in(__DIR__ . '/Format');

        $this->dumpers = array();
        foreach ($iterator as $file) {
            $dumperClassName = '\\Umpirsky\\Country\\Dumper\\Format\\' . strstr($file->getFilename(), '.', true);
            $this->attach(new $dumperClassName());
        }

        $this->rewind();
    }

    public function attach($dumper) {
        $this->dumpers[] = $dumper;
    }

    public function rewind() {
        reset($this->dumpers);
    }

    public function valid() {
        return false !== $this->current();
    }

    public function next() {
        next($this->dumpers);
    }

    public function current() {
        return current($this->dumpers);
    }

    public function key() {
        return key($this->dumpers);
    }
}
