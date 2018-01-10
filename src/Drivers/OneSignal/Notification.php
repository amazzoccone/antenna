<?php

namespace Bondacom\Antenna\Drivers\OneSignal;

use Bondacom\Antenna\Drivers\NotificationInterface;

class Notification implements NotificationInterface
{
    /**
     * @var Requester
     */
    private $requester;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * OneSignalConsumer constructor.
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
    {
        $this->requester = $requester;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function append($data)
    {
        $this->parameters = array_merge($this->parameters, $data);
        return $this;
    }

    /**
     * Fore more information visit: https://documentation.onesignal.com/v4.0/reference#view-notifications
     *
     * @param array $parameters (limit, offset)
     * @return array
     * @throws AntennaServerException
     */
    public function all(array $parameters = []) : array
    {
        $this->append($parameters);
        $result = $this->requester->get('notifications', $this->parameters);
        $this->assertHasNotErrors($result);

        return $result['notifications'];
    }

    /**
     * Fore more information visit: https://documentation.onesignal.com/v4.0/reference#create-notification
     *
     * @param array $data
     * @return array
     * @throws AntennaServerException
     */
    public function create(array $data) : array
    {
        $this->append($data);
        $result = $this->requester->post('notifications', $this->parameters);
        $this->assertHasNotErrors($result);

        return $result;
    }

    /**
     * Fore more information visit: https://documentation.onesignal.com/v4.0/reference#view-notification
     *
     * @param string $id
     * @return array
     * @throws AntennaServerException
     */
    public function find(string $id) : array
    {
        $result = $this->requester->get('notifications/'.$id, $this->parameters);
        $this->assertHasNotErrors($result);

        return $result;
    }

    /**
     * @param array $data
     * @param string $id
     * @return array
     * @throws AntennaServerException
     */
    public function update(array $data, string $id) : array
    {
        //TODO: Throw exception because Notification API doesn't have an update endpoint
    }

    /**
     * Fore more information visit: https://documentation.onesignal.com/v4.0/reference#cancel-notification
     *
     * @param string $id
     * @return bool
     * @throws AntennaServerException
     */
    public function delete(string $id) : bool
    {
        $result = $this->requester->delete('notifications/'.$id, $this->parameters);
        $this->assertHasNotErrors($result);

        return true;
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