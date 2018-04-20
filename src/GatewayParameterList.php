<?php

/*
 * Copyright notice:
 * (c) Copyright 2017 RocketGate
 * All rights reserved.
 *
 * The copyright notice must not be removed without specific, prior
 * written permission from RocketGate.
 *
 * This software is protected as an unpublished work under the U.S. copyright
 * laws. The above copyright notice is not intended to effect a publication of
 * this work.
 * This software is the confidential and proprietary information of RocketGate.
 * Neither the binaries nor the source code may be redistributed without prior
 * written permission from RocketGate.
 *
 * The software is provided "as-is" and without warranty of any kind, express, implied
 * or otherwise, including without limitation, any warranty of merchantability or fitness
 * for a particular purpose.  In no event shall RocketGate be liable for any direct,
 * special, incidental, indirect, consequential or other damages of any kind, or any damages
 * whatsoever arising out of or in connection with the use or performance of this software,
 * including, without limitation, damages resulting from loss of use, data or profits, and
 * whether or not advised of the possibility of damage, regardless of the theory of liability.
 *
 */

namespace RocketGate\Sdk;

class GatewayParameterList extends GatewayAbstract
{
    /**
     * @var array
     */
    public $params;

    /**
     * GatewayParameterList constructor.
     */
    public function __construct()
    {
        $this->params = [];
    }

    public function reset()
    {
        $this->params = [];
    }

    /**
     * Return the value associated with a key.
     *
     * @param $key
     *
     * @return mixed|null|string
     */
    public function get(string $key)
    {
        return isset($this->params[$key]) ? trim($this->params[$key]) : null;
    }

    /**
     * Set the value associated with a key.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function set(string $key, $value)
    {
        $this->clear($key);
        if (is_float($value)) {
            $value = str_replace(',', '.', (string) $value);
        }
        $this->params[$key] = $value;
    }

    /**
     * Remove a key value.
     *
     * @param $key
     *
     * @return mixed|null|string
     */
    public function clear($key)
    {
        if (isset($this->params[$key])) {
            unset($this->params[$key]);
        }
    }

    /**
     * Dump the contents of the object for debugging.
     */
    public function debugPrint()
    {
        print_r($this->params);
    }
}
