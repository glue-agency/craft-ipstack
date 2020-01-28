<?php
/**
 * IP Stack plugin for Craft CMS 3.x
 *
 * IP Stack service
 *
 * @link      thomasdm@glue.be
 * @copyright Copyright (c) 2019 Thomas De Marez
 */

namespace GlueAgency\IPStack\assetbundles\ipstack;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * IP StackAsset AssetBundle
 *
 * AssetBundle represents a collection of asset files, such as CSS, JS, images.
 *
 * Each asset bundle has a unique name that globally identifies it among all asset bundles used in an application.
 * The name is the [fully qualified class name](http://php.net/manual/en/language.namespaces.rules.php)
 * of the class representing it.
 *
 * An asset bundle can depend on other asset bundles. When registering an asset bundle
 * with a view, all its dependent asset bundles will be automatically registered.
 *
 * http://www.yiiframework.com/doc-2.0/guide-structure-assets.html
 *
 * @author    Glue
 * @package   IPStack
 * @since     0.1.0
 */
class IPStackAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * Initializes the bundle.
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = "@GlueAgency/IPStack/assetbundles/ipstack/dist";

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        parent::init();
    }
}
