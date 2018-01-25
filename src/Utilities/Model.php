<?php

namespace Bondacom\Antenna\Utilities;

use Bondacom\Antenna\Drivers\DriverInterface;
use Bondacom\Antenna\Exceptions\AntennaNotFoundException;
use Illuminate\Support\Collection;

abstract class Model
{
    use GuardsAttributes, HasAttributes;

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * Model constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->driver = $this->newDriverInstance();
        $this->syncOriginal();
        $this->fill($attributes);
    }

    /**
     * @return \Bondacom\Antenna\Drivers\ModelInterface
     */
    abstract public function newDriverInstance();

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
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->$method(...$parameters);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return (new static)->$method(...$parameters);
    }

    /**
     * @param array $parameters
     * @return array
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    private function all(array $parameters = []) : array
    {
        $data = $this->driver->all($parameters);

        $models = [];
        foreach ($data as $model) {
            $models[] = (new static())->appendParameters($this->getParameters())->setAttributes($model, true);
        }

        return $models;
    }

    /**
     * @param $id
     * @return Model|null
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    private function find($id)
    {
        try{
            return $this->findOrFail($id);
        } catch(AntennaNotFoundException $e){
            return null;
        }
    }

    /**
     * @param $id
     * @return Model|null
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     * @throws \Bondacom\Antenna\Exceptions\AntennaNotFoundException
     */
    private function findOrFail($id)
    {
        if (empty($id)) {
            throw new AntennaNotFoundException();
        }

        $this->attributes['id'] = $id;
        $this->refresh();

        return $this;
    }

    /**
     * @param array $data
     * @return Model
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    private function create(array $data)
    {
        $this->fill($data);
        $this->save();

        return $this;
    }

    /**
     * @return bool
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    private function delete()
    {
        return $this->driver->delete($this->attributes['id']);
    }

    /**
     * @return bool (true if success)
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    private function save()
    {
        if ($this->isDirty()) {
            $result = empty($this->attributes['id']) ?
                $this->driver->create($this->attributes) :
                $this->driver->update($this->attributes, $this->attributes['id']);
        }

        $this->setAttributes($result, true);
        return true;
    }

    /**
     * Reload the current model instance with fresh attributes from the server.
     *
     * @return $this
     * @throws \Bondacom\Antenna\Exceptions\AntennaServerException
     */
    private function refresh()
    {
        $data = $this->driver->find($this->attributes['id']);

        $this->setAttributes($data, true);

        return $this;
    }

    /**
     *
     * @param array $attributes
     * @return $this
     */
    private function fill(array $attributes)
    {
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            // The developers may choose to place some attributes in the "fillable" array
            // which means only those attributes may be set through mass assignment to
            // the model, and all others will just get ignored for security reasons.
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * @param $class
     * @return Builder
     */
    protected function newQuery($class)
    {
        return new Builder($class);
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function appendParameters(array $parameters)
    {
        $this->parameters = array_merge($this->parameters, $parameters);
        $this->driver->append($parameters);

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}