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

namespace Paysafe;

abstract class PageratorAbstract implements \Iterator
{
    /**
	 * Tracks the current position in the result set.
	 *
	 * @var int
	 */
    private $position = 0;

    /**
	 * The result set so far retrieved.
	 *
	 * @var array of type $className
	 */
    protected $results = array();

    /**
	 * The key in the returned array to be added to the result set
	 *
	 * @var string
	 */
    protected $arrayKey = null;

    /**
	 * The class name to instantiate for each result in the response
	 *
	 * @var string
	 */
    protected $className = null;

    /**
	 * The link to the next page, if we haven't yet retrieved all results
	 * @var \Paysafe\Link
	 */
    protected $nextPage = null;

    /**
	 *
	 * @var PaysafeApiClient
	 */
    private $client = null;

    /**
	 * Instantiate the pagerator.
	 *
	 * @param \Paysafe\PaysafeApiClient $client
	 * @param array $data
	 * @param string $className
	 * @throws PaysafeException
	 */
    public function __construct(\Paysafe\PaysafeApiClient $client, $data, $className)
    {
        if (!in_array('Paysafe\Pageable', class_implements($className))) {
            throw new PaysafeException("$className does not implement \Paysafe\Pageable");
        }

        $this->client = $client;

        $this->className = $className;
        $this->arrayKey = call_user_func($className . '::getPageableArrayKey');
        $this->position = 0;

        $this->parseResponse($data);
    }

    /**
	 * Get the result set that has been retrieved so far.
	 *
	 * @return array
	 */
    public function getResults()
    {
        return $this->results;
    }

    /**
	 * Get the current element.
	 *
	 * @return mixed
	 */
    public function current()
    {
        if (array_key_exists($this->position, $this->results)) {
            return $this->results[$this->position];
        }
    }

    /**
	 * Get the current position.
	 *
	 * @return int
	 */
    public function key()
    {
        return $this->position;
    }

    /**
	 * Go to the next element
	 */
    public function next()
    {
        $this->position++;
        if (!$this->valid() && $this->nextPage) {
            $request = new \Paysafe\Request($this->nextPage);
            $this->nextPage = null;
            $response = $this->client->processRequest($request);
            $this->parseResponse($response);
        }
    }

    /**
	 * Go to the begining
	 */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
	 * Check that the current position is valid.
	 *
	 * @return bool
	 */
    public function valid()
    {
        return array_key_exists($this->position, $this->results);
    }

    /**
	 * Parse the response for the result set and next page.
	 *
	 * @param array $data
	 */
    abstract protected function parseResponse($data);

}
