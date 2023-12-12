<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <h1>File Upload</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="file">Select File:</label>
        <input type="file" name="file" id="file" required>
        <button type="submit" name="submit">Upload</button>
    </form>
</body>
</html>