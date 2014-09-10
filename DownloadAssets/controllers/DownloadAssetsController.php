<?php

namespace Craft;

class DownloadAssetsController extends BaseController
{
    public function actionDownload()
    {
        // Get wanted filename
        $source_id = craft()->request->getRequiredPost('assetsSource');

        if ($source_id == 'all') {
            $source_name = 'All Sources';
            $source_ids = craft()->downloadAssets->getSourceIds();
        } else {
            $source = craft()->assetSources->getSourceById($source_id);
            $source_name = $source->name;
            $source_ids = array($source_id);
        }
        
        // Get assets
        $criteria = craft()->elements->getCriteria(ElementType::Asset);
        $criteria->sourceId = $source_ids;
        $criteria->limit = null;
        $assets = $criteria->find();

        // Get filename
        $filename = 'craftAssetDownload_' . $this->slugify($source_name);

        // Create zip
        $zip = new \ZipArchive;
        $zipfile = craft()->path->getTempPath() . $filename . '_' . time() . '.zip';
        
        // Open zip
        if ($zip->open($zipfile, $zip::CREATE) === true) {
        
            // Loop through assets
            foreach ($assets as $asset) {
                // Get asset path
                $source = craft()->assetSources->getSourceById($asset->sourceId);
                       
                // Add asset to zip         
                $zip->addFile($source->settings['path'] . $asset->folder->path . $asset->filename, $asset->folder->path . $asset->filename);
            }
            
            // Close zip
            $zip->close();
            
            // Download zip
            craft()->request->sendFile(
                IOHelper::getFileName($zipfile),
                IOHelper::getFileContents($zipfile),
                array(
                    'forceDownload' => true
                )
            );
        }
    
        // If not redirected, something went wrong
        throw new Exception(Craft::t('Failed to generate the zipfile'));
    }

    protected function slugify($str)
    {
        return preg_replace('@[\s!:;_\?=\\\+\*/%&#]+@', '-', $str);
    }
}
