<?php

namespace Bondacom\antenna;

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
    protected $loaded = false;

    /**
     * Check if we must go to OneSignal server to update it.
     *
     * @var bool
     */
    protected $isDirty = false;

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
        if (empty($this->attributes) AND !$this->loaded) {
            $this->load();
        }

        // Now, we have the OnSignal data, if there is the required attribute, then access to this.
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }
    }

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
        // TODO
    }


    /**
     * Persists attributes from OneSignal server
     */
    public function save()
    {
        // TODO
        $this->isDirty = false;
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
        $this->fillObject($data);
        $this->loaded = true;
        $this->isDirty = false;

        return $this;
    }
}