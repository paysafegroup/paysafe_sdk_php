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

class JSONObject {

    protected static $fieldTypes = array();
    private $properties = array();
    private $optionalFields = array();
    private $requiredFields = array();

    /**
     *
     * @param array $fields
     * @throws PaysafeException
     */
    public function setOptionalFields($fields) {
        if (!is_array($fields)) {
            throw new PaysafeException('Invalid optional fields. Array expected.');
        }
        if (($diff = array_diff($fields, array_keys(static::$fieldTypes)))) {
            throw new PaysafeException('Invalid optional fields. Unknown fields: ' . join(', ', $diff));
        }

        $this->optionalFields = $fields;
    }

    /**
     *
     * @param array $fields
     * @throws PaysafeException
     */
    public function setRequiredFields($fields) {
        if (!is_array($fields)) {
            throw new PaysafeException('Invalid required fields. Array expected.');
        }
        if (($diff = array_diff($fields, array_keys(static::$fieldTypes)))) {
            throw new PaysafeException('Invalid required fields. Unknown fields: ' . join(', ', $diff));
        }

        $this->requiredFields = $fields;
    }

    /**
     *
     * @param array $params
     * @throws \Paysafe\PaysafeException
     * @throws PaysafeException
     */
    public function __construct($params = null) {
        if ($params == null) {
            $params = array();
        }
        foreach ($params as $key => $param) {
            if (array_key_exists($key, static::$fieldTypes)) {
                $this->$key = $param;
            }
        }
    }

    private function getFieldInfo($name) {
        if(array_key_exists($name, static::$fieldTypes)) {
            return array($name, static::$fieldTypes[$name]);
        }
        //the casing of field names is wrong sometimes
        $lowerName = strtolower($name);
        foreach (static::$fieldTypes as $key => $val) {
            if ($lowerName == strtolower($key)) {
                return array($key, $val);
            }
        }
        throw new PaysafeException("Invalid property $name for class " . get_class($this) . ".");
    }

    final public function __get($key) {
        list($name, $type) = $this->getFieldInfo($key);
        if (!array_key_exists($name, $this->properties)) {
            if (in_array($type, array(
                        'string',
                        'email',
                        'url',
                        'int',
                        'float',
                        'bool'
                    ))) {
                return null;
            } else {
                $this->$name = array();
            }
        }
        return $this->properties[$name];
    }

    final public function __set($key, $value) {
        list($name, $type) = $this->getFieldInfo($key);
        if (is_null($value)) {
            unset($this->properties[$name]);
        } else {
            $this->properties[$name] = $this->cast($name, $value, $type);
        }
    }

    final public function __unset($key) {
        list($name) = $this->getFieldInfo($key);
        if (array_key_exists($name, $this->properties)) {
            unset($this->properties);
        }
    }

    final public function __isset($key) {
        list($name) = $this->getFieldInfo($key);
        return array_key_exists($name, $this->properties);
    }

    private function cast($name, $value, $type) {
        if (is_array($type)) {
            if (!is_null($value) && !in_array($value, $type)) {
                throw new PaysafeException("Invalid value for property $name for class " . get_class($this) . ". Expected one of: " . join(', ', $type) . ".");
            }
            return $value;
        }
        if (strpos($type, 'array:') === 0) {
            $type = substr($type, strlen('array:'));
            if (!is_array($value)) {
                throw new PaysafeException("Invalid value for property $name for class " . get_class($this) . ". Array expected.");
            }
            foreach ($value as $key => $val) {
                $value[$key] = $this->cast($name, $val, $type);
            }
            return $value;
        }
        switch ($type) {
            case 'string':
                if (!is_scalar($value)) {
                    throw new PaysafeException("Invalid value for property $name for class " . get_class($this) . ". String expected.");
                }
                return strval($value);
            case 'email':
                $value = filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE);
                if (is_null($value)) {
                    throw new PaysafeException("Invalid value for property $name for class " . get_class($this) . ". Email expected.");
                }
                return $value;
            case 'url':
                $value = filter_var($value, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE);
                if (is_null($value)) {
                    throw new PaysafeException("Invalid value for property $name for class " . get_class($this) . ". URL expected.");
                }
                return $value;
            case 'int':
                $value = filter_var($value, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                if (is_null($value)) {
                    throw new PaysafeException("Invalid value for property $name for class " . get_class($this) . ". Integer expected.");
                }
                return $value;
            case 'float':
                $value = filter_var($value, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
                if (is_null($value)) {
                    throw new \Paysafe\PaysafeException("Invalid value for property $name for class " . get_class($this) . ". Float expected.");
                }
                return $value;
            case 'bool':
                //prevent old bug with filter_var
                if (empty($value) && !is_null($value)) {
                    return false;
                }
                $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                if (is_null($value)) {
                    throw new PaysafeException("Invalid value for property $name for class " . get_class($this) . ". Boolean expected.");
                }
                return $value;
            default:
                if (!$type) {
                    throw new \Paysafe\PaysafeException("Missing type for property $name for class " . get_class($this) . ".");
                }
                if (method_exists($this, "__validate_$name")) {
                    return $this->{"__validate_$name"}($value);
                } else {
                    return new $type($value);
                }
        }
    }

    /**
     *
     * @return json encoded copy of this object
     */
    public function toJson() {
        return json_encode($this->jsonSerialize());
    }

    /**
     *
     * @return array ready for serialization
     * @throws PaysafeException
     */
    final public function jsonSerialize() {
        $this->checkRequiredFields();
        if (!empty($this->requiredFields) || !empty($this->optionalFields)) {
            $fields = array_intersect_key($this->properties, array_flip(array_merge($this->requiredFields, $this->optionalFields)));
        } else {
            $fields = $this->properties;
        }

        return $this->filterJSON($fields);
    }

    public function checkRequiredFields() {
        if (($diff = array_diff($this->requiredFields, array_keys($this->properties)))) {
            throw new PaysafeException('Missing required properties: ' . join(', ', $diff), 500);
        }
    }

    private function filterJSON($result) {
        if (is_array($result)) {
            foreach ($result as &$var) {
                $var = $this->filterJSON($var);
            }
        } elseif ($result instanceof JSONObject) {
            return $result->jsonSerialize();
        }
        if ($result !== array()) {
            return $result;
        } else {
            return new \stdClass();
        }
    }

}
