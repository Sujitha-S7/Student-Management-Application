<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <style>
                body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        header {
            background-color: #0078d4;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }
        .button-container {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .button-container:hover {
            background-color: red;
            transform: scale(1.05);
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: tableFadeIn 1s ease-in-out;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #0078d4;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: #005da3;
            transform: scale(1.05);
        }

        #studentDetails {
            display: none;
            margin-top: 20px;
        }

        iframe {
            width: 100%;
            height: 400px;
            border: none;
        }

        @keyframes tableFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .view-button {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            background-color: #007bff;
            color: white;
            text-decoration: none;
        }

        .view-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .update-button {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            background-color: #007bff;
            color: white;
            text-decoration: none;
        }

        .update-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .delete-button {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
        }

        .delete-button:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }
        .button-space {
            margin-left: 70px; /* Adjust as needed */
        }

    </style>
</head>
<body>
    <header>
        <h1>STUDENT RECORD</h1>
        <div class="button-container">
            <form id="backForm" action="sm1.php">
                <button type="submit">Back</button>
            </form>
        </div>
    </header><br><br>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Age</th>
                <th>Date of Birth</th>
                <th>Class</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $jsonContent = file_get_contents('student_records.json');
            $data = json_decode($jsonContent, true);

            if ($data) {
                foreach ($data as $record) {
                    echo "<tr>";
                    echo "<td>" . $record['Fullname'] . "</td>";
                    echo "<td>" . $record['Age'] . "</td>";
                    echo "<td>" . $record['dob'] . "</td>";
                    echo "<td>" . $record['Class'] . "</td>";
                    echo "<td>";
                    echo "<span class='button-space'></span>";
                    echo "<span class='button-space'></span>";
                    echo "<a href='view.php?fullname=" . urlencode($record['Fullname']) . "' class='view-button'>View</a>";
                    echo "<span class='button-space'></span>";
                    echo "<span class='button-space'></span>";
                    echo "<span class='button-space'></span>"; 
                    echo "<a href='update.php?fullname=" . urlencode($record['Fullname']) . "' class='update-button'>Update</a>";
                    echo "<span class='button-space'></span>"; 
                    echo "<span class='button-space'></span>";
                    echo "<span class='button-space'></span>";
                    echo "<a href='delete.php?fullname=" . urlencode($record['Fullname']) . "' class='delete-button'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
