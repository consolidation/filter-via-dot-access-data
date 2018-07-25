# FilterViaDotAccessData

This project uses [dflydev/dot-access-data](https://github.com/dflydev/dot-access-data) to provide simple output filtering for applications built with [annotated-command](https://github.com/consolidation/annotated-command) / [Robo](https://github.com/consolidation/robo).

[![Travis CI](https://travis-ci.org/consolidation/filter-via-dot-access-data.svg?branch=master)](https://travis-ci.org/consolidation/filter-via-dot-access-data)
[![Windows CI](https://ci.appveyor.com/api/projects/status/o37b8kff7ai4yyer?svg=true)](https://ci.appveyor.com/project/greg-1-anderson/filter-via-dot-access-data)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/consolidation/filter-via-dot-access-data/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/consolidation/filter-via-dot-access-data/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/consolidation/filter-via-dot-access-data/badge.svg?branch=master)](https://coveralls.io/github/consolidation/filter-via-dot-access-data?branch=master) 
[![License](https://img.shields.io/badge/license-MIT-408677.svg)](LICENSE)

## Overview

This project provides a simple logic expression evaluator which can be used in conjunction with [dflydev/dot-access-data](https://github.com/dflydev/dot-access-data) to filter out results of the sort that you might return as a RowsOfFields object, or a nested yaml/json array.

### Commandline Tool

This project is bundled with a simple commandline tool, `dot-process`. It is similar to a simple version of `jq`. It is intended for demonstration purposes only.
```
# Write out composer.json in yaml format
$ dot-process.phar edit composer.json --format=yaml
```
This demo tool will become more functional over time. It is only intended to be a demo, though, not a supported utility.

## Getting Started

To build this project locally, follow the steps below.

### Prerequisites

Install dependencies:

```
composer install
```

If you wish to build the phar for this project, install the `box` phar builder via:

```
composer phar:install-tools
```

## Running the tests

The test suite may be run locally by way of some simple composer scripts:

| Test             | Command
| ---------------- | ---
| Run all tests    | `composer test`
| PHPUnit tests    | `composer unit`
| PHP linter       | `composer lint`
| Code style       | `composer cs`     
| Fix style errors | `composer cbf`


## Deployment

Deploy by the following procedure:

- Edit the `VERSION` file to contain the version to release, and commit the change.
- Run `composer release`

## Built With

List significant dependencies that developers of this project will interact with.

* [Composer](https://getcomposer.org/) - Dependency Management
* [Robo](https://robo.li/) - PHP Task Runner
* [Symfony](https://symfony.com/) - PHP Framework

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [releases](https://github.com/consolidation/filter-via-dot-access-data/releases) page.

## Authors

* **Greg Anderson** - created project from template.

See also the list of [contributors](https://github.com/consolidation/filter-via-dot-access-data/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Acknowledgments

* Hat tip to anyone who's code was used
* Inspiration
* etc
* Thanks to PurpleBooth for the [example README template](https://gist.github.com/PurpleBooth/109311bb0361f32d87a2)