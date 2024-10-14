<?php
session_start();
if(isset($_GET['logout'])){    
    //Simple exit message 
    $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div>";
    file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);
    session_destroy();
    header("Location: index.php"); //Redirect the user 
}
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}

function loginForm(){
    echo 
    '<div id="loginform"> 
        <p>Please enter your username to continue!</p> 
        <form action="index.php" method="post"> 
            <label for="name">Name &mdash;</label> 
            <input type="text" name="name" id="name" /> 
            <input type="submit" name="enter" id="enter" value="Enter" /> 
        </form> 
    </div>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Chatroom -Zimeduconnect</title>
    <meta name="description" content="Tuts+ Chat Application" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        body {
            font-family: 'Sofia';
            font-size: 24px;
            background: url(4.png); /* Change the background image here */
        }
    </style>
</head>
<body>
<?php
if(!isset($_SESSION['name'])){
    loginForm();
}
else {
?>
    <div id="wrapper">
        <div id="menu">
            <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
            <p class="logout"><a id="exit" href="dashboard.html">Exit Chat</a></p>
        </div>
        <div id="chatbox">
            <?php
            if(file_exists("log.html") && filesize("log.html") > 0){
                $contents = file_get_contents("log.html");          
                echo $contents;
            }
            ?>
        </div>
        <form name="message" action="">
            <input name="usermsg" type="text" id="usermsg" />
            <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
            <button type="button" id="deleteMsgBtn"><i class="fas fa-trash-alt"></i></button>
            <input type="file" id="mediaInput" style="display: none;" />
            <button type="button" id="attachMediaBtn"><i class="fas fa-paperclip"></i></button>
        </form>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#submitmsg").click(function () {
                var clientmsg = $("#usermsg").val();
                $.post("post.php", { text: clientmsg });
                $("#usermsg").val("");
                return false;
            });

            $("#deleteMsgBtn").click(function () {
                // Add functionality to delete message here
                // For example, you can remove the last message from the chatbox
                $("#chatbox .msgln:last").remove();
            });

            $("#attachMediaBtn").click(function () {
                $("#mediaInput").click(); // Clicking on hidden file input
            });

            $("#mediaInput").change(function () {
                // Handle file attachment here
                var file = $(this).prop("files")[0];
                // You can upload the file using AJAX or handle it as per your requirement
            });

            function loadLog() {
                var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request 
                $.ajax({
                    url: "log.html",
                    cache: false,
                    success: function (html) {
                        $("#chatbox").html(html); //Insert chat log into the #chatbox div 
                        //Auto-scroll 
                        var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request 
                        if(newscrollHeight > oldscrollHeight){
                            $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div 
                        }   
                    }
                });
            }
            setInterval (loadLog, 2500);
            $("#exit").click(function () {
                var exit = confirm("Are you sure you want to end the session?");
                if (exit == true) {
                window.location = "index.php?logout=true";
                }
            });
        });
    </script>
</body>
</html>
<?php
}
?>