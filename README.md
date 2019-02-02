<h1 align="center">Hourglass &#8987;</h1>

## Description

A command line application written in PHP? WHY?!  
The release of PHP 7 has truly changed the way we write code in the language and on top of that [Symfony](https://symfony.com/) provides a phenomenal interface for designing cli apps. 

## Table of Contents

<!--ts-->
   * [Description](#description)
   * [Table of Contents](#table-of-contents)
   * [Installation](#installation)
   * [Features](#features)
   * [Usage](#usage)
      * [Examples](#examples)
      * [List of Commands](#list-of-commands)
        * [Task Command](#task-command)
   * [Development](#development)
   * [License](#license)
<!--te-->

### Requirements

[sqlite3](https://www.sqlite.org/index.html)

### Installation

Install with [composer](https://getcomposer.org/)  

```bash

git clone git@github.com:Suharsh329/hourglass.git

cd hourglass

composer install
```

Allow hl and hourglass files to be executable  

If hl command does not work, use ./hl (Same with hourglass)

## Features

### Available

* Board based tasks and notes.
* Data is stored in SQLite database.
* Specify due date.

### In Progress

* Search
* Move

## Usage

### Examples

```bash
hl //Displays all tasks and notes

hl t This is a task -b Coding //Adds a task to the coding board
```

### List of Commands

#### Task Command  
##### Shortcut: hl t Expanded command: hourglass task  
Without a board specified, the task belongs to the main board.
```bash
hl t My first task
```

With a board specified; a new board will be created if it does not exist.
```bash
hl t My first task -b Board1,Board2
```
Each board name is separated by a comma with no spaces (hyphens and underscores are allowed)  

Specify due date of task. Default Indefinite.  
```bash
hl t My first task -d 5
```
The task is due in 5 days.

## Development

If you would like to contribute to this project, please have a look at the [contributing guideline](https://github.com/Suharsh329/hourglass/blob/master/contributing.md).


## Related 

[taskbook](https://github.com/klaussinani/taskbook) - The OG app (JS based)

## License

[MIT](https://github.com/Suharsh329/hourglass/blob/master/LICENSE)
