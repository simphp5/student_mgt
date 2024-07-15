<?php
include 'db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update query
    $sql = "UPDATE students SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);

    if ($stmt->execute()) {
        echo "Student updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    header("Location: index.php");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Edit Student</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
        <div class="content">
            <form method="POST" action="">
                Name: <input type="text" name="name" value="<?php echo $student['name']; ?>" required><br>
                Email: <input type="email" name="email" value="<?php echo $student['email']; ?>" required><br>
                Phone: <input type="text" name="phone" value="<?php echo $student['phone']; ?>" required><br>
                Address: <textarea name="address" required><?php echo $student['address']; ?></textarea><br>
                <input type="submit" value="Update Student">
            </form>
        </div>
    </div>
</body>
</html>
