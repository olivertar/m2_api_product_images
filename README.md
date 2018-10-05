# M2 API Product Image Module

This module is a plugin for Magento 2 that modifies the way to send the product images through the API avoiding the codification of the images in base 64.

## History

The idea arose in a project where the client had a catalog of configurable products with 30 or more variations.

This number of variants involved sending to the server about 300 images or more for each configurable product, which resulted in high transmission times and bandwidth consumption when the products of the catalog were updated.

For those who do not know, the Magento 2 API must receive the images encoded in base 64, which Magento then decodes and transforms into a physical file.

The client asked to upload the images to the server via FTP as an alternative.

## How does it work

This plugin modifies the behavior of Magento 2 so that through the API, it only receives the name of the image. For everything to work and magic to occur the physical file of the image must be in "pub/media/import"

The plugin verifies that 3 conditions are met:
1- The "file" field is not empty
2- The "base64EncodedData" field is empty
3- An image with the name included in the "file" field exists in the "pub/media/import" folder in the Magento 2 installation.

## JSON message example

{
  "product": {
  "sku": "test-product",
  "name": "Test Product",
  "attributeSetId": 4,
  "price": 99,
  "status": 1,
  "typeId": "simple",
  "weight": 1,
  "mediaGalleryEntries": [{
            "mediaType": "image",
            "label": "Test Product Image",
            "position": 1,
            "disabled": false,
            "file": "test_image.png",
		    "types": [
				"image",
				"thumbnail",
				"small_image"
		    ],
            "content": {
                "base64EncodedData": "",
                "type": "image/png",
                "name": "test_image.png"
            }
        }]

}
}

## Donation
If you have used this module consider the possibility of making a donation

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=BJGDM4EZMETKQ)
