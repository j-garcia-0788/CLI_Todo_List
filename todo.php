<?php

// Create array to hold list of todo items
$items = array();

// List array items formatted for CLI
 function listItems($list) { 
    $string = '';
    foreach($list as $key => $item) {
        $key++;
        $string .= "[{$key}] {$item}" . PHP_EOL;
    }
    
    return $string;

     // Return string of list items separated by newlines.
     // Should be listed [KEY] Value like this:
     // [1] TODO item 1
     // [2] TODO item 2 - blah
     // DO NOT USE ECHO, USE RETURN
 }

 // Get STDIN, strip whitespace and newlines,
 // and convert to uppercase if $upper is true
function getInput($lower = false) {
    
    if($lower) {
        return strtolower(trim(fgets(STDIN)));
    } else {
        return trim(fgets(STDIN));
    }           
}
function sort_menu($items) {
    $input = getInput(true);
    switch ($input) {
        
        case 'a':
            asort($items);
            break;
        case 'z':    
            arsort($items);
            break;
        case 'o':
            ksort($items);
            break;
        case 'r':
            krsort($items);
            break;       
    }    
    return $items;
}

function openfile($filename) {

        $handle = fopen($filename, 'r');
        $contents = fread($handle, filesize($filename));
        $contentsArray = explode("\n", $contents);
        fclose($handle);
        
        return $contentsArray;
}

// The loop!
do {
    // Iterate through list items
    foreach ($items as $key => $item) {
        $key++; //starts at 1 instead of zero
        // Display each item and a newline
        echo "[{$key}] {$item}\n";
    }

    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort, (O)pen, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = getInput(true);

    // Check for actionable input
    if ($input == 'n') {
        // Ask for entry
        echo 'Enter item: ';
        // Add entry to list array
        $newItem = getInput();
        
        if (empty($items)){
            $items[] = $newItem;
        } else {
            echo 'Enter b if you would like it at the beginning of your list, hit enter for the bottom: ';
            $choice = getInput(true);

            if ($choice == 'b') {
                array_unshift($items, $newItem);
            }
            else {
                $items[] = $newItem;
            }
        }    

    } elseif ($input == 'r') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $key = getInput();
        // Remove from array
        $key--;
        unset($items[$key]);

    } elseif ($input == 's') {
        echo 'Sort items: (A)-Z, (Z)-A, (O)rder entered, (R)everse order entered: ';
        $items = sort_menu($items);

    } elseif ($input == 'o') {
        echo 'Open file: ';
        $filename = getinput();
        $open_items_array = openfile($filename);
        $items = array_merge($items, $open_items_array);

    } elseif ($input == 'f') {
        array_shift($items);
    } elseif ($input == 'l') {
        array_pop($items);
    }


// Exit when input is (Q)uit
} while ($input != 'q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);