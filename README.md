# Project skeleton in PHP

[![GitHub Release](https://img.shields.io/github/v/release/ManuelGil/project-skeleton)]()
[![GitHub Release Date](https://img.shields.io/github/release-date/ManuelGil/project-skeleton)]()
[![GitHub license](https://img.shields.io/github/license/ManuelGil/project-skeleton)]()

This project is a base for building new projects in PHP.

## Requirements

-   PHP 7.2 or later
-   MySQL or MariaDB
-   Apache Server

## Installation

You can install this project via composer with the following commands:

```bash
$ composer create-project manuelgil/moodle-alternate-admin {directory} --prefer-dist
```

## Configure the project

- Create a new database.

- Import the [database.sql](./docs/database.sql) file.

-   Copy the [`.env.example`](./.env.example)
    file and call it `.env`.

```bash
$ cp .env.example .env
```

-   Edit the environment variables in the .env file as you need.

-   Make www-data the owner to `logs` folder.

```bash
$ sudo chown www-data: logs/
```

## Changelog

See [CHANGELOG.md](./CHANGELOG.md)

## Code of Conduct

See [CODE_OF_CONDUCT](./.github/CODE_OF_CONDUCT.md).

## Authors

-   **Manuel Gil** - _Owner_ - [ManuelGil](https://github.com/ManuelGil)

See also the list of [contributors](https://github.com/ManuelGil/project-skeleton/contributors) who participated in this project.

## License

Project skeleton is licensed under the MIT License - see the [MIT License](https://opensource.org/licenses/MIT) for details.
