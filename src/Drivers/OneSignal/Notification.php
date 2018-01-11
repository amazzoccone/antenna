<?php

namespace Bondacom\Antenna\Drivers\OneSignal;

use Bondacom\Antenna\Drivers\NotificationInterface;
use Bondacom\Antenna\Drivers\Utility;
use Bondacom\Antenna\Exceptions\MissingOneSignalAppInformation;
use Bondacom\Antenna\Exceptions\MissingOneSignalData;

class Notification extends Utility implements NotificationInterface
{
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
        $this->assertHasApp()->prepareForRequest();
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
        $this->assertHasApp()->prepareForRequest();
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
        $this->assertHasApp()->prepareForRequest();
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
        $this->notImplemented();
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
        $this->assertHasApp()->prepareForRequest();
        $result = $this->requester->delete('notifications/'.$id, $this->parameters);
        $this->assertHasNotErrors($result);

        return true;
    }

    /**
     * @return $this
     * @throws MissingOneSignalData
     */
    private function assertHasApp()
    {
        if (array_key_exists('app_id', $this->parameters) && array_key_exists('app_key', $this->parameters)) {
            return $this;
        }

        throw new MissingOneSignalData();
    }

    /**
     * @return $this
     */
    private function prepareForRequest()
    {
        $key = $this->parameters['app_key'];
        unset($this->parameters['app_key']);
        $this->requester->setAuthorizationKey($key);

        return $this;
    }
}