<?php
// Connect to the database
include 'db.php';

// Get the search term from URL
$search = $_GET['q'] ?? '';

// Prepare SQL query with wildcards for flexible matching
$sql = "SELECT * FROM restaurants WHERE name LIKE ? OR cuisine LIKE ? OR location LIKE ?";
$stmt = $conn->prepare($sql);
$like = "%$search%";
$stmt->bind_param("sss", $like, $like, $like);
$stmt->execute();
$result = $stmt->get_result();

// Display the results
echo "<h2>Search Results:</h2>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong> - " . 
             htmlspecialchars($row['cuisine']) . " (" . 
             htmlspecialchars($row['location']) . ")</p>";
    }
} else {
    echo "<p>No results found for '<strong>" . htmlspecialchars($search) . "</strong>'</p>";
}
?>
