<?php

function validate_message($message)
{
    // Check if message is correct (must have at least 10 characters after trimming)
    $trimmed_message = trim($message);
    if (strlen($trimmed_message) < 10) {
        return "Message must be at least 10 characters long";
    }
    return "";
}

function validate_username($username)
{
    // Check if username is correct (must be alphanumeric)
    if (!ctype_alnum($username)) {
        return "Username should contain only letters and numbers";
    }
    return "";
}

function validate_email($email)
{
    // Check if email is correct (must contain '@')
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Please enter a valid email";
    }
    return "";
}

$user_error = "";
$email_error = "";
$terms_error = "";
$message_error = "";
$username = "";
$email = "";
$message = "";

$form_valid = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validate username
    if (empty($username)) {
        $user_error = "Please enter a username";
    } else {
        $user_error = validate_username($username);
    }

    // Validate email
    if (empty($email)) {
        $email_error = "Please enter an email";
    } else {
        $email_error = validate_email($email);
    }

    // Validate message
    if (empty($message)) {
        $message_error = "Please enter a message";
    } else {
        $message_error = validate_message($message);
    }

    // Validate terms
    if (!isset($_POST['terms'])) {
        $terms_error = "You must accept the Terms of Service";
    }

    // Check if there are no errors
    if (empty($user_error) && empty($email_error) && empty($message_error) && empty($terms_error)) {
        $form_valid = true;
    }
}

?>

<form action="#" method="post">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Name" name="username" value="<?php echo ($form_valid == false)? htmlspecialchars($username):""; ?>">
            <small class="form-text text-danger"> <?php echo $user_error; ?></small>
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter email" name="email" value="<?php echo ($form_valid == false)? htmlspecialchars($email):""; ?>">
            <small class="form-text text-danger"> <?php echo $email_error; ?></small>
        </div>
    </div>
    <div class="mb-3">
        <textarea name="message" placeholder="Enter message" class="form-control"><?php echo ($form_valid == false)? htmlspecialchars($message):""; ?></textarea>
        <small class="form-text text-danger"> <?php echo $message_error; ?></small>
    </div>
    <div class="mb-3">
    <input type="checkbox" class="form-control-check" name="terms" id="terms" value="terms" <?php if (!$form_valid && isset($_POST['terms'])) echo 'checked'; ?>>
    <label for="terms">I accept the Terms of Service</label>
    <small class="form-text text-danger"> <?php echo $terms_error; ?></small>
</div>
    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<hr>

<?php
if ($form_valid) :
?>
    <div class="card">
        <div class="card-header">
            <p><?php echo htmlspecialchars($username); ?></p>
            <p><?php echo htmlspecialchars($email); ?></p>
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo htmlspecialchars($message); ?></p>
        </div>
    </div>
<?php
endif;
?>