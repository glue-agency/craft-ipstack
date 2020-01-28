<?php
/**
 * IP Stack plugin for Craft CMS 3.x
 *
 * IP Stack service
 *
 * @link      thomasdm@glue.be
 * @copyright Copyright (c) 2019 Thomas De Marez
 */

namespace GlueAgency\IPStack\models;

use GlueAgency\IPStack\IpStack;

use Craft;
use craft\base\Model;

/**
 * IP Stack Settings Model
 *
 * This is a model used to define the plugin's settings.
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    Thomas De Marez
 * @package   IPStack
 * @since     0.1.0
 */
class Settings extends Model
{

    // Public Properties
    // =========================================================================

    /**
     * Some field model attribute
     *
     * @var string
     */
    public $apiKey = null;

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['apiKey', 'required'],
        ];
    }
}
