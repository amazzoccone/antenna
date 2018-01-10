<?php

namespace Bondacom\Antenna;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Exceptions\AntennaSaveException;
use Bondacom\Antenna\Utilities\Notification;

class AntennaModel
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * Check if must go to the server to update it.
     *
     * @var bool
     */
    protected $isDirty = false;

    /**
     * AntennaModel constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->driver = app(DriverInterface::class);

        $this->fill($attributes);
    }

    /**
     * @return Notification
     */
    public function notification()
    {
        $notification = new Notification();
        return $notification;
    }

    /**
     * @return DriverInterface
     */
    public function driver()
    {
        return $this->driver;
    }

    /**
     * @param $id
     * @return AntennaModel
     */
    public static function find($id)
    {
        $model = new self(['id' => $id]);
        $model->refresh();

        return $model;
    }

    /**
     * @param array $data
     * @return AntennaModel
     */
    public static function create(array $data)
    {
        $model = new self($data);
        $model->save();

        return $model;
    }

    /**
     * @return $this
     * @throws AntennaSaveException
     */
    public function save()
    {
        if (!$this->isDirty) {
            return $this;
        }

        $result = empty($this->attributes['id']) ?
            $this->driver->create($this->attributes) :
            $this->driver->update($this->attributes, $this->id);

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
        $data = $this->driver->find($this->id);

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
     * @param array $data
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