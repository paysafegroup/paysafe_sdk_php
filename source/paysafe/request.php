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

/**
 * @property uri $uri
 * @property string $method
 * @property \Paysafe\JSONObject $body
 * @property array $queryStr
 */
class Request implements \ArrayAccess
{
    const POST = 'POST';
    const GET = 'GET';
    const DELETE = 'DELETE';
    const PUT = 'PUT';

    /**
	 * Stores the data to be submitted by the paysafe api client.
	 *
	 * @var array
	 */
    protected $request = array(
         'uri' => '',
         'method' => self::GET,
         'body' => null,
         'queryStr' => array(),
         'url' => null
    );

    /**
	 * Build url for the paysafe api client.
	 *
	 * @param string $apiEndPoint
	 * @return string
	 * @throws PaysafeException if the url has been set, and does not match the endpoint.
	 */
    public function buildUrl($apiEndPoint)
    {
        if (is_null($this->request['url'])) {
            return $apiEndPoint . '/' . $this->uri . ($this->queryStr ? '?' . http_build_query($this->queryStr) : '');
        }
        if (strpos($this->url, $apiEndPoint) !== 0) {
            throw new PaysafeException('Unexpected endpoint in url: ' . $this->url . ' expected: ' . $apiEndPoint);
        }
        return $this->url;
    }

    /**
	 * Initialize the request.
	 *
	 * @param \Paysafe\Link $options
	 * @throws PaysafeException
	 */
    public function __construct($options)
    {
        if(is_array($options)) {
            if (array_diff_key($options, $this->request)) {
                throw new PaysafeException('Invalid request parameters. Expected only ' . join(', ', array_keys($this->request)));
            }

            foreach ($options as $key => $val) {
                $this->$key = $val;
            }
        } elseif($options instanceof Link) {
            $this->request['url'] = $options->href;
        }
    }

    /**
	 * Magic getter for uri/method/body/queryStr/url.
	 *
	 * @param string $name
	 * @return mixed
	 */
    public function __get($name)
    {
        if (array_key_exists($name, $this->request)) {
            return $this->request[$name];
        }
    }

    /**
	 * Magic setter for uri/method/body/queryStr/url.
	 *
	 * @param string $name
	 * @param mixed $value
	 * @throws PaysafeException
	 */
    public function __set($name, $value)
    {
        if(!empty($this->request['url'])) {
            throw new PaysafeException('You may not update a request created from an Paysafe\Link.');
        }
        if (array_key_exists($name, $this->request)) {
            switch ($name) {
                case 'uri':
                    if (!is_string($value)) {
                        throw new PaysafeException('Invalid parameter uri. String expected.');
                    }
                    break;
                case 'method':
                    if (!in_array($value, array(self::POST, self::GET, self::DELETE, self::PUT))) {
                        throw new PaysafeException('Invalid paramter method.');
                    }
                    break;
                case 'body':
                    if (!($value instanceof JSONObject)) {
                        throw new PaysafeException('Invalid parameter body. JSONObject expected.');
                    }
                    break;
                case 'queryStr':
                    if (!is_array($value)) {
                        throw new PaysafeException('Invalid parameter queryStr. Array expected.');
                    }
                    break;
            }
            $this->request[$name] = $value;
        }
    }

    /**
	 * Magic isseter for uri/method/body/queryStr/url.
	 * @param string $name
	 * @return bool
	 */
    public function __isset($name)
    {
        return isset($this->request[$name]);
    }

    /**
	 * Magic issetter for $this->body->{$offset}.
	 * @param string $offset
	 * @return bool
	 */
    public function offsetExists($offset)
    {
        return isset($this->body->$offset);
    }

    /**
	 * Magic setter for $this->body->{$offset}.
	 * @param string $offset
	 * @param bool $value
	 */
    public function offsetSet($offset, $value)
    {
        $this->body->$offset = $value;
    }

    /**
	 * Magic getter for $this->body->{$offset}.
	 * @param string $offset
	 * @return mixed
	 */
    public function offsetGet($offset)
    {
        return $this->body->$offset;
    }

    /**
	 * Magic unsetter for $this->body->{$offset}.
	 * @param string $offset
	 */
    public function offsetUnset($offset)
    {
        unset($this->body->$offset);
    }

}
