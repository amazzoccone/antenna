<?php

namespace Bondacom\antenna;

use Bondacom\antenna\Exceptions\OneSignalSaveException;

class AntennaModel
{
    /**
     * Model attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Check if we must go to OneSignal server to get the model information
     *
     * @var bool
     */
    protected $isLoad = false;

    /**
     * OneSignal Client
     *
     * @var OneSignalConsumer
     */
    protected $oneSignalConsumer;

    /**
     * Check if we must go to OneSignal server to update it.
     *
     * @var bool
     */
    protected $isDirty = false;

    /**
     * AntennaModel constructor.
     *
     * @param OneSignalConsumer $oneSignalConsumer
     */
    function __construct(OneSignalConsumer $oneSignalConsumer)
    {
        $this->oneSignalConsumer = $oneSignalConsumer;
    }

    /**
     * Set user key (In order to update app, for example)
     *
     * @param $key
     *
     * @return $this
     */
    public function setUserKey($key)
    {
        if (!$key) {
            return $this;
        }

        $this->oneSignalConsumer->setUserKey($key);
        return $this;
    }


    /**
     * Get an attribute from the model.
     *
     * @param  string $key
     * @return mixed
     */
    private function getAttribute($key)
    {
        if (!$key) {
            return;
        }

        // If we have it we will return it (For example ID is mandatory to instance SignalApp Model)
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        // If we don't have this attribute, and object is not loaded, then, we will load the object
        if ((empty($this->attributes) OR !isset($this->attributes[$key])) AND !$this->isLoad) {
            $this->load();
        }

        // Now, we have the OnSignal data, if there is the required attribute, then access to this.
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    private function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
        $this->isDirty = true;

        return $this;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Get attributes from OneSignal server
     */
    private function load()
    {
        $method = 'get' . $this->oneSignalObject;

        $this->loadFromMetadata($this->oneSignalConsumer->$method());
        $this->isLoad = true;
    }


    /**
     * Persists attributes from OneSignal server
     */
    public function save()
    {
        if (!$this->isDirty) {
            return $this;
        }

        $method = ($this->attributes['id'] ? 'update' : 'create') . $this->oneSignalObject;
        $result = $this->oneSignalConsumer->{$method}($this->attributes);

        if (isset($result->errors)) {
            throw new OneSignalSaveException(implode(",", $result->errors));
        }

        $this->loadFromMetadata($result);
        $this->isDirty = false;
        return $this;
    }

    /**
     *
     * @param $data
     * @return $this
     */
    private function fillObject($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }

        return $this;
    }

    /**
     * If you have all the information for any reason, and don't need go to OneSignal server, then, you can use it.
     *
     * WARNING: CALL IT JUST IF YOU ARE SURE THAT YOU HAVE THE MOST RESENT INFORMATION (FOR EXAMPLE, AFTER CREATION)
     *
     * @param $data
     * @return $this
     */
    public function loadFromMetadata($data)
    {
        if (empty($data)) {
            return $this;
        }

        $this->fillObject($data);
        $this->isLoad = true;
        $this->isDirty = false;

        return $this;
    }
}