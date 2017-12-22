<?php

namespace Bondacom\Antenna;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Exceptions\AntennaSaveException;

class AntennaModel
{
    /**
     * Model attributes
     *
     * @var array
     */
    protected $attributes = [];

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
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->consumer = app(DriverInterface::class);

        $this->fill($attributes);
    }

    /**
     * @param $id
     * @param $key
     * @return $this|SignalApp
     */
    public static function find($id, $key)
    {
        $model = new self();
        $model->consumer->setApp($id, $key);
        $model->refresh();

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

        $result = empty($this->attributes['id']) ?
            $this->consumer->create($this->attributes) :
            $this->consumer->update($this->attributes);

        if ($result === false) {
            throw new AntennaSaveException();
        }

        $this->fill($result);
        $this->isDirty = false;

        return $this;
    }

    /**
     * Reload the current model instance with fresh attributes from the server.
     *
     * @return $this
     */
    public function refresh()
    {
        $data = $this->consumer->get();

        if (empty($data)) { //Isn't an error?
            return $this;
        }

        $this->fill($data);
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
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
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

        // If we have it we will return it
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
     *
     * @param $data
     * @return $this
     */
    private function fill($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }

        return $this;
    }
}