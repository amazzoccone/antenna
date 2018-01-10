<?php

namespace Bondacom\Antenna\Drivers\OneSignal;

use Bondacom\Antenna\Drivers\NotificationInterface;

class Notification implements NotificationInterface
{
    /**
     * @var AntennaRequester
     */
    private $requester;

    /**
     * OneSignalConsumer constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->requester = app(Requester::class);
    }

    /**
     * @param array $parameters
     * @return array
     * @throws AntennaServerException
     */
    public function all(array $parameters = []) : array
    {
        $result = $this->requester->get('apps', $parameters);
        $this->assertHasNotErrors($result);

        return $result;
    }

    /**
     * @param string $id
     * @return array
     * @throws AntennaServerException
     */
    public function find(string $id) : array
    {
        $result = $this->requester->get('apps', $id);
        $this->assertHasNotErrors($result);

        return $result;
    }

    /**
     * @param array $data
     * @return array
     * @throws AntennaServerException
     */
    public function create(array $data) : array
    {
        $result = $this->requester->post('apps', $data);
        $this->assertHasNotErrors($result);

        return $result;
    }

    /**
     * @param string $id
     * @return array
     * @throws AntennaServerException
     */
    public function cancel(string $id) : array
    {
        $result = $this->requester->put('apps/'.$id, $data);
        $this->assertHasNotErrors($result);

        return $result;
    }

    /**
     * @param $result
     * @return $this
     * @throws AntennaServerException
     */
    private function assertHasNotErrors($result)
    {
        if (array_key_exists('errors', $result)) {
            throw new AntennaServerException(implode(', ', $result['errors']));
        }

        return $this;
    }
}