<?php
/**
 * IP Stack plugin for Craft CMS 3.x
 *
 * Lookup ip info using the IP Stack API
 *
 * @link      https://glue.be/
 * @copyright Copyright (c) 2020 Glue
 */

namespace GlueAgency\IPStack\variables;

use Craft;
use GlueAgency\IPStack\services\StandardLookupService;
use stdClass;

/**
 * IP Stack Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.ipStack }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Glue
 * @package   IpStack
 * @since     0.1.0
 */
class IpStackVariable
{

    // Public Methods
    // =========================================================================

    /**
     * @var StandardLookupService
     */
    protected $standardLookup;

    public function __construct(StandardLookupService $standardLookup)
    {
        $this->standardLookup = $standardLookup;
    }

    public function user(): stdClass
    {
        $ip = Craft::$app->getRequest()->getUserIP();

        return $this->standardLookup->getData($ip);
    }
}
