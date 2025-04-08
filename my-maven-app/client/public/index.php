<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Development App</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Self-Development App</h1>
    <form id="dataForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <label for="weight">Weight:</label>
        <input type="number" id="weight" name="weight" required>
        <label for="mood">Mood:</label>
        <input type="text" id="mood" name="mood" required>
        <button type="submit">Submit</button>
    </form>
    <button id="searchButton">Search by Name</button>
    <input type="text" id="searchName" placeholder="Enter name to search">
    <div id="searchResult"></div>
    <script src="assets/js/app.js"></script>
</body>
</html>