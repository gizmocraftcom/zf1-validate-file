# Changelog
## 2.0.0
Fork of `diablomedia/zendframework1-validate-file`, published as `gizmocraft/zendframework1-validate-file`.
### Breaking changes
- Requires PHP `>=8.5`. Tested on PHP 8.5 and 8.6.
- Package renamed from `diablomedia/zendframework1-validate-file` to `gizmocraft/zendframework1-validate-file`. It now requires `gizmocraft/zendframework1-config` `^3.0.0`, `gizmocraft/zendframework1-loader` `^2.0.0` and `gizmocraft/zendframework1-validate` `^2.0.0`.
### Fixes
- PHP 8.6 throws a `ValueError` from `is_readable()`, `file_exists()`, `filesize()` and the finfo/hash functions for paths containing NUL bytes. The file validators (Crc32, ExcludeExtension, ExcludeMimeType, Exists, Extension, FilesSize, Hash, ImageSize, IsCompressed, IsImage, Md5, MimeType, NotExists, Sha1, Size, WordCount) now treat such a path as unreadable or not existing and report the normal validation error. `Zend_Validate_File_MimeType::setMagicFile()` throws `Zend_Validate_Exception` for such a path. No public signatures changed.
- `Zend_Validate_File_MimeType::$_finfo` is documented as `finfo|null` (it has been an object since PHP 8.1); the PHPStan ignore for it and `phpstan-php81+.php` were removed.
### Other changes
- Dev dependencies upgraded (PHPUnit 13, PHPStan 2.3, php-cs-fixer 3.95, GrumPHP 2.27). Dropped `composer-require-checker`, which has no release for PHP 8.6.
- Tests migrated to PHPUnit 13 attributes (`#[Group]`, `#[DoesNotPerformAssertions]`); `phpunit.xml.dist` fails on warnings and risky tests. Added `NullByteTest`.
- CI runs PHP 8.5 and 8.6.
