<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Serverless\V1\Service\Asset;

use Twilio\Deserialize;
use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains preview products that are subject to change. Use them with caution. If you currently do not have developer preview access, please contact help@twilio.com.
 * 
 * @property string sid
 * @property string accountSid
 * @property string serviceSid
 * @property string assetSid
 * @property string path
 * @property string visibility
 * @property array preSignedUploadUrl
 * @property \DateTime dateCreated
 * @property string url
 */
class AssetVersionInstance extends InstanceResource {
    /**
     * Initialize the AssetVersionInstance
     * 
     * @param \Twilio\Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $serviceSid The service_sid
     * @param string $assetSid The asset_sid
     * @param string $sid The sid
     * @return \Twilio\Rest\Serverless\V1\Service\Asset\AssetVersionInstance 
     */
    public function __construct(Version $version, array $payload, $serviceSid, $assetSid, $sid = null) {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = array(
            'sid' => Values::array_get($payload, 'sid'),
            'accountSid' => Values::array_get($payload, 'account_sid'),
            'serviceSid' => Values::array_get($payload, 'service_sid'),
            'assetSid' => Values::array_get($payload, 'asset_sid'),
            'path' => Values::array_get($payload, 'path'),
            'visibility' => Values::array_get($payload, 'visibility'),
            'preSignedUploadUrl' => Values::array_get($payload, 'pre_signed_upload_url'),
            'dateCreated' => Deserialize::dateTime(Values::array_get($payload, 'date_created')),
            'url' => Values::array_get($payload, 'url'),
        );

        $this->solution = array(
            'serviceSid' => $serviceSid,
            'assetSid' => $assetSid,
            'sid' => $sid ?: $this->properties['sid'],
        );
    }

    /**
     * Generate an instance context for the instance, the context is capable of
     * performing various actions.  All instance actions are proxied to the context
     * 
     * @return \Twilio\Rest\Serverless\V1\Service\Asset\AssetVersionContext Context
     *                                                                      for
     *                                                                      this
     *                                                                      AssetVersionInstance
     */
    protected function proxy() {
        if (!$this->context) {
            $this->context = new AssetVersionContext(
                $this->version,
                $this->solution['serviceSid'],
                $this->solution['assetSid'],
                $this->solution['sid']
            );
        }

        return $this->context;
    }

    /**
     * Fetch a AssetVersionInstance
     * 
     * @return AssetVersionInstance Fetched AssetVersionInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function fetch() {
        return $this->proxy()->fetch();
    }

    /**
     * Magic getter to access properties
     * 
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get($name) {
        if (array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (property_exists($this, '_' . $name)) {
            $method = 'get' . ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $context = array();
        foreach ($this->solution as $key => $value) {
            $context[] = "$key=$value";
        }
        return '[Twilio.Serverless.V1.AssetVersionInstance ' . implode(' ', $context) . ']';
    }
}