<?php
// Start the session
session_start();

// Include questions from the questions.php file
include 'questions.php';

// Variable to store the total number of questions.
$totalQuestions = count($questions);

// Variable to hold index of the question.
$index = array_rand($questions);

// Variable to hold toast message
$toast = null;

// Variable to track whether or not to display the score.
$show_score = false;

// Check if any questions have already been asked. If not initiate session variables.
if (!isset($_SESSION["used_indexes"])) {
    $_SESSION["used_indexes"] = [];
    $_SESSION["total_correct"] = 0;
}

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

// Check if all questions have been asked.
if (count($_SESSION["used_indexes"]) == $totalQuestions) {
    // Reset questions asked variable and show the score.
    $_SESSION["used_indexes"] = [];
    $show_score = true;
} else {
    $show_score = false;
    if (count($_SESSION["used_indexes"]) == 0) {
        $_SESSION["total_correct"] = 0;
        $toast = "";
    }
    // Question selected at random and checked if it has already been asked.
    while (in_array($index, $_SESSION["used_indexes"])) {
        $index = array_rand($questions);
    }
    // Push the index of the last question to the used_indexes array.
    array_push($_SESSION["used_indexes"], $index);
    // Get the array of the current question based on $index.
    $question = $questions[$index];
    // Assign possible answers to the selected question to an associative array and suffle the array.
    $answers = [$question['correctAnswer'], $question['firstIncorrectAnswer'], $question['secondIncorrectAnswer']];
    shuffle($answers);
}