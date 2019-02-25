<h1 align="center">Hourglass &#8987;</h1>

## Description

A command line application written in PHP? WHY?!  
The release of PHP 7 has truly changed the way we write code in the language and on top of that [Symfony](https://symfony.com/) provides a phenomenal interface for designing cli apps.  
Hourglass is a simple application that allows users to manage tasks and notes from the command line. 

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
        * [Note Command](#note-command)
        * [Print Command](#print-command)
        * [Check Command](#check-command)
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

cat hourglass.sql | sqlite3 hourglass.db
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
hl [Lists all avaialble commands and options]  

hl p [Displays all tasks and notes]  

hl t This is a task -b Coding [Adds a task to the coding board]
```

### List of Commands

#### Task Command  
##### Shortcut: hl t Expanded command: hourglass task  
Without a board specified, the task belongs to the Main board.
```bash
hl t My first task
```

With a board specified; a new board will be created if it does not exist.
```bash
hl t My first task -b board1,board2
```
Each board name is separated by a comma with no spaces (hyphens and underscores are allowed)  

Specify due date of task. Default Indefinite.  
```bash
hl t My first task -d 5
```
The task is due in 5 days.

#### Note Command  
##### Shortcut: hl n Expanded command: hourglass note  
Without a board specified, the note belongs to the Main board.
```bash
hl n My first note
```

With a board specified; a new board will be created if it does not exist.
```bash
hl n My first note -b Board1,Board2
```
Each board name is separated by a comma with no spaces (hyphens and underscores are allowed)  

#### Print Command  
##### Shortcut: hl p Expanded command: hourglass print  
Prints out board-wise tasks and notes.
```bash
hl p
```

#### Check Command
##### Shortcut: hl c Expanded command: hourglass ch
Command checks or un-checks tasks for the specified boards (Default Main)
```bash
hl c 1,2 -b coding
```

## Development

If you would like to contribute to this project, please have a look at the [contributing guideline](https://github.com/Suharsh329/hourglass/blob/master/contributing.md).

## Related 

[taskbook](https://github.com/klaussinani/taskbook) - The OG app (JS based)

## License

[MIT](https://github.com/Suharsh329/hourglass/blob/master/LICENSE)
