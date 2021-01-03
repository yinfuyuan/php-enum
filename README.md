# PHP Enum

[![Latest Version on Packagist](https://img.shields.io/packagist/v/phpenum/phpenum.svg?style=for-the-badge)](https://packagist.org/packages/phpenum/phpenum)
[![License](https://img.shields.io/github/license/yinfuyuan/php-enum?style=for-the-badge)](https://github.com/yinfuyuan/php-enum/blob/master/LICENSE.md)
![Postcardware](https://img.shields.io/badge/Postcardware-%F0%9F%92%8C-197593?style=for-the-badge)

[![PHP from Packagist](https://img.shields.io/packagist/php-v/phpenum/phpenum?style=flat-square)](https://packagist.org/packages/phpenum/phpenum)
[![Build Status](https://img.shields.io/github/workflow/status/yinfuyuan/php-enum/tests?label=tests&style=flat-square)](https://github.com/yinfuyuan/php-enum/actions?query=workflow%3Atests)
[![Total Downloads](https://img.shields.io/packagist/dt/phpenum/phpenum.svg?style=flat-square)](https://packagist.org/packages/phpenum/phpenum)

PHPEnum is an enumeration class library for PHP developers. The idea comes from [Java enumeration](https://docs.oracle.com/javase/8/docs/api/java/lang/Enum.html), and using the PHP features to implement single-value enumeration and multi-value enumeration. PHPEnum runs in most PHP applications.

### Installation

    composer require phpenum/phpenum

### Getting Started

Using PhpEnum is very similar to using Java Enum, For example, define an enumeration representing gender.

In Java:

    public enum GenderEnum {
        MALE(1, "male"),
        FEMALE(2, "female");
    
        private Integer id;
        private String name;
    
        GenderEnum(Integer id, String name) {
            this.id = id;
            this.name = name;
        }
    
        public Integer getId() {
            return id;
        }
    
        public String getName() {
            return name;
        }
    }

In PHP:

    class GenderEnum extends \PhpEnum\Enum
    {
        const MALE = [1, 'male'];
        const FEMALE = [2, 'female'];
    
        private $id;
        private $name;
    
        protected function construct($id, $name)
        {
            $this->id = $id;
            $this->name = $name;
        }
    
        public function getId()
        {
            return $this->id;
        }
        
        public function getName()
        {
            return $this->name;
        }
    }

You'll also find a lot of similarities when using enumerations

In Java:

    GenderEnum.values(); // enum instance array
    GenderEnum.valueOf("FEMALE"); // enum instance
    GenderEnum.MALE.equals(GenderEnum.valueOf("MALE")); // true
    GenderEnum.MALE.name(); // MALE
    GenderEnum.MALE.ordinal(); // 0
    GenderEnum.MALE.toString(); // MALE
    GenderEnum.MALE.getId(); // 1
    GenderEnum.MALE.getName(); // male

In PHP:

    GenderEnum::values(); // enum instance array
    GenderEnum::valueOf('FEMALE'); // enum instance
    GenderEnum::MALE()->equals(GenderEnum::valueOf('MALE')); // true
    GenderEnum::MALE()->name(); // MALE
    GenderEnum::MALE()->ordinal(); // 0
    (string)GenderEnum::MALE(); // MALE
    GenderEnum::MALE()->getId(); // 1
    GenderEnum::MALE()->getName(); // male

Not only that, PhpEnum also provides advanced functionality in subclasses

    GenderEnum::MALE()->idEquals(1); // true
    GenderEnum::MALE()->NameEquals('male'); // true
    GenderEnum::containsId(1); // 1
    GenderEnum::containsName('male'); // 1
    GenderEnum::ofId(1); // enum instance
    GenderEnum::ofName('male'); // enum instance

### Documentation

PhpEnum supports PHP version 5.6+. The documentation for PHPEnum is available on the [Github wiki](https://github.com/yinfuyuan/php-enum/wiki).

### License

The PHPEnum is open-sourced software licensed under the [GPL-3.0 license](https://github.com/yinfuyuan/php-enum/blob/master/LICENSE).
