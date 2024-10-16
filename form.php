<form action="dictionary.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required>

    <label for="city">City:</label>
    <input type="text" id="city" name="city" required>

    <label for="subscribe">Subscribe to newsletter?</label>
    <select id="subscribe" name="subscribe" required>
        <option value="">Select</option>
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>

    <input type="submit" value="Submit">
</form>