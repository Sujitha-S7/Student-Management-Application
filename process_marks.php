<?php
function calculateGrade($marks) {
    if ($marks >= 90) {
        return 'A+';
    } elseif ($marks >= 80) {
        return 'A';
    } elseif ($marks >= 70) {
        return 'B';
    } elseif ($marks >= 60) {
        return 'C';
    } elseif ($marks >= 50) {
        return 'D';
    } else {
        return 'F';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    // Check if the student ID is set in the form or generate a unique ID
    $studentID = isset($_POST['student_id']) ? $_POST['student_id'] : uniqid();

    // Check if a file for storing student records exists
    $file = 'student_records.json';
    $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

    // Initialize student record if it doesn't exist for the given ID
    if (!isset($data[$studentID])) {
        $data[$studentID] = [
            'Fullname' => $_POST['Fullname'],
            'Age' => $_POST['Age'],
            'dob' => $_POST['dob'],
            'Class' => $_POST['Class'],
            'marks' => [],
            'total_marks' => 0,
            'average_marks' => 0,
        ];
    }

    // Process and store each subject's marks
    $totalMarks = 0;
    $subjectCount = 0;
    $subjects = ['discrete', 'agent', 'coa', 'paradigms', 'algorithms', 'dbms'];

    foreach ($subjects as $subject) {
        if (isset($_POST[$subject])) {
            $marks = (float)$_POST[$subject];
            $totalMarks += $marks;
            $subjectCount++;

            // Calculate grade based on marks
            $grade = calculateGrade($marks);

            // Store subject marks in the student's record
            $data[$studentID]['marks'][$subject] = [
                'marks' => $marks,
                'grade' => $grade,
            ];
        }
    }

    $averageMarks = $subjectCount > 0 ? round($totalMarks / $subjectCount, 2) : 0;

    $data[$studentID]['total_marks'] = $totalMarks;
    $data[$studentID]['average_marks'] = $averageMarks;

    // Save the updated data back to the file
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

    echo '<script>';
    echo 'alert("Data saved successfully for Student ID: ' . $studentID . '");';
    echo 'window.location.href = "sm1.php";'; 
    echo '</script>';
}
?>