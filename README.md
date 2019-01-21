# GGGGinoItalyMunicipalityBundle

[![Build Status](https://travis-ci.com/GGGGino/ItalyMunicipalityBundle.svg?branch=master)](https://travis-ci.com/GGGGino/ItalyMunicipalityBundle)

> A list of the updated regions, provinces of Italy taken from ISTAT with some useful utility.

> The content of the ISTAT file will be saved in cache

# Get started

Get the service

```php
/** @var IstatRetrivier $retrivier */
$retrivier = $this->get(IstatRetrivier::class);
```

Get all the municipalities

```php
/** @var CsvLine[] $municipalities */
$municipalities = $retrivier->getMunicipalities();
```

Get all the provinces

```php
/** @var CsvLine[] $provinces */
$provinces = $retrivier->getProvinces();
```

Get all the regions

```php
/** @var CsvLine[] $regions */
$regions = $retrivier->getRegions();
```

Get by some custom procedure

```php
/** @var CsvLine[] $lines */
$retrivier->getBy(function($csvLines) {
    /** @var CsvLine[] $regions */
    $regions = array();

    /** @var CsvLine $line */
    foreach($csvLines as $line) {
        if( !array_key_exists($line->codiceProvincia, $regions) ){
            $regions[$line->codiceProvincia] = $line;
        }
    }

    return $regions;
}, 'string_used_as_key_if_you_want_to_push_to_cache_otherwise_not_pushed');
```

# Form Types

| Name          | Description  |
| ------------- |:------------:|
| MunicipalityType::class | Form for displaying a list of all the *Municipalities* in Italy |
| ProvinceType::class | Form for displaying a list of all the *Provinces* in Italy |
| RegionType::class | Form for displaying a list of all the *Regions* in Italy |

```php
$formMapper
    ->add('comune',MunicipalityType::class)
    ->add('provincia', ProvinceType::class)
    ->add('regione', RegionType::class)
```

# Commands

| Name          | Description  |
| ------------- |:------------:|
| ggggino:italy_municipality:download | Command to download the list from ISTAT |
