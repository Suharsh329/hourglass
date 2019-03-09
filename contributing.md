
<h1>Contributing to Hourglass &#8987;</h1>

Thank you for taking the time to contribute to hourglass.

###  Making changes to the [hl](https://www.github.com/suharsh329/hourglass/blob/master/hl) and [hourglass](https://www.github.com/suharsh329/hourglass/blob/master/hourglass) files

If you make changes to the hl and hourglass files present in the root directory, you might come across this error or a variation of it on execution:

```bash

/usr/bin/env: 'php\r': No such file or directory

```

To overcome this, modify the hl_example file and run the following commands to make changes in the hl and hourglass files:

```bash

tr -d '\15'  <hl_example> hl

tr -d '\15'  <hl_example> hourglass  
```

### Tests

#### Test Database
The hourglass.db file is primarily used for storing and displaying tasks and notes. This data can be tested for different output styles.  
Using this file for testing the commands will add unnecessary data to the file and make it tedious to keep deleting test data.    
Instead, I have pointed the test files to run on the test.db file using the MockDatabase class.  
Run the following command to initialize the test database with tables:  
```bash
cat hourglass.sql | sqlite3 test.db
```

Tests for the commands are in the ```tests``` directory.  
There are multiple ways to run the tests:
```bash
composer test-all  

composer test-all-commands

composer test-all-helpers

composer test-command -- --filter 'CommandTestFileName'  

composer test-helper -- --filter 'HelperTestFileName'
```
The first command runs all the tests available in the ```tests``` directory  
The second command runs all the tests available in the ```Commands``` directory    
The third command runs all the tests available in the ```Helpers``` directory  
The fourth command allows you to run a specific test in the ```Commands``` directory  
The last command allows you to run a specific test in the ```Helpers``` directory  
All the mock classes can be found in the ```Mocks``` directory  

The tests in the ```Commands``` directory are integration tests. These commands store the output in the database.  
The tests in the ```Helpers``` directory are of both types (integration and unit).
