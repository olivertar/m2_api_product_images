<?php
/**
 * Orange Cat
 * Copyright (C) 2018 Orange Cat
 *
 * NOTICE OF LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see http://opensource.org/licenses/gpl-3.0.html
 *
 * @category Orangecat
 * @package Orangecat_MediaGalleryProcessor
 * @copyright Copyright (c) 2018 Orange Cat
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author Oliverio Gombert <olivertar@gmail.com>
 */

namespace Orangecat\MediaGalleryProcessor\Model;

use Magento\Framework\Api\Data\ImageContentInterface;
use Magento\Framework\Api\Data\ImageContentInterfaceFactory;
use \Magento\Catalog\Model\ProductRepository\MediaGalleryProcessor;

class MediaGalleryProcessorPlugin extends \Magento\Catalog\Model\ProductRepository\MediaGalleryProcessor
{
    public function aroundProcessMediaGallery(\Magento\Catalog\Model\ProductRepository\MediaGalleryProcessor $subject, \Closure $proceed, $product, $mediaGalleryEntries)
    {
        foreach ($mediaGalleryEntries as $k => $entry) {
            if(isset($entry['content'][ImageContentInterface::BASE64_ENCODED_DATA]) && $entry['content'][ImageContentInterface::BASE64_ENCODED_DATA] == ''):
                $mediaImportPath = BP.'/pub/media/import/';
                if (isset($entry['file']) && !empty($entry['file']) && file_exists($mediaImportPath.$entry['file'])):
                    $imagedata = file_get_contents($mediaImportPath.$entry['file']);
                    $entry['content'][ImageContentInterface::BASE64_ENCODED_DATA] = base64_encode($imagedata);
                    $mediaGalleryEntries[$k]['content'][ImageContentInterface::BASE64_ENCODED_DATA] = base64_encode($imagedata);
                endif;
            endif;
        }
        $returnValue = $proceed($product, $mediaGalleryEntries);
        return $returnValue;
    }

}