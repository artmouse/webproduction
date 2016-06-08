<?php
/**
* PHP implementation of Douglas Crockford's JSMin.
*
* This is pretty much a direct port of jsmin.c to PHP with just a few
* PHP-specific performance tweaks. Also, whereas jsmin.c reads from stdin and
* outputs to stdout, this library accepts a string as input and returns another
* string as output.
*
* PHP 5 or higher is required.
*
* Permission is hereby granted to use this version of the library under the
* same terms as jsmin.c, which has the following license:
*
* --
* Copyright (c) 2002 Douglas Crockford (www.crockford.com)
*
* Permission is hereby granted, free of charge, to any person obtaining a copy of
* this software and associated documentation files (the "Software"), to deal in
* the Software without restriction, including without limitation the rights to
* use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
* of the Software, and to permit persons to whom the Software is furnished to do
* so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* The Software shall be used for Good, not Evil.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN _action OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
* SOFTWARE.
* --
*
* @package   JSMin
* @author    Ryan Grove <ryan@wonko.com>
* @copyright 2002 Douglas Crockford <douglas@crockford.com> (jsmin.c)
* @copyright 2008 Ryan Grove <ryan@wonko.com> (PHP port)
* @license   http://opensource.org/licenses/mit-license.php MIT License
* @version   1.1.1 (2008-03-02)
* @link      http://code.google.com/p/jsmin-php/
*/

class JSMin {
    const ORD_LF = 10;
    const ORD_SPACE = 32;

    protected $a = '';
    protected $b = '';
    protected $input = '';
    protected $inputIndex = 0;
    protected $inputLength = 0;
    protected $lookAhead = null;
    protected $output = '';

    // -- Public Static Methods --------------------------------------------------

    public static function Minify($js) {
        $jsmin = new JSMin($js);
        return $jsmin->_min();
    }

    // -- Public Instance Methods ------------------------------------------------

    public function __construct($input) {
        $this->input = str_replace("\r\n", "\n", $input);
        $this->inputLength = strlen($this->input);
    }

    // -- Protected Instance Methods ---------------------------------------------

    protected function _action($d) {
        switch($d) {
            case 1:
                $this->output .= $this->a;

            case 2:
                $this->a = $this->b;

                if ($this->a === "'" || $this->a === '"') {
                    for (;;) {
                        $this->output .= $this->a;
                        $this->a = $this->_get();

                        if ($this->a === $this->b) {
                            break;
                        }

                        if (ord($this->a) <= self::ORD_LF) {
                            throw new Exception('Unterminated string literal.');
                        }

                        if ($this->a === '\\') {
                            $this->output .= $this->a;
                            $this->a = $this->_get();
                        }
                    }
                }

            case 3:
                $this->b = $this->_next();

                if ($this->b === '/' && (
                $this->a === '(' || $this->a === ',' || $this->a === '=' ||
                $this->a === ':' || $this->a === '[' || $this->a === '!' ||
                $this->a === '&' || $this->a === '|' || $this->a === '?')) {

                    $this->output .= $this->a . $this->b;

                    for (;;) {
                        $this->a = $this->_get();

                        if ($this->a === '/') {
                            break;
                        } elseif ($this->a === '\\') {
                            $this->output .= $this->a;
                            $this->a = $this->_get();
                        } elseif (ord($this->a) <= self::ORD_LF) {
                            throw new Exception('Unterminated regular expression literal.');
                        }

                        $this->output .= $this->a;
                    }

                    $this->b = $this->_next();
                }
        }
    }

    protected function _get() {
        $c = $this->lookAhead;
        $this->lookAhead = null;

        if ($c === null) {
            if ($this->inputIndex < $this->inputLength) {
                $c = substr($this->input, $this->inputIndex, 1);
                $this->inputIndex += 1;
            } else {
                $c = null;
            }
        }

        if ($c === "\r") {
            return "\n";
        }

        if ($c === null || $c === "\n" || ord($c) >= self::ORD_SPACE) {
            return $c;
        }

        return ' ';
    }

    protected function _isAlphaNum($c) {
        return ord($c) > 126 || $c === '\\' || preg_match('/^[\w\$]$/', $c) === 1;
    }

    protected function _min() {
        $this->a = "\n";
        $this->_action(3);

        while ($this->a !== null) {
            switch ($this->a) {
                case ' ':
                    if ($this->_isAlphaNum($this->b)) {
                        $this->_action(1);
                    } else {
                        $this->_action(2);
                    }
                    break;

                case "\n":
                    switch ($this->b) {
                        case '{':
                        case '[':
                        case '(':
                        case '+':
                        case '-':
                            $this->_action(1);
                            break;

                        case ' ':
                            $this->_action(3);
                            break;

                        default:
                            if ($this->_isAlphaNum($this->b)) {
                                $this->_action(1);
                            } else {
                                $this->_action(2);
                            }
                    }
                    break;

                default:
                    switch ($this->b) {
                        case ' ':
                            if ($this->_isAlphaNum($this->a)) {
                                $this->_action(1);
                                break;
                            }

                            $this->_action(3);
                            break;

                        case "\n":
                            switch ($this->a) {
                                case '}':
                                case ']':
                                case ')':
                                case '+':
                                case '-':
                                case '"':
                                case "'":
                                    $this->_action(1);
                                    break;

                                default:
                                    if ($this->_isAlphaNum($this->a)) {
                                        $this->_action(1);
                                    } else {
                                        $this->_action(3);
                                    }
                            }
                            break;

                        default:
                            $this->_action(1);
                            break;
                    }
            }
        }

        return $this->output;
    }

    protected function _next() {
        $c = $this->_get();

        if ($c === '/') {
            switch($this->_peek()) {
                case '/':
                    for (;;) {
                        $c = $this->_get();

                        if (ord($c) <= self::ORD_LF) {
                            return $c;
                        }
                    }

                case '*':
                    $this->_get();

                    for (;;) {
                        switch($this->_get()) {
                            case '*':
                                if ($this->_peek() === '/') {
                                    $this->_get();
                                    return ' ';
                                }
                                break;

                            case null:
                                throw new Exception('Unterminated comment.');
                        }
                    }

                default:
                    return $c;
            }
        }

        return $c;
    }

    protected function _peek() {
        $this->lookAhead = $this->_get();
        return $this->lookAhead;
    }

}