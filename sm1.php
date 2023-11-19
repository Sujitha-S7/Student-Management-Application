<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
    }

    #search {
        margin-top: 10px;
        float: left;
        width: 670px; 
        height: 40px; 
        top: 120px;
    }

    .right-corner {
        position: absolute;
        top: 150px;
        right: 20px;
    }

    .filter-container {
        width: 180px;
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
    </style>
</head>
<body>
    <header>
        <h1>STUDENT RECORD</h1>
        <div class="button-container">
            <form id="backForm" action="udbpage.html">
                <button type="submit">Back</button>
            </form>
    </div>
    </header><br><br>
    <div style="margin-top: 20px;">
    <form id="backForm" action="change.html" style="display: inline-block; margin-right: 10px;">
        <button type="submit" style="font-size: 18px; font-weight: bold;"><br>ADD STUDENTS<br><br></button>
    </form>
    <form id="backForm1" action="index.php" style="display: inline-block;">
        <button type="submit" style="font-size: 18px; font-weight: bold;"><br>EDIT RECORDS<br><br></button>
    </form>
    </div>
    <div class="search-container">
        <h3><input type="text" id="search" placeholder="Search student..."></h3>
    </div>

    <div class="filters right-corner">
        <div class="filter-container">
            <form id="backForm" action="sm1.php">
                <button type="submit">Remove filters</button>
            </form><br>
            <select id="filterCriteria" class="filter-input">
                <option value="class">Filter by class...</option>
            </select>
            <select id="filterOptions" class="filter-input">
                <!-- Options will be added dynamically via JavaScript -->
            </select>
        </div>
    </div><br><br><br><br>
    
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Age</th>
                <th>Date of Birth</th>
                <th>Class</th>
            </tr>
        </thead>
        <tbody id="studentRecords">
            <?php
            // Read data from the JSON file
            $jsonContent = file_get_contents('student_records.json');
            $data = json_decode($jsonContent, true);

            if ($data) {
                foreach ($data as $record) {
                    echo "<tr>";
                    echo "<td>" . $record['Fullname'] . "</td>";
                    echo "<td>" . $record['Age'] . "</td>";
                    echo "<td>" . $record['dob'] . "</td>";
                    echo "<td>" . $record['Class'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No records found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const filterCriteria = document.getElementById('filterCriteria');
            const tableRows = document.querySelectorAll('#studentRecords tr');
            const filterOptions = document.getElementById('filterOptions');
            function toggleFilterOptions() {
                const selectedValue = filterCriteria.value;
                if (selectedValue === 'class') {
                    filterOptions.innerHTML = '<option value="">Choose a class...</option>' +
                                             '<option value="A">A</option>' +
                                             '<option value="B">B</option>' +
                                             '<option value="C">C</option>';
                } else {
                    filterOptions.innerHTML = '<option value="">Choose...</option>';
                }
                filterTable();
            }

            function filterTable() {
            const ageValue = parseInt(filterOptions.value, 10); // Convert to integer
            const classValue = filterOptions.value.toLowerCase();
            const searchValue = searchInput.value.toLowerCase();

            tableRows.forEach(row => {
                const age = parseInt(row.cells[1].innerText.trim(), 10); // Convert to integer
                const studentClass = row.cells[3].innerText.trim().toLowerCase();
                const fullName = row.cells[0].innerText.trim().toLowerCase();

                const ageMatch = age === ageValue || !ageValue || isNaN(ageValue); // Check for NaN
                const classMatch = studentClass === classValue || !classValue;
                const searchMatch = fullName.includes(searchValue) || !searchValue;

                if (ageMatch && classMatch && searchMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }


            searchInput.addEventListener('input', filterTable);
            filterCriteria.addEventListener('change', toggleFilterOptions);
            filterOptions.addEventListener('change', filterTable);

            toggleFilterOptions(); // Initialize filter options on page load
        });
    </script>
</body>
</html>
