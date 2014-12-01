<?php
/**
 * @file
 * Copy a directory and replaces $string_in with $string_out
 *
 * @see
 * README.md
 */

// Initialize, global variables.
start($argv);
print(PHP_EOL);

// Starter function.
function start($argv) {
  print_r($argv);

  $root_dir = getcwd();
  $old = $argv[1];
  $new = $argv[2];
  traverse_files_and_folders($root_dir, $old, $new);
}

/**
 * Traverse files and folders.
 *
 * @param $root_dir
 */
function traverse_files_and_folders($root_dir, $old, $new) {
  $files_and_folders = scandir($root_dir);

  // We are still at root level.
  // if the folder contains the string we are looking for copy it and
  // replace the string. Inside this new folder we recursively will rename
  // all files and folders and the file contents.
  foreach ($files_and_folders as $file_or_folder) {
    // If its a directory and its contains the needle, copy the folder.
    if (is_dir($file_or_folder)) {
      $find = strpos($file_or_folder, $old);
      if ($find === 0 || $find > 0) {
        $old_folder = $file_or_folder;
        $new_folder = str_replace($old, $new, $file_or_folder);

        // Create new folder
        $exec = "mkdir " . $new_folder;
        shell_exec($exec);

        // Copy old folder to new folder.
        $exec = "cp -R " . $old_folder . "/* " . $new_folder;
        shell_exec($exec);

        rename_files_and_folders_recursively($root_dir . "/" . $new_folder, $old, $new);
      }
    }
  }
}

/**
 * Traverse files and folders.
 *
 * @param $root_dir .
 */
function rename_files_and_folders_recursively($dir, $old, $new) {
  $files_and_folders = scandir($dir);

  // Check if $needle is found, if so rename file or folder.
  foreach ($files_and_folders as $file_or_folder) {
    $find = strpos($file_or_folder, $old);
    if ($find === 0 || $find > 0) {
      $old_name = $dir . "/" . $file_or_folder;
      $new_name = $dir . "/" . str_replace($old, $new, $file_or_folder);

      rename($old_name, $new_name);
    }
  }

  // If there are folders, repeat this process.
  $renamed_files_and_folders = scandir($dir);
  print_r($renamed_files_and_folders);
  foreach ($renamed_files_and_folders as $file_or_folder) {
    if ($file_or_folder == ".") {
    }
    elseif ($file_or_folder == "..") {
    }
    else {
      $deep_dir = $dir . "/" . $file_or_folder;
      // Check if Dir.
      if (is_dir($deep_dir)) {
        // Call this function again.
        rename_files_and_folders_recursively($deep_dir, $old, $new);
      }
      // If its a file, replace its content.
      else {
        replace_file_content($deep_dir, $old, $new);
      }
    }
  }
}

/**
 * Replace content within a file.
 */
function replace_file_content($file, $old, $new) {
  file_put_contents($file, str_replace($old, $new, file_get_contents($file)));
}
