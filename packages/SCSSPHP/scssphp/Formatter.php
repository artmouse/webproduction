<?php
/**
 * SCSSPHP
 *
 * @copyright 2012-2014 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/gpl-license GPL-3.0
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://leafo.net/scssphp
 */


/**
 * SCSS base formatter
 *
 * @author Leaf Corcoran <leafot@gmail.com>
 */
abstract class Formatter
{
    public $indentLevel;
    public $indentChar;
    public $break;
    public $open;
    public $close;
    public $tagSeparator;
    public $assignSeparator;

    protected function indentStr($n = 0)
    {
        return str_repeat($this->indentChar, max($this->indentLevel + $n, 0));
    }

    public function property($name, $value)
    {
        return $name . $this->assignSeparator . $value . ';';
    }

    protected function blockLines($inner, $block)
    {
        $glue = $this->break.$inner;
        echo $inner . implode($glue, $block->lines);

        if (!empty($block->children)) {
            echo $this->break;
        }
    }

    protected function block($block)
    {
        if (empty($block->lines) && empty($block->children)) {
            return;
        }

        $inner = $pre = $this->indentStr();

        if (!empty($block->selectors)) {
            echo $pre .
                implode($this->tagSeparator, $block->selectors) .
                $this->open . $this->break;
            $this->indentLevel++;
            $inner = $this->indentStr();
        }

        if (!empty($block->lines)) {
            $this->blockLines($inner, $block);
        }

        foreach ($block->children as $child) {
            $this->block($child);
        }

        if (!empty($block->selectors)) {
            $this->indentLevel--;

            if (empty($block->children)) {
                echo $this->break;
            }

            echo $pre . $this->close . $this->break;
        }
    }

    public function format($block)
    {
        ob_start();
        $this->block($block);
        $out = ob_get_clean();

        return $out;
    }
}
