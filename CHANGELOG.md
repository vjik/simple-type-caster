# Simple Type Caster Change Log

## 0.3.0 March 15, 2024

- Add options "min" and "max" to `TypeCaster::toIntOrNull()`.
- Add `TypeCaster::toNonNegativeIntOrNull()`.
- Add psalm type `non-empty-string|null` to result of `TypeCaster::toStringOrNull()`.
- Raise minimal PHP version to 8.1.

## 0.2.4 June 15, 2023

- Add `TypeCaster::toString()`.

## 0.2.3 October 24, 2022

- Fix `TypeCaster::toStringOrNull()` when value is array.

## 0.2.2 April 27, 2021

- Add `TypeCaster::toArrayOrNull()`.

## 0.2.1 March 30, 2021

- Add PHP 8 support.

## 0.2.0 March 04, 2021 

- Add `TypeCaster::toFloatOrNull()`.
- `TypeCaster::toIntOrNull()` support for values any type.

## 0.1.0 Decembry 10, 2020

- Initial release.
