<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file"]["size"] > 99999000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    if ($imageFileType != "txt" && $imageFileType != "pdf" && $imageFileType != "doc") {
        echo "Sorry, only TXT, PDF, and DOC files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded.";

            // Send file to Python API server
            $api_url = "http://127.0.0.1:5000/upload";
            $file_path = realpath($target_file);

            $curl = curl_init();
            $post_data = array('file' => new CURLFile($file_path));
            curl_setopt($curl, CURLOPT_URL, $api_url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($curl);
            curl_close($curl);

            // Handle the response from the Python API server as needed
            echo "<br>Response from Python API server: " . $response;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
