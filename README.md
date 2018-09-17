Spring Password Utils
=====================

PHP utilities for encoding and validating passwords in the same way as Spring Security's StandardPasswordEncoder in Java.


Features
--------

* Encoding a password hash in the same way as Spring Security's StandardPasswordEncoder 
* Validating a password against a hash generated from Java or by this library itself

Composer Installation
---------------------
This is a PSR-4 autoloadable library. Please use Composer to add the library to your project:
```json
{
  "require": {
    "darkindy/spring-password-utils": "1.0.0"
  }
}
```

Troubleshooting
---------------
In case you encounter the error message "Call to undefined function openssl_random_pseudo_bytes()"
when encoding a password with an auto-generated salt, please enable openssl by uncommenting the
following lines in your php.ini:
```
extension_dir="ext"
extension=php_openssl.dll
```