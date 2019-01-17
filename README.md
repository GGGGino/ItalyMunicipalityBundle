# GGGGinoItalyMunicipalityBundle

> A list of the updated regions, provinces of Italy

# Get started

# API

```php
$this->get(IstatRetrivier::class);
```

Useful if you want to manage/get Municipalities

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
