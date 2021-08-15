<h1 align="center">Hourglass &#8987;</h1>

## Description

Hourglass is a simple application that allows users to manage tasks and notes from the command line. And the best part, it's written in PHP!  
A command line application written in PHP? WHY?!  
The release of PHP 7 has truly changed the way we write code in the language and on top of that, [Symfony](https://symfony.com/), provides a phenomenal interface for designing cli apps. PHP also has built-in support for SQLite; a self-contained, embedded database engine. PHP 7 + Relational Database seems like a good combo to me.   
Moving on from the technical jargon, we know that developers spend a lot of time in the terminal. It's a convenient place to store and access data. A more streamlined workflow ensues when the developer uses the command line to keep track of their tasks and notes. Plus, having a to-do list in the terminal means there is more room for StackOverflow tabs in the browser.  

## Table of Contents

<!--ts-->
   * [Description](#description)
   * [Table of Contents](#table-of-contents)
   * [Installation](#installation)
   * [Features](#features)
   * [Usage](#usage)
      * [Examples](#examples)
      * [List of Commands](#list-of-commands)
	      * [List Command](#list-command)
	      * [Help Command](#help-command)
         * [Task Command](#task-command)
         * [Note Command](#note-command)
         * [Print Command](#print-command)
         * [Check Command](#check-command)
         * [Delete Command](#delete-command)
         * [Update Command](#update-command)
         * [Move Command](#move-command)
         * [Filter Command](#filter-command)
	      * [Pomodoro Command](#pomodoro-command)
	      * [Generate Database Command](#generate-database-command)
   * [Backup & Sync](#backup-&-sync)
   * [Settings](#settings)
   * [Development](#development)
   * [License](#license)
<!--te-->

### Requirements

[sqlite3](https://www.sqlite.org/index.html)

[php]()

*You will also require*, **php-xml**, **php-mbstring** *and* **php-sqlite3**

### Installation

Install with [composer](https://getcomposer.org/)  

```bash
git clone git@github.com:Suharsh329/hourglass.git

cd hourglass

composer install

./hl generate or ./hl g (Make sure the .hourglass directory exists inside your home directory)
```

Allow hl and hourglass files to be executable  

If hl command does not work, use ./hl (Same with hourglass)

## Features

### Available

* Board based tasks and notes
* Data is stored in SQLite database
* Specify due date
* Update entry details
* Move entries across boards
* Filter entries

### In Progress

* Pomodoro
* Statistics
* Settings
* Archives
* GUI

## Usage

### Examples

```bash
hl l [Lists all available commands and options]  

hl [Displays all tasks and notes]  

hl t This is a task -b Coding [Adds a task to the coding board]
```

### List of Commands

#### List Command
##### Shortcut: hl l Expanded command: hourglass list
Displays application name and version along with list of commands and display options

#### Help Command
##### Shortcut: hl h Expanded command: hourglass help
General overview of help
```bash
hl h
```

Help for a specific command
```bash
hl h t
hl h task
```
*Specify the first letter of the command or the whole command*

#### Task Command  
##### Shortcut: hl t Expanded command: hourglass task  
Without a board specified, the task belongs to the Main board
```bash
hl t My first task
```

With a board specified; a new board will be created if it does not exist
```bash
hl t My first task -b board1,board2
```
*Each board name is separated by a comma with no spaces (hyphens and underscores are allowed)*

Specify due date of task (Default Indefinite)  
```bash
hl t My first task -d 5 
```
*The task is due in 5 days*

#### Note Command  
##### Shortcut: hl n Expanded command: hourglass note  
Without a board specified, the note belongs to the Main board
```bash
hl n My first note
```

With a board specified; a new board will be created if it does not exist  
```bash
hl n My first note -b board1,board2
```
*Each board name is separated by a comma with no spaces (hyphens and underscores are allowed)*

#### Print Command  
##### Shortcut: hl Expanded command: hourglass
Prints out board-wise tasks and notes
```bash
hl
```

#### Check Command
##### Shortcut: hl c Expanded command: hourglass check
Command checks or un-checks tasks for the specified boards (Default Main)
```bash
hl c 1,2 -b coding
```

#### Delete Command
##### Shortcut: hl d Expanded command: hourglass delete
To delete all the entries
```bash
hl d
```

To delete a board or multiple boards
```bash
hl d -b board1,board2
```

To delete entries from specific boards (Default Main)
```bash
hl d 1,2 -b board1,board2
```

#### Update Command
##### Shortcut: hl u Expanded command: hourglass update
To update task or note description, provide id of entry and new description  
Default board is Main
```bash
hl u 1 Updated description -b board
```

To change task to note or note to task
```bash
hl u 1 --change
```
*On changing task to note, due date will change to 'Indefinite' and the task will be un-checked*

To update due date
```bash
hl u 1 -d 5
```
*Number after **-d** is the number of days due from the day it is updated  
To specify current day as due date, enter 00  
To remove due date enter 000*  
**You cannot specify due date for a note**

To update board name, provide the new name  
**You cannot rename board 'Main'**
```bash
hl u board2 -b board
```

Update all in one line
```bash
hl u 1 Updated description -d 5 --change -b board
```

#### Move Command
##### Shortcut: hl m Expanded command: hourglass move
Move one or more entries to board2 from board1
```bash
hl m 1,2 -b board2,board1
```
*A new board will be created if it does not exist*

#### Filter Command
##### Shortcut: hl f Expanded command: hourglass filter
Filter entries alphabetically
```bash
hl f a
```
*Entries will still be displayed board-wise*

Filter tasks with due-dates
```bash
hl f d
```

Filter tasks with due-dates within 'x' number of days
```bash
hl f d 5
```
*The above command will display tasks due in the next 5 days*

Filter notes
```bash
hl f n
```

Filter tasks
```bash
hl f t
```

Filter tasks as complete or incomplete
```bash
hl f t c
hl f t i
```

#### Pomodoro Command
##### Shortcut: hl p Expanded command: hourglass pomodoro
Start pomodoro timer  
Timer for 15 minutes
```bash
hl p -t 15
```
*Default time is 25 minutes*

Specify task id to complete a specific task  
Default board is Main
```bash
hl p 1 -b board
```
*On completion of timer, the task will be tick-marked. (Not implemented yet)*

#### Generate Database Command
##### Shortcut: hl g Expanded command: hourglass generate
Generate database file in case of user deleted the database or wants extra databases. 
```bash
hl g
```
*Default path is /home/username/.hourglass*

Specify path  
```bash
hl g /path/for/new/database
```

## Backup & Sync
How do I synchronize the application on multiple devices and keep a backup of the database?   
One option is to store the backup on an external hard-drive, but to use that copy for multiple devices can become tedious.  
Another option is to store it on the cloud. Most cloud platforms come with desktop applications that allow the user to sync data between a specific local folder and the user's cloud account.  
I suggest looking at this option as it is easy to get started with.
##### Cloud Platforms
*Google Drive - only for Mac and Windows*  
*Dropbox - supports all platforms*  

There are many others but I have not checked them out.

##### Accessing the database file
If you do choose to sync the file using the above mentioned method, then the question arises, how will the application know where to look for the database file?  
The location of the file can be put in the `settings.json` file. Look at the next section for more details.

## Settings
The settings usage for this application has still not been implemented as of yet. I will be working on it alongside the other in-progress work, but it might not be a part of the first version.  
The main point of creating a settings file is to allow the user to have more flexibility. I'm looking to add settings for color scheme, database file location, etc.  
Currently the settings.json file looks like this:
```json
{
  "db-path": "~/hourglass/",
  "_comment": "Colors can be white, magenta, black, red, cyan, green, yellow, default",
  "color": {
     "board": "white",
     "numbers": "white",
     "text": "cyan",
     "icon": "white",
     "background": "default",
  }
}
```
**Changing values in this file will not reflect in the application for the time being**

## Development

If you would like to contribute to this project, please have a look at the [contributing guideline](https://github.com/Suharsh329/hourglass/blob/master/contributing.md).

## Related 

[taskbook](https://github.com/klaussinani/taskbook) - The OG app (JS based)

## License

[MIT](https://github.com/Suharsh329/hourglass/blob/master/LICENSE)
