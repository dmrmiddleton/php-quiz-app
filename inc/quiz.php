<?php
// Start the session
session_start();

// Include questions from the questions.php file
include 'questions.php';

// Variable to store the total number of questions.
$totalQuestions = count($questions);

// Variable to hold toast message
$toast = null;

// Make a variable to determine if the score will be shown or not. Set it to false.

// Variable to hold index of the question. Question selected at random.
$index = array_rand($questions);

// Get the array of the current question based on $index.
$question = $questions[$index];

// Assign possible answers to the selected question to an associative array and suffle the array.
$answers = [$question['correctAnswer'], $question['firstIncorrectAnswer'], $question['secondIncorrectAnswer']];
shuffle($answers);


// Check if correct answer was chosen and set appropriate toast message
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($_POST['answer'] == $questions[$_POST['index']]['correctAnswer']) {
        $toast = "Well done! That's correct.";
        // Increase correct answer count by one.
        $_SESSION["total_correct"] += 1;
    } else {
        $toast = "Bummer! That was incorrect.";
    }
}

// Check if any questions have already been asked. If not initiate session variables.
if (!isset($_SESSION["used_indexes"])) {
    $_SESSION["used_indexes"] = [];
    $_SESSION["total_correct"] = 0;
}

// Push the index of the last question to the used_indexes array,
array_push($_SESSION["used_indexes"], $index);

/*
  If the number of used indexes in our session variable is equal to the total number of questions
  to be asked:
        1.  Reset the session variable for used indexes to an empty array 
        2.  Set the show score variable to true.

  Else:
    1. Set the show score variable to false 
    2. If it's the first question of the round:
        a. Set a session variable that holds the total correct to 0. 
        b. Set the toast variable to an empty string.
        c. Assign a random number to a variable to hold an index. Continue doing this
            for as long as the number generated is found in the session variable that holds used indexes.
        d. Add the random number generated to the used indexes session variable.      
        e. Set the individual question variable to be a question from the questions array and use the index
            stored in the variable in step c as the index.
        f. Create a variable to hold the number of items in the session variable that holds used indexes
        g. Create a new variable that holds an array. The array should contain the correctAnswer,
            firstIncorrectAnswer, and secondIncorrect answer from the variable in step e.
        h. Shuffle the array from step g.
*/

