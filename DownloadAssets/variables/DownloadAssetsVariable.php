<?php

namespace Craft;

class DownloadAssetsVariable
{
	/**
	 * Pass through optgroup of all local sources
	 * 
	 * @return array
	 */
	public function getSourcesOptGroup()
	{
		return craft()->downloadAssets->getSourcesOptGroup();
	}
}