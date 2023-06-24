<!DOCTYPE html>
<html>
<head>
    <title>Bootstrap Form Template</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Bootstrap Form</h2>
    <form action="/index/store" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $this->token; ?>">

        <div class="form-group">
            <label for="message">Message:</label>
            <textarea class="form-control" id="message" name="message" rows="5"><?php echo $this->message;?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php foreach ($this->errors as $error){
        echo "<span class='text-danger'>{$error}</span><br>";
    }?>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</body>
</html>
