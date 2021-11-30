<?php

namespace Openpay\Data;

abstract class OpenpayApiResourceBase
{

    protected $id;
    protected $parent;
    protected $resourceName = '';
    protected $serializableData;
    protected $noSerializableData;
    protected $derivedResources;

    protected function __construct($resourceName, $params = array()) {
        $this->resourceName = $resourceName;
        $this->serializableData = array();
        $this->noSerializableData = array();

        if (!is_array($params)) {
            throw new OpenpayApiError("Invalid parameter type detected when instantiating an Openpay resource (passed '".gettype($params)."', array expected)");
        }

        foreach ($params as $key => $value) {
            if ($key == 'id') {
                $this->id = $value;
                continue;
            }
            if ($key == 'parent') {
                $this->parent = $value;
                continue;
            }
            $this->serializableData[$key] = $value;
        }

        if ($derived = $this->derivedResources) {
            foreach ($derived as $k => $v) {
                $name = strtolower($k).'s';
                $this->derivedResources[$name] = $this->processAttribute($k, $v);

                // unsets the original attribute
                unset($this->derivedResources[$k]);
            }
        }
    }

    protected static function getInstance($resourceName, $props = null) {
        OpenpayApiConsole::trace('OpenpayApiResourceBase @getInstance > '.$resourceName);
        if (!class_exists($resourceName)) {
            throw new OpenpayApiError("Invalid Openpay resource type (class resource '".$resourceName."' is invalid)");
        }
        if (is_string($props)) {
            $props = array('id' => $props);
        } else if (!is_array($props)) {
            $props = array();
        }
        $resource = new $resourceName($resourceName, $props);
        return $resource;
    }

    // ---------------------------------------------------------
    // ------------------  PRIVATE FUNCTIONS  ------------------

    private function isList($var) {
        if (!is_array($var))
            return false;

        foreach (array_keys($var) as $k) {
            if (!is_numeric($k))
                return false;
        }
        return true;
    }

    private function processAttribute($k, $v) {
        OpenpayApiConsole::trace('OpenpayApiResourceBase @processAttribute > '.$k);
        $value = null;

        $resourceName = $this->getResourceName($k);
        if ($this->isResource($resourceName)) {
            // check is its a resource list
            if ($this->isList($v)) {
                $list = OpenpayApiDerivedResource::getInstance("Openpay\\Resources\\".$resourceName);
                $list->parent = $this;
                foreach ($v as $index => $objData) {
                    $list->add($objData);
                }
                $value = $list;
            } else {
                $resource = self::getInstance("Openpay\\Resources\\".$resourceName);
                $resource->parent = $this;
                $resource->refreshData($v);
                $value = $resource;

                if ($resourceName != $this->resourceName) {
                    $this->registerInParent($resource);
                }
            }
        } else {
            if (is_array($v)) {
                // if it's an array, then is an object an instance a standar class

                $object = new \stdClass();
                foreach ($v as $key => $value) {
                    $object->$key = $value;
                }
                $value = $object;
            } else {
                $value = $v;
            }
        }
        return $value;
    }

    private function getResourceName($name) {
        OpenpayApiConsole::trace('OpenpayApiResourceBase @getResourceName');
        if (substr($name, 0, strlen('Openpay')) == 'Openpay') {
            return $name;
        }
        return 'Openpay'.ucfirst($name);
    }

    private function isResource($resourceName) {
        OpenpayApiConsole::trace('OpenpayApiResourceBase @isResource > '.$resourceName);
// 		$resourceName = $this->getResourceName($name);

        return class_exists("Openpay\\Resources\\".$resourceName);
    }

    private function registerInParent($resource) {
        OpenpayApiConsole::trace('OpenpayApiResourceBase @registerInParent');
        $parent = $this->parent;
        if ($parent instanceof OpenpayApiDerivedResource) {
            $parent = $this->parent->parent;
        }

        if (!is_object($parent)) {
            return;
        }

        if ($container = $parent->getResource($resource->resourceName)) { // $resourceName
            if ($container instanceof OpenpayApiDerivedResource && method_exists($container, 'addResource')) {
                OpenpayApiConsole::trace('OpenpayApiResourceBase @registerInParent > registering derived resource in parent');
                $container->addResource($resource);
            }
        }
    }

