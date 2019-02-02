
<h1>Contributing to Hourglass &#8987;</h1>

Thank you for taking the time to contribute to hourglass.

###  Making changes to the [hl](https://www.github.com/suharsh329/hourglass/blob/master/hl) and [hourglass](https://www.github.com/suharsh329/hourglass/blob/master/hourglass) files

If you make changes to the hl and hourglass files present in the root directory, you might come across this error or a variation of it on execution:

```bash

/usr/bin/env: ‘php\r’: No such file or directory

```

To overcome this, modify the hl_example file and run the following commands to make changes in the hl and hourglass files:

```bash

tr -d '\15'  <hl_example> hl

tr -d '\15'  <hl_example> hourglass