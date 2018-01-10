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
     * OneSignalConsumer constructor.
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
    {
        $this->requester = $requester;
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
        $result = $this->requester->get('notifications', $parameters);
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
        $result = $this->requester->post('notifications', $data);
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
        $result = $this->requester->get('notifications/'.$id, ['app_id' => $appId]);
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
        $result = $this->requester->delete('notifications/'.$id, ['app_id' => $appId]);
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