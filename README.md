# Phpactor Distribution

This package distributes [Phpactor] and namespace-isolated dependent classes.

## How to install

```
composer global require zonuexe/phpactor-dist
```

**Note:**: This repository is a proof of concept to propose to the Phpactor mainstream. Do not depends on this package as it will be removed without notice.

## Why "dist" package?

Applications generally avoid reinventing the wheel by relying on many external packages. However, when you install multiple tools at the same time, they often fail to install due to version conflicts or fall back to unintended older versions.

That's because Composer only allows you to depend on a single version per package. [php-scoper] provides namespace isolation by adding a prefix to dependent classes. By bundling "isolated" versions of those libraries, dist packages can remove dependencies.

[Phpactor]: https://github.com/phpactor/phpactor
[php-scoper]: https://github.com/humbug/php-scoper
