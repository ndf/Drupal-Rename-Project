Drupal-Rename-Project
=====================

PHP script to rename a Drupal Project namespace including its folder(s), file(s) and all instances inside all files. Useful while developing to convert a misnamed module like my_custom_tryout_module to this_is_good.

Why?
  Copy a Drupal feature and rename it for a specific project.
  Build an new module and afterwards rename it.


Prerequisites
  > OSX/Unix:
  1. PHP-Cli installed and added to path variables. (so you can call 'php' from the command line.)

  > Windows:
  1. PHP-Cli installed and added to environmental variables. (so you can call 'php' from the command line.)
  2. Cygwin or OpenSSH installed so you have the Unix "CP" command available.
  If you can call "cp --help" from the command-line your fine.
  @see: http://en.wikipedia.org/wiki/Cp_%28Unix%29


Usage:
  1. Navigate to parent folder of the project that shall be renamed
  (../sites/all when your project is ../sites/all/module_to_be_renamed
  2. Call this script and pass 'module_to_be_renamed' and 'new_module' as arguments.

$ php --file "~/Scripts/Drupal-Rename-Project.php" module_to_be_renamed new_module