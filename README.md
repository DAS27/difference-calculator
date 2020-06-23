# different-caluculator
![PHP CI](https://github.com/DAS27/difference-calculator/workflows/PHP%20CI/badge.svg)
[![Maintainability](https://api.codeclimate.com/v1/badges/9fd09b555b603b9d9747/maintainability)](https://codeclimate.com/github/DAS27/php-project-lvl2/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/9fd09b555b603b9d9747/test_coverage)](https://codeclimate.com/github/DAS27/php-project-lvl2/test_coverage)


### Installation

Use [Composer](https://getcomposer.org/)

```bash
$ composer global require damir/difference-calculator:dev-master
```

## Setup

```sh
$ git clone https://github.com/DAS27/difference-calculator.git

$ make install
```

## Run tests

```sh
$ make test
```

### Usage
Execute in bash:

```
gendiff [--format <fmt>] <firstFile> <secondFile>
```

Format is optional and have `pretty` output format by default. So you don't need to specify a format and can execute like this:
```
gendiff <firstFile> <secondFile>
```
or explicitly specifying the desired format:
```
gendiff --format pretty <firstFile> <secondFile>
```
[![asciicast](https://asciinema.org/a/WBPYE0IERQfoh0Z6slSCRFIoM.svg)](https://asciinema.org/a/WBPYE0IERQfoh0Z6slSCRFIoM)

```
gendiff --format plain <firstFile> <secondFile>
```
[![asciicast](https://asciinema.org/a/OGXNFm7iM2o6Hoya9rt9iTzHi.svg)](https://asciinema.org/a/OGXNFm7iM2o6Hoya9rt9iTzHi)

```
gendiff --format json <firstFile> <secondFile>
```
[![asciicast](https://asciinema.org/a/tZmzWa6T27ozpElLQwDfJJ0Ds.svg)](https://asciinema.org/a/tZmzWa6T27ozpElLQwDfJJ0Ds)