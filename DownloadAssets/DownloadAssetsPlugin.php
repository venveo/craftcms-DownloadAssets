<?php

namespace Craft;

class DownloadAssetsPlugin extends BasePlugin
{
    function getName()
    {
        return Craft::t('Download Assets');
    }

    function getVersion()
    {
        return '1.0';
    }

    function getDeveloper()
    {
        return 'Matt Stauffer';
    }

    function getDeveloperUrl()
    {
        return 'http://www.mattstauffer.co/';
    }
}