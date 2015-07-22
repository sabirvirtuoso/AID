<?php

// Where the file is going to be placed
if (is_uploaded_file($_FILES['filechooser']['tmp_name'])) {
    $target_path = "";
    // Add the original filename to our target path.
    //Result is "uploads/filename.extension" 
    $_SESSION['targetpath'] = $target_path = $target_path . basename($_FILES['filechooser']['name']);
    $_SESSION['filename'] = basename($_FILES['filechooser']['name'], ".csv");

    if (move_uploaded_file($_FILES['filechooser']['tmp_name'], $target_path)) {
        echo "The file " . basename($_FILES['filechooser']['name']) . " has been uploaded";
    } else {
        echo "There was an error uploading the file, please try again!";
    }
} else {
    header("location:index.php?page=be_data_entry");
    $_SESSION['msg_type'] = 'e';
    $_SESSION['msg'] = 'Please select a CSV file.';
    exit(0);
}

$count = 1;

/* echo "<html><body><table border='1'>\n\n<tr><th>STUDENT_ID</th><th>BATCH</th><th>DEPARTMENT</th><th>FIRST_NAME</th><th>LAST_NAME</th><th>POSITION</th><th>EMPLOYER</th>
  <th>SECTOR</th><th>NATIONALITY</th><th>EMAIL_PRIMARY</th><th>EMAIL_ALTERNATIVE</th><th>PHONE_PRIMARY</th><th>PHONE_SECONDARY</th><th>CITY</th>
  <th>COUNTRY</th><th>MAILING_ADDRESS</th><th>BLOOD_GROUP</th><th>IUT_ROOM_NO</th><th>INTERESTS</th><th>AWARDS</th></tr>"; */
$htmlOutput = "";

$f = fopen($target_path, "r");
while (($line = fgetcsv($f)) !== false) {
    if ($count > 1) {   //Ignore CSV header line
        $htmlOutput = $htmlOutput . "<tr>";
        foreach ($line as $cell) {
            $htmlOutput = $htmlOutput . "<td>" . htmlspecialchars($cell) . "</td>" . " ";
        }
        $htmlOutput = $htmlOutput . "</tr>";
    }
    $count++;
}
fclose($f);
$_SESSION['htmlOutput'] = $htmlOutput;
header("location:index.php?page=be_data_entry&step=2");
exit(0);
//echo "\n</table></body></html>";
?>
