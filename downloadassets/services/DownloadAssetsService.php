<?php

namespace Craft;

class DownloadAssetsService extends BaseApplicationComponent
{
	/**
	 * Return a list of all local asset sources, prepped as an options group
	 * 
	 * @return array
	 */
	public function getSourcesOptGroup()
	{
		return $this->convertSourcesToOptGroup($this->getLocalSources());
	}

	/**
	 * Get an array of all local source IDs
	 * 
	 * @return array
	 */
	public function getSourceIds()
	{
		$return = array();

		foreach ($this->getLocalSources() as $source) {
			$return[] = $source->id;
		}

		return $return;
	}

	/**
	 * Get an array of all local asset sources
	 * 
	 * @return array
	 */
	protected function getLocalSources()
	{
		$sources = craft()->assetSources->getAllSources();

		return $this->filterLocal($sources);
	}

	/**
	 * Filter an array of sources to return only local sources
	 * 
	 * @param  array  $sources
	 * @return array
	 */
	protected function filterLocal(array $sources)
	{
		$return = array();
		
		foreach ($sources as $key => $source) {
			if ($source->type == 'Local') {
				$return[$key] = $source;
			}
		}

		return $return;
	}

	/**
	 * Convert an array of sources to an optgroup-ready array
	 * 
	 * @param  array  $sources
	 * @return array
	 */
	protected function convertSourcesToOptGroup(array $sources)
	{
		$return = array(
			array(
				'label' => 'All local sources',
				'value' => 'all'
			)
		);

		foreach ($sources as $source) {
			$return[] = array(
				'label' => $source->name,
				'value' => $source->id
			);
		}

		return $return;
	}
}