# A Simple Package to Help Create DTOs (Data Transfer Objects)

# !!Attention!!
## Not ready for use yet!!!

## Getting started

To install this pachage just add the dependency in your composer.json file or execute the command:
```bash
composer require wguimaraes/dto
```

This package aims to simplify data normalization by using the DTO pattern in a straightforward way.

## Features

Its functionalities include simple methods:

```php
namespace App\Service;

use App\DTO\PersonDTO;

class ExampleService
{
    protected PersonDTO $personFromArray;
    protected PersonDTO $personFromObject;
    protected array $dtoList;
    protected array $list;

    public function __construct()
    {
        // Create a DTO object using an array that contains the properties as keys of the array
        $this->personFromArray = PersonDTO::fromArray(['first_name' => 'William', 'last_name' => 'Guimarães']);
        
        // Create a DTO object from another object, such as a Model class instance or a generic object that has the same properties as your DTO
        $this->personFromObject = PersonDTO::fromObject($this->personFromArray);
        
        // Convert a DTO object to an array of properties where the keys match the properties of the original DTO object
        $personDataArray = $this->personFromObject->toArray();
        
        // Create an array that contains a list of DTO objects from a previous array list
        $this->dtoList = PersonDTO::fromList([
            [
                'first_name' => 'Person 1 name',
                'last_name' => 'Person 1 last name',
                'address' => [
                    'street' => 'Street of Person 1',
                    'zip_code' => 'Zip code of Person 1',
                    'city' => 'City of Person 1'
                ]
            ],
            [
                'first_name' => 'Person 2 name',
                'last_name' => 'Person 2 last name',
                'address' => [
                    'street' => 'Street of Person 2',
                    'zip_code' => 'Zip code of Person 2',
                    'city' => 'City of Person 2'
                ]
            ]
        ]);
        
        // Convert the DTO list back into a common array list
        $this->list = PersonDTO::toList($this->dtoList);
    }
}

```

The PersonDTO class:

```php
namespace App\DTO;

use Wguimaraes\DTO\BaseDTO;

class PersonDTO extends BaseDTO
{
    public function __construct(
        public ?string $first_name,
        public ?string $last_name,
        public ?AddressDTO $address
    )
    {}
}
```

You can nest DTO's as a properties:

```php

namespace App\Service;

use App\DTO\PersonDTO;

class ExampleService
{
    public static function setPersonAddress(array $address): PersonDTO
    {
        $this->personFromArray->address = AddressDTO::fromArray($address);
        return $this->personFromArray;
    }
}
```

To create DTO classes you cancreate a DTO folder to store all your DTO classes and symply extend the BaseDTO class:

```bash
.
|__Dto
   |__MyDtoClass.php
   |__DataSubFolder
      |__MyOtherDtoClass.php
```

Class:

```php
<?php
  
namespace App\Dto;

use wguimaraes\Dto;

class MyDtoClass extends BaseDTO
{
    public function __construct(
        public ?string $first_name,
        public ?string $last_name,
        public ?AddressDTO $address
    )
    {}
}
```