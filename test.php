<!DOCTYPE html>
<html>
<head>
    <title>Form Validation</title>
    <style>
        .form-section {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .error { color: red; }
        .success { color: green; }
        ul.errors { color: red; }
    </style>
</head>
<body>
    <h1>Combined Form Validation</h1>

    <?php
    
    function displayResults($errors, $successMessage, $data = []) {
        if (!empty($errors)) {
            echo "<div class='error'>Validation errors:</div><ul class='errors'>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        } elseif ($successMessage) {
            echo "<div class='success'>$successMessage</div>";
            if (!empty($data)) {
                echo "<pre>" . print_r($data, true) . "</pre>";
            }
        }
    }
    ?>

    <!-- 1. Name Validation -->
    <div class="form-section">
        <h2>1. Name Validation</h2>
        <form method="post" action="#name">
            <input type="hidden" name="form_type" value="name">
            Name: <input type="text" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>"><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_type'] ?? '') == 'name') {
            $name = $_POST['name'] ?? '';
            $errors = [];

         
            if (empty($name)) {
                $errors[] = "Name cannot be empty";
            }
            if (str_word_count($name) < 2) {
                $errors[] = "Name must contain at least two words";
            }
            if (!preg_match('/^[a-zA-Z .-]+$/', $name)) {
                $errors[] = "Name can only contain a-z, A-Z, dot(.) or dash(-)";
            }
            if (!empty($name) && !ctype_alpha($name[0])) {
                $errors[] = "Name must start with a letter";
            }

            displayResults($errors, "Validation successful! Name: $name");
        }
        ?>
    </div>

    <!-- 2. Email Validation -->
    <div class="form-section">
        <h2>2. Email Validation</h2>
        <form method="post" action="#email">
            <input type="hidden" name="form_type" value="email">
            Email: <input type="text" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"><br>
            <small>hint: sample@example.com</small><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_type'] ?? '') == 'email') {
            $email = $_POST['email'] ?? '';
            $errors = [];

            
            if (empty($email)) {
                $errors[] = "Email cannot be empty";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Must be a valid email address (i.e. anything@example.com)";
            }

            displayResults($errors, "Validation successful! Email: $email");
        }
        ?>
    </div>

    <!-- 3. Gender Validation -->
    <div class="form-section">
        <h2>3. Gender Validation</h2>
        <form method="post" action="#gender">
            <input type="hidden" name="form_type" value="gender">
            Gender:
            <input type="radio" name="gender" value="male" <?= (isset($_POST['gender']) && $_POST['gender'] == 'male') ? 'checked' : '' ?>> Male
            <input type="radio" name="gender" value="female" <?= (isset($_POST['gender']) && $_POST['gender'] == 'female') ? 'checked' : '' ?>> Female
            <input type="radio" name="gender" value="other" <?= (isset($_POST['gender']) && $_POST['gender'] == 'other') ? 'checked' : '' ?>> Other<br><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_type'] ?? '') == 'gender') {
            $gender = $_POST['gender'] ?? '';
            $errors = [];

           
            if (empty($gender)) {
                $errors[] = "At least one gender must be selected";
            }

            displayResults($errors, "Validation successful! Gender: $gender");
        }
        ?>
    </div>

    <!-- 4. Date of Birth Validation -->
    <div class="form-section">
        <h2>4. Date of Birth Validation</h2>
        <form method="post" action="#dob">
            <input type="hidden" name="form_type" value="dob">
            Date of Birth:
            <input type="text" name="day" size="2" placeholder="dd" value="<?= isset($_POST['day']) ? htmlspecialchars($_POST['day']) : '' ?>"> /
            <input type="text" name="month" size="2" placeholder="mm" value="<?= isset($_POST['month']) ? htmlspecialchars($_POST['month']) : '' ?>"> /
            <input type="text" name="year" size="4" placeholder="yyyy" value="<?= isset($_POST['year']) ? htmlspecialchars($_POST['year']) : '' ?>"><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_type'] ?? '') == 'dob') {
            $day = $_POST['day'] ?? '';
            $month = $_POST['month'] ?? '';
            $year = $_POST['year'] ?? '';
            $errors = [];

            if (empty($day) || empty($month) || empty($year)) {
                $errors[] = "Date fields cannot be empty";
            } else {
                if (!is_numeric($day) || $day < 1 || $day > 31) {
                    $errors[] = "Day must be a valid number between 1-31";
                }
                if (!is_numeric($month) || $month < 1 || $month > 12) {
                    $errors[] = "Month must be a valid number between 1-12";
                }
                if (!is_numeric($year) || $year < 1900 || $year > 2016) {
                    $errors[] = "Year must be a valid number between 1900-2016";
                }
            }

            $data = ['Day' => $day, 'Month' => $month, 'Year' => $year];
            displayResults($errors, "Validation successful!", $data);
        }
        ?>
    </div>

    <!-- 5. Degree Validation -->
    <div class="form-section">
        <h2>5. Degree Validation</h2>
        <form method="post" action="#degree">
            <input type="hidden" name="form_type" value="degree">
            Degree:
            <input type="checkbox" name="degree[]" value="SSC" <?= (isset($_POST['degree']) && in_array('SSC', $_POST['degree'])) ? 'checked' : '' ?>> SSC
            <input type="checkbox" name="degree[]" value="HSC" <?= (isset($_POST['degree']) && in_array('HSC', $_POST['degree'])) ? 'checked' : '' ?>> HSC
            <input type="checkbox" name="degree[]" value="BSc" <?= (isset($_POST['degree']) && in_array('BSc', $_POST['degree'])) ? 'checked' : '' ?>> BSc<br><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_type'] ?? '') == 'degree') {
            $degrees = $_POST['degree'] ?? [];
            $errors = [];

          
            if (empty($degrees)) {
                $errors[] = "At least one degree must be selected";
            }

            $data = ['Degrees' => $degrees];
            displayResults($errors, "Validation successful!", $data);
        }
        ?>
    </div>

    <!-- 6. Blood Group Validation -->
    <div class="form-section">
        <h2>6. Blood Group Validation</h2>
        <form method="post" action="#bloodgroup">
            <input type="hidden" name="form_type" value="bloodgroup">
            Blood Group:
            <select name="bloodgroup">
                <option value="">Select</option>
                <option value="A+" <?= (isset($_POST['bloodgroup']) && $_POST['bloodgroup'] == 'A+') ? 'selected' : '' ?>>A+</option>
                <option value="A-" <?= (isset($_POST['bloodgroup']) && $_POST['bloodgroup'] == 'A-') ? 'selected' : '' ?>>A-</option>
                <option value="B+" <?= (isset($_POST['bloodgroup']) && $_POST['bloodgroup'] == 'B+') ? 'selected' : '' ?>>B+</option>
                <option value="B-" <?= (isset($_POST['bloodgroup']) && $_POST['bloodgroup'] == 'B-') ? 'selected' : '' ?>>B-</option>
                <option value="AB+" <?= (isset($_POST['bloodgroup']) && $_POST['bloodgroup'] == 'AB+') ? 'selected' : '' ?>>AB+</option>
                <option value="AB-" <?= (isset($_POST['bloodgroup']) && $_POST['bloodgroup'] == 'AB-') ? 'selected' : '' ?>>AB-</option>
                <option value="O+" <?= (isset($_POST['bloodgroup']) && $_POST['bloodgroup'] == 'O+') ? 'selected' : '' ?>>O+</option>
                <option value="O-" <?= (isset($_POST['bloodgroup']) && $_POST['bloodgroup'] == 'O-') ? 'selected' : '' ?>>O-</option>
            </select><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_type'] ?? '') == 'bloodgroup') {
            $bloodgroup = $_POST['bloodgroup'] ?? '';
            $errors = [];

          
            if (empty($bloodgroup)) {
                $errors[] = "Blood group must be selected";
            }

            displayResults($errors, "Validation successful! Blood Group: $bloodgroup");
        }
        ?>
    </div>

    <!-- 7. Profile Picture Validation -->
    <div class="form-section">
        <h2>7. Profile Picture Validation</h2>
        <form method="post" action="#profile" enctype="multipart/form-data">
            <input type="hidden" name="form_type" value="profile">
            User Id: <input type="text" name="userid" value="<?= isset($_POST['userid']) ? htmlspecialchars($_POST['userid']) : '' ?>"><br>
            Picture: <input type="file" name="picture"><br><br>
            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && ($_POST['form_type'] ?? '') == 'profile') {
            $userid = $_POST['userid'] ?? '';
            $picture = $_FILES['picture']['name'] ?? '';
            $errors = [];

          
            if (empty($userid)) {
                $errors[] = "User Id cannot be empty";
            } elseif (!is_numeric($userid) || $userid <= 0) {
                $errors[] = "User Id must be a positive number";
            }
            if (empty($picture)) {
                $errors[] = "Picture cannot be empty";
            }

            $data = ['User ID' => $userid, 'Picture' => $picture];
            displayResults($errors, "Validation successful!", $data);
        }
        ?>
    </div>
</body>
</html>