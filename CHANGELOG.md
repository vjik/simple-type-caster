# Simple Type Caster Change Log

## 0.4.2 October 31, 2024

- Add `TypeCaster::toListOfNonEmptyStrings()`.

## 0.4.1 October 21, 2024

- Add `TypeCaster::toListOfBackedEnums()`.

## 0.4.0 September 26, 2024

- Add `$trim` argument to `TypeCaster::toString()` and `TypeCaster::toStringOrNull()`, default is false.

## 0.3.3 September 16, 2024

- Add `TypeCaster::toBackedEnumOrNull()`.
- Fix error in `TypeCaster::toArrayOfBackedEnums()` when raw value is incorrect.

## 0.3.2 August 08, 2024

- Add `TypeCaster::toArrayOfBackedEnums()`.

## 0.3.1 March 26, 2024

- Unfinalize `TypeCaster`.

## 0.3.0 March 25, 2024

- Add options "min" and "max" to `TypeCaster::toIntOrNull()`.
- Add `TypeCaster::toNonNegativeIntOrNull()` and `TypeCaster::toPositiveIntOrNull()`.
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
