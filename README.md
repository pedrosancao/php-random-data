# Simple high entropy random data generator

This small library generates high entropy data from /dev/urandom

Current supported only UNIX based systems

## Formats

Generate data in these formats:

- integer
- hexadecimal

## Usage

- include Random.php
- run `Random::int($length)` or `Random::hex($length)`

## To do list

- create fallback for Windows systems
- add new types (raw, text, dummy base64, etc.)
- add compliance with [PSR-4](http://www.php-fig.org/psr/psr-4/) (or [PST-0](http://www.php-fig.org/psr/psr-0/)) autoload standards
- add composer

## Licence

MIT, see LICENCE.

## Recommended reading

- [Insufficient Entropy For Random Values](http://phpsecurity.readthedocs.org/en/latest/Insufficient-Entropy-For-Random-Values.html)
