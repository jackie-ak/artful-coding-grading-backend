# artful coding grading backend

This is a simple script to allow students gather their grade breakdown through
a frontend (or any other means to do a POST request) with their student ID and
an associated secret key.

The script was developed for the course
[Artful Coding: Web-based Game Development](https://tantemalkah.at/2021/artful-coding/)
at the University of Applied Arts Vienna. The grading scheme this was developed
for, is described in the [Session plan for session 1](https://hackmd.io/@jackie/Sk4KcCWBK).

## Setup

In order to protect personal information, make sure to only put this on PHP-enabled
web roots, so that `.php` files will never be sent as source.

Copy the `grades-sample.php` file to `grades.php` and enter the student data.

Make sure to use good key values in the `ids` array. Use e.g. something at least
as good as `pwgen -s 16` to generate keys.
