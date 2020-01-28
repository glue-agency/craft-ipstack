<?php
/**
 * IP Stack plugin for Craft CMS 3.x
 *
 * Lookup ip info using the IP Stack API
 *
 * @link      https://glue.be/
 * @copyright Copyright (c) 2020 Glue
 */

namespace GlueAgency\IPStack\services;

use Craft;
use craft\base\Component;
use GlueAgency\IPStack\endpoints\Endpoint;
use stdClass;

/**
 * StandardLookupService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Glue
 * @package   IpStack
 * @since     0.1.0
 */
class StandardLookupService extends Component
{

    /**
     * @var stdClass
     */
    public $data;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function user(): stdClass
    {
        $ip = Craft::$app->getRequest()->getUserIP();

        return $this->getData($ip);
    }

    public function getData($ip): stdClass
    {
        if(! $this->data) {
            $endpoint = new Endpoint();
            $response = $endpoint->standard($ip);

            $this->data = json_decode($response);
        }

        return $this->data;
    }
}
