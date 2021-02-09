# PHP BMP Parser

[![CircleCI](https://circleci.com/gh/ecourtial/php-bmp-parser/tree/master.svg?style=svg)](https://circleci.com/gh/ecourtial/php-bmp-parser/tree/master)
[![Version](https://img.shields.io/github/v/release/ecourtial/php-bmp-parser)](https://circleci.com/gh/ecourtial/php-bmp-parser/tree/master)
[![codecov](https://codecov.io/gh/ecourtial/php-bmp-parser/branch/master/graph/badge.svg)](https://codecov.io/gh/ecourtial/php-bmp-parser)
[![Infection MSI](https://badge.stryker-mutator.io/github.com/ecourtial/php-bmp-parser/master)](https://infection.github.io)
[![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg)](https://GitHub.com/ecourtial/php-bmp-parser/graphs/commit-activity)
[![Ask Me Anything !](https://img.shields.io/badge/Ask%20me-anything-1abc9c.svg)](https://GitHub.com/ecourtial/php-bmp-parser)
[![GitHub license](https://img.shields.io/github/license/ecourtial/php-bmp-parser)](https://github.com/ecourtial/php-bmp-parser/blob/master/LICENSE)
![PHP Version](https://img.shields.io/packagist/php-v/ecourtial/php-bmp-parser)

## Description

* This small library allows you to parse a standard Windows BMP file (generic information + pixel by pixel).
* No third party libraries required. It is only based on native PHP functions.
* It also provides a basic feature to edit an existing BMP file (with the _gd_ extension required).

## Limitations

So far the library only handles the following files:

* 24 bits (true colors)
* 8 bits (256 colors) with palette
* 4 bits (16 colors) with palette

Another limitation, when editing: the current version of the library only allows editing 24 bits files. 

## Installation

`composer require ecourtial/php-bmp-parser`

## Utilization

```
$service = new BmpService();
$image = $service->getImage('myBmpFile.bmp');

// Get a pixel object, with specific coordinates. I am able to check the RGB and hex values.
$image->getPixel(2, 0);

// Now I want to edit the file and change the path to not alter the original one
$image->setPath('myNewBmpFile.bmp);

// Change the color of one specific pixel
$image->getPixel(0, 1)->setR(0)->setG(0)->setB(126);

// Change the size of the image (extra pixels filled with white).
$image->setDimensions(3, 4);

// Change the color of some pixels added because we increased the width.
$image->getPixel(0, 3)->setR(200)->setG(0)->setB(200);
$image->getPixel(1, 3)->setR(0)->setG(0)->setB(255);

// The image object is reloaded on update
$image = $service->update($image);
```
