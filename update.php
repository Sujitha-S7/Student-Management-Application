<!DOCTYPE html>
<html>
<head>
    <title>Update Student Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 20px;
        }

        table {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-collapse: collapse;
            width: 100%;
        }

        table tr td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        table tr:last-child td {
            border-bottom: none;
        }

        input[type="text"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        input[type="submit"]:hover {
            background-color: red;
            transform: scale(1.05);
        }

        h1 {
            text-align: center;
            color: #007BFF;
        }

        .form-container {
            display: flex;
            justify-content: center;
        }

        .form-section {
            width: 50%;
        }

        .form-section label {
            font-weight: bold;
            margin-top: 10px;
            display: block;
        }

        .form-section input[type="text"] {
            width: calc(100% - 20px);
        }
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
    </style>
</head>
<body>
    <h1>Update Student Record</h1>
    <div class="button-container">
            <form id="backForm" action="index.php">
                <button type="submit">Back</button>
            </form>
  </div>
    <div class="form-container">
        <div class="form-section">
        <?php
// Function to calculate the grade based on marks
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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fullname'])) {
    $jsonContent = file_get_contents('student_records.json');
    $data = json_decode($jsonContent, true);

    $fullnameToUpdate = $_GET['fullname'];
    $recordToUpdate = null;

    foreach ($data as $record) {
        if ($record['Fullname'] === $fullnameToUpdate) {
            $recordToUpdate = $record;
            break;
        }
    }

    if ($recordToUpdate !== null) {
        echo '<form method="post">';
        echo '<table>';
        foreach ($recordToUpdate as $key => $value) {
            echo '<tr>';
            echo '<td>' . $key . '</td>';
            echo '<td>';

            if (is_array($value)) {
                // If the value is an array (marks), handle each subject's marks and grades
                foreach ($value as $subject => $details) {
                    echo '<label>' . $subject . '</label><br>';
                    echo 'Marks: <input type="text" name="' . $key . '[' . $subject . '][marks]" value="' . $details['marks'] . '"><br>';
                    echo 'Grade: <input type="text" name="' . $key . '[' . $subject . '][grade]" value="' . $details['grade'] . '"><br>';
                }
            } else {
                // If the value is not an array, display it within an input field
                echo '<input type="text" name="' . $key . '" value="' . $value . '">';
            }

            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '<br>'; 
        echo '<input type="submit" name="update" value="Update Record">';
        echo '</form>';
    } else {
        echo '<script>alert("Record not found!");</script>';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $jsonContent = file_get_contents('student_records.json');
    $data = json_decode($jsonContent, true);

    $fullnameToUpdate = $_POST['Fullname'];

    foreach ($data as $key => $record) {
        if ($record['Fullname'] === $fullnameToUpdate) {
            $totalMarks = 0;
            $subjectCount = 0;

            foreach ($record as $field => $value) {
                if (isset($_POST[$field])) {
                    // Update fields including marks and grades
                    if (is_array($_POST[$field])) {
                        foreach ($_POST[$field] as $subject => $subjectDetails) {
                            $marks = $subjectDetails['marks'];
                            $data[$key][$field][$subject]['marks'] = $marks;
                            $data[$key][$field][$subject]['grade'] = calculateGrade($marks);

                            // Recalculate total and average marks
                            $totalMarks += $marks;
                            $subjectCount++;
                        }
                    } else {
                        // Update regular fields
                        $data[$key][$field] = $_POST[$field];
                    }
                }
            }

            // Update total and average marks
            $data[$key]['total_marks'] = $totalMarks;
            $data[$key]['average_marks'] = ($subjectCount > 0) ? round($totalMarks / $subjectCount, 2) : 0;

            file_put_contents('student_records.json', json_encode($data, JSON_PRETTY_PRINT));

            echo '<script>alert("Record updated successfully!");</script>';
            echo '<script>window.location.replace("index.php");</script>';
            break;
        }
    }
}
?>
        </div>
    </div>
</body>
</html>
