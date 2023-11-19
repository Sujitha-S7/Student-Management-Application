<?php
if (isset($_GET['fullname'])) {
    $fullname = $_GET['fullname'];

    // Read data from the JSON file
    $jsonContent = file_get_contents('student_records.json');
    $data = json_decode($jsonContent, true);

    if ($data) {
        $updatedData = [];
        $deleted = false;

        foreach ($data as $record) {
            if ($record['Fullname'] !== $fullname) {
                $updatedData[] = $record;
            } else {
                $deleted = true;
            }
        }

        if ($deleted) {
            // Save updated data back to the file
            file_put_contents('student_records.json', json_encode($updatedData));
            echo '<script>alert("Record deleted successfully"); window.location.href = "index.php";</script>';
        } else {
            echo '<script>alert("Record not found"); window.location.href = "index.php";</script>';
        }
    } else {
        echo '<script>alert("No records found"); window.location.href = "index.php";</script>';
    }
} else {
    echo '<script>alert("Invalid request"); window.location.href = "index.php";</script>';
}
?>
