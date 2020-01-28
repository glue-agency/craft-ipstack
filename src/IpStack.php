<?php
/**
 * IP Stack plugin for Craft CMS 3.x
 *
 * Lookup ip info using the IP Stack API
 *
 * @link      https://glue.be/
 * @copyright Copyright (c) 2020 Glue
 */

namespace GlueAgency\IPStack;

use Craft;
use craft\base\Plugin;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\services\Plugins;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;
use GlueAgency\IPStack\models\Settings;
use GlueAgency\IPStack\services\StandardLookupService;
use GlueAgency\IPStack\twigextensions\IpStackTwigExtension;
use GlueAgency\IPStack\variables\IpStackVariable;
use Solspace\Freeform\Events\Integrations\PushEvent;
use Solspace\Freeform\Events\Submissions\SubmitEvent;
use Solspace\Freeform\Services\CrmService;
use Solspace\Freeform\Services\SubmissionsService;
use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Glue
 * @package   IpStack
 * @since     0.1.0
 *
 * @property  Settings $settings
 * @method    Settings getSettings()
 */
class IpStack extends Plugin
{

    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * IpStack::$plugin
     *
     * @var IpStack
     */
    public static $plugin;

    public $name = 'IP Stack';

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '0.1.0';

    public $hasCpSettings = true;

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * IpStack::$plugin
     *
     * Called after the plugin class is instantiated; do any one-time initialization
     * here such as hooks and events.
     *
     * If you have a '/vendor/autoload.php' file, it will be loaded for you automatically;
     * you do not need to load it in your init() method.
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        // Add in our Twig extensions
        Craft::$app->view->registerTwigExtension(new IpStackTwigExtension());

        // Add custom hook
        Craft::$app->view->hook('apistack-user-location', function(&$context) {
            Craft::$app->view->registerJsFile('ipstack/js/ipstack.js');
        });

        // Register our variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function(Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('ipStack', IpStackVariable::class);
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function(RegisterUrlRulesEvent $event) {
                $event->rules['ipstack/current-user'] = 'ip-stack/standard-lookup/user';
            }
        );

//        Event::on(
//            SubmissionsService::class,
//            SubmissionsService::EVENT_BEFORE_SUBMIT,
//            function(SubmitEvent $event) {
//                if(Craft::$app->request->isSiteRequest) // Front-end Form Submission
//                {
//                    $form = $event->getForm();
//                    $fields = $form->getCurrentPage()->getFields();
//                    $handlers = [];
//
//                    foreach($fields as $field) {
//                        $handlers[] = $field->getHandle();
//                    }
//
//                    $mappings = [
//                        'ipstack-ip' => 'ip',
//                        'ipstack-country' => 'country_name',
//                        'ipstack-region' => 'region_name',
//                        'ipstack-city' => 'city',
//                        'ipstack-zip' => 'zip',
//                        'ipstack-longitude' => 'longitude',
//                        'ipstack-latitude' => 'latitude',
//                    ];
//
//                    $toPopulate = array_intersect($handlers, array_keys($mappings));
//
//                    if($toPopulate) {
//                        $service = new StandardLookupService();
//                        $user = $service->user();
//
//                        foreach($toPopulate as $position => $handle) {
//                            $fields[$position]->setValue($user->{$mappings[$handle]});
//                        }
//                    }
//                }
//            }
//        );

        // Do something after we're installed
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function(PluginEvent $event) {
                if($event->plugin === $this) {
                    // We were just installed
                }
            }
        );

        /**
         * Logging in Craft involves using one of the following methods:
         *
         * Craft::trace(): record a message to trace how a piece of code runs. This is mainly for development use.
         * Craft::info(): record a message that conveys some useful information.
         * Craft::warning(): record a warning message that indicates something unexpected has happened.
         * Craft::error(): record a fatal error that should be investigated as soon as possible.
         *
         * Unless `devMode` is on, only Craft::warning() & Craft::error() will log to `craft/storage/logs/web.log`
         *
         * It's recommended that you pass in the magic constant `__METHOD__` as the second parameter, which sets
         * the category to the method (prefixed with the fully qualified class name) where the constant appears.
         *
         * To enable the Yii debug toolbar, go to your user account in the AdminCP and check the
         * [] Show the debug toolbar on the front end & [] Show the debug toolbar on the Control Panel
         *
         * http://www.yiiframework.com/doc-2.0/guide-runtime-logging.html
         */
        Craft::info(
            Craft::t(
                'ip-stack',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return \craft\base\Model|null
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * Returns the rendered settings HTML, which will be inserted into the content
     * block on the settings page.
     *
     * @return string The rendered settings HTML
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'ip-stack/settings', [
                'settings' => $this->settings,
            ]
        );
    }
}
