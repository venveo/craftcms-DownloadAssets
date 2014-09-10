<?php

namespace Craft;

class DownloadAssetsWidget extends BaseWidget
{
	public function getName() {
		return Craft::t('Download Local Assets');
	}

	public function getBodyHtml() {
		if ( ! craft()->userSession->isAdmin()) {
			return false;
		}

		return craft()->templates->render('DownloadAssets/widget');
	}
}