    private function getSerializeParameters() {
        OpenpayApiConsole::trace('OpenpayApiResourceBase @getSerializeParameters');
        return $this->serializableData;
    }

    private function getResource($resourceName) {
        if ($this->derivedResources !== null) {
            foreach ($this->derivedResources as $resource) {
                if ($resource->resourceName == $resourceName) {
                    return $resource;
                }
            }
        }

        return false;
    }

    // ---------------------------------------------------------
    // -----------------  PROTECTED FUNCTIONS  -----------------

    protected function refreshData($data) {
        OpenpayApiConsole::trace('OpenpayApiResourceBase @refreshData');

        if (!$data) {
            return $this;
        }

        if (!is_array($data)) {
            throw new OpenpayApiError("Invalid data received for processing, cannot update the Openpay resource");
        }

        // unsets the unused attributes
        $removed = array_diff(array_keys($this->serializableData), array_keys($data));
        if (count($removed)) {
            OpenpayApiConsole::debug('OpenpayApiResourceBase @refreshData > removing unused data');
            foreach ($removed as $k) {
                if ($this->serializableData[$k]) {
                    unset($this->serializableData[$k]);
                }
                if ($this->noSerializableData[$k]) {
                    $this->noSerializableData[$k] = null;
                }
                if ($this->derivedResources[$k]) {
                    //$this->derivedResources[$k] = null;
                }
            }
        }

        foreach ($data as $k => $v) {
            $k = strtolower($k);

            $value = $this->processAttribute($k, $v);

            if ($k == 'id') {
                if (!isset($this->id)) {
                    $this->id = $v;
                }
                continue;

                // by default, only protected vars & serializable data will be refresh
                // in this version, noSerializableData does not store any value
            } else if (property_exists($this, $k)) {
                $this->$k = $value;
                //if ($this->noSerializableData[$k]) {
                //	$this->noSerializableData[$k] = $value;
                //}
            } else {
                $this->serializableData[$k] = $value;
            }
        }
        return $this;
    }

    protected function getResourceUrlName($pluralize = true) {
        $ResourceUrl = explode('\\', $this->resourceName);
        $class = $ResourceUrl[sizeof($ResourceUrl)-1];
        if (substr($class, 0, strlen('Openpay')) == 'Openpay') {
            $class = substr($class, strlen('Openpay'));
        }
        if (substr($class, -1 * strlen('List')) == 'List') {
            $class = substr($class, 0, -1 * strlen('List'));
        }
        if (substr($class, -1 * strlen('OpenpayPse')) == 'Pse') {
            $class = 'Pse';
            return strtolower(urlencode($class));
        }
        return strtolower(urlencode($class)).($pluralize ? 's' : '');
    }

    protected function validateParams($params) {
        OpenpayApiConsole::trace('OpenpayApiResourceBase @validateParams');
        if (!is_array($params)) {
            throw new OpenpayApiRequestError("Invalid parameters type detected (type '".gettype($params)."' received, Array expected)");
        }
    }

    protected function validateId($id) {
        OpenpayApiConsole::trace('OpenpayApiResourceBase @validateId');
        $class = $this->resourceName;
        if (substr($class, -1 * strlen('Bine')) != 'Bine') {
            if (!is_string($id) || !preg_match('/^[a-z][a-z0-9]{0,20}$/i', $id)) {
                throw new OpenpayApiRequestError("Invalid ID detected (value '".$id."' received, alphanumeric string not longer than 20 characters expected)");
            }
        }
    }

    protected function getMerchantInfo(){
        $response = OpenpayApiConnector::request('get', '/' , null);
        return json_decode(json_encode($response));
    }

    protected function _create($resourceName, $params, $props = null) {

        $resource = self::getInstance($resourceName, $props);
        $resource->validateParams($params);

        // TODO: handle errors, not return anything
        $response = OpenpayApiConnector::request('post', $resource->getUrl(), $params);
        return $resource->refreshData($response);
    }

