<?php

namespace Bondacom\antenna;

use Bondacom\antenna\Exceptions\AntennaSaveException;

class AntennaModel
{
    /**
     * Model attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Check if we must go to server to get the model information
     *
     * @var bool
     */
    protected $isLoad = false;

    /**
     * @var Consumer
     */
    protected $consumer;

    /**
     * Check if we must go to OneSignal server to update it.
     *
     * @var bool
     */
    protected $isDirty = false;

    /**
     * Signal constructor.
     *
     * @param string $appID OneSignal APP ID
     * @param string $appKey OneSignal APP Key
     * @param array $metaData If you have all the information, can send metadata in order to avoid make a new call. This is a optional parameter.
     */
    public function __construct($appID, $appKey, $metaData = [])
    {
        $this->consumer = app(ConsumerInterface::class);
        $this->consumer->setApp($appID, $appKey);

        $this->id = $appID;
        $this->basic_auth_key = $appKey;
        $this->loadFromMetadata($metaData);
    }

    /**
     * @param $id
     * @param $key
     * @return $this|SignalApp
     */
    public static function find($id, $key)
    {
        $model = new self($id, $key);
        $model->load();
        return $model;
    }

    /**
     * @param array $data
     * @return SignalApp
     */
    public static function create(array $data)
    {
        $model = new self($data);
        $model->save();

        return $model;
    }

    /**
     * Persists attributes from server
     */
    public function save()
    {
        if (!$this->isDirty) {
            return $this;
        }

        $result = $this->attributes['id'] ?
            $this->consumer->update($this->attributes) :
            $this->consumer->create($this->attributes);

        if (isset($result->errors)) {
            throw new AntennaSaveException(implode(",", $result->errors));
        }

        $this->loadFromMetadata($result);
        $this->isDirty = false;
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
     * Get attributes from OneSignal server
     */
    private function load()
    {
        $this->loadFromMetadata($this->consumer->get());
        $this->isLoad = true;
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
     * WARNING: CALL IT JUST IF YOU ARE SURE THAT YOU HAVE THE MOST RECENT INFORMATION (FOR EXAMPLE, AFTER CREATION)
     *
     * @param $data
     * @return $this
     */
    private function loadFromMetadata($data)
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