<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <style>
        /* Styles from the first code */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 50px;
            animation: fadeIn 1s;
        }

        .record {
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            width: 80%;
            animation: scaleIn 0.5s;
            transition: transform 0.3s;
        }

        .record:hover {
            transform: scale(1.03);
        }

        h2 {
            margin: 0;
            color: #0078d4;
        }

        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
        

        th {
            background-color: #f2f2f2;
        }

        hr {
            border: none;
            border-top: 1px solid #ccc;
            width: 80%;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.9);
            }
            to {
                transform: scale(1);
            }
        }

        /* Styles for the button */
        .button-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: red;
            transform: scale(1.05);
        }

        /* Additional styles */
        .marks-table {
            margin-top: 20px;
        }

        .marks-summary {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <form id="backForm" action="index.php">
            <button type="submit">Back</button>
        </form>
    </div>
    <div class="container">
        <?php
        $jsonData = file_get_contents('student_records.json');
        $data = json_decode($jsonData, true);

        if (isset($_GET['fullname'])) {
            $fullnameToShow = $_GET['fullname'];

            if (!empty($data)) {
                $found = false;
                foreach ($data as $studentID => $student) {
                    if ($student['Fullname'] === $fullnameToShow) {
                        $found = true;
                        echo '<div class="record">';
                        echo '<h2>' . ucwords($student['Fullname']) . ' Record</h2>';
                        echo '<table>';
                        foreach ($student as $key => $value) {
                            if ($key !== 'Fullname' && $key !== 'marks' && $key !== 'total_marks' && $key !== 'average_marks') {
                                echo '<tr>';
                                echo '<td>' . $key . '</td>';
                                echo '<td>';

                                echo $value;

                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        echo '</table>';

                        // Display marks in a separate table with capitalized subject names
                        if (isset($student['marks'])) {
                            echo '<h2>Subject Marks</h2>';
                            echo '<table class="marks-table">';
                            echo '<tr><th>Subject</th><th>Marks</th><th>Grade</th></tr>';
                            foreach ($student['marks'] as $subject => $details) {
                                echo '<tr>';
                                echo '<td>' . ucwords($subject) . '</td>'; // Capitalizing subject names
                                echo '<td>' . $details['marks'] . '</td>';
                                echo '<td>' . $details['grade'] . '</td>';
                                echo '</tr>';
                            }
                            echo '</table>';

                            // Display total marks and average marks
                            echo '<div class="marks-summary">';
                            echo '<p>Total Marks: ' . $student['total_marks'] . '</p>';
                            echo '<p>Average Marks: ' . $student['average_marks'] . '</p>';
                            echo '</div>';
                        }

                        echo '</div>';
                        break;
                    }
                }

                if (!$found) {
                    echo '<p>Record not found!</p>';
                }
            } else {
                echo 'No student records found.';
            }
        } else {
            echo '<p>No fullname specified!</p>';
        }
        ?>
    </div>
</body>
</html>