    protected function _retrieve($resourceName, $id, $props = null) {
        if ($props && is_array($props)) {
            $props['id'] = $id;
        } else {
            $props = array('id' => $id);
        }

        $resource = self::getInstance($resourceName, $props);
        $resource->validateId($id);

        $response = OpenpayApiConnector::request('get', $resource->getUrl());
        return $resource->refreshData($response);
    }

    protected function _find($resourceName, $params, $props = null) {

        $resource = self::getInstance($resourceName, $props);
        $resource->validateParams($params);

        $list = array();
        $response = OpenpayApiConnector::request('get', $resource->getUrl(), $params);
        if ($this->isList($response)) {
            foreach ($response as $v) {
                $item = self::getInstance($resourceName);
                $item->refreshData($v);
                array_push($list, $item);
            }
        }
        return $list;
    }

    protected function _update() {
        $params = $this->getSerializeParameters();

        if (count($params)) {
            $response = OpenpayApiConnector::request('put', $this->getUrl(), $params);
            return $this->refreshData($response);
        }
    }

    protected function _updateCharge($params) {
        if (count($params)) {
            $response = OpenpayApiConnector::request('put', $this->getResourceUrlName(), $params);
            return $this->refreshData($response);
        }
    }

    protected function _delete() {
        OpenpayApiConnector::request('delete', $this->getUrl(), null);

        // remove from list, if parent is a list
        if ($this->id && $this->parent && method_exists($this->parent, 'removeResource')) {
            $this->parent->removeResource($this->id);
        }
        //$this->empty(); // TODO
    }

    protected function _getAttributes($param) {
        $url = $this->getUrl().'/'.$param;
        $response = OpenpayApiConnector::request('get', $url, null);
        return json_decode(json_encode($response));
    }

    // ---------------------------------------------------------
    // ------------------  PUBLIC FUNCTIONS  -------------------

    public function getUrl() { // $includeId = true
        OpenpayApiConsole::trace('OpenpayApiResourceBase @getUrl > class/parent: '.get_class($this).'/'.($this->parent ? 'true' : 'false'));
        $parentUrl = '';

        if ($this->parent) {
            $parentUrl = $this->parent->getUrl();
            if ($this->parent instanceof OpenpayApiDerivedResource) {
                return $parentUrl.($this->id ? '/'.$this->id : '');
            }
        }
        $resourceUrlName = $this->getResourceUrlName();
        return ($parentUrl != '' ? $parentUrl : '').($resourceUrlName != '' ? '/'.$resourceUrlName : '').($this->id ? '/'.$this->id : '');
    }

    // ---------------------------------------------------------
    // --------------------  MAGIC METHODS  --------------------

    public function __set($key, $value) {
        OpenpayApiConsole::trace('OpenpayApiResourceBase @__set > '.$key.' = '.$value);
        if ($value === '' || !$value) {
            error_log("[OPENPAY Notice] The property '".$key."' will be set to en empty string which will be intepreted ad a NULL in request");
        }
        if (isset($this->$key) && is_array($value)) {
            // TODO: handle this properly, eg: interpret the array as an object and replace value as
            // $this->$key->replaceWith($value);
            throw new OpenpayApiError("The property '".$key."' cannot be assigned directly with an array");
            //} else if (property_exists($this, $key)) {
            //	$this->$key = $value;
        } else if (isset($this->serializableData[$key])) {
            $this->serializableData[$key] = $value;
        } elseif (isset($this->derivedResources[$key])) {
            $this->derivedResources[$key] = $value;
        }
    }

    public function __get($key) {
        if (property_exists($this, $key)) {
            return $this->$key;
        } else if (array_key_exists($key, $this->serializableData)) {
            return $this->serializableData[$key];
        } else if (array_key_exists($key, $this->derivedResources)) {
            return $this->derivedResources[$key];
        } else if (array_key_exists($key, $this->noSerializableData)) {
            return $this->noSerializableData[$key];
        } else {
            $resourceName = get_class($this);
            error_log("[OPENPAY Notice] Undefined property of $resourceName instance: $key"); // TODO error_log?
            return null;
        }
    }

}

?>
