<?php

    /*
     * Copyright (c) 2014 OptimalPayments
     *
     * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
     * associated documentation files (the "Software"), to deal in the Software without restriction,
     * including without limitation the rights to use, copy, modify, merge, publish, distribute,
     * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     *
     * The above copyright notice and this permission notice shall be included in all copies or
     * substantial portions of the Software.
     *
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
     * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
     * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM,
     * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
     */

    namespace Paysafe\DirectDebit;

    class Pagerator extends \Paysafe\PageratorAbstract {

        /**
         * Parse the response for the result set and next page.
         *
         * @param type $data
         * @throws PaysafeException
         */
        protected function parseResponse( $data ) {
            if (!array_key_exists($this->arrayKey, $data)) {
                throw new \Paysafe\PaysafeException('Missing array key from results');
            }
            foreach ($data[$this->arrayKey] as $row) {
                array_push($this->results, new $this->className($row));
            }

            $this->nextPage = null;

            if (array_key_exists('links', $data)) {
                foreach ($data['links'] as $link) {
                    if ($link['rel'] == 'next') {
                        $this->nextPage = new \Paysafe\Link($link);
                    }
                }
            }
        }
    }
