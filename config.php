<?php
    session_start();
    require "db.php";
    if(isset($_POST['createUser'])){
        $name = $_POST['name'];
        if($name !== ""){
            $_SESSION['user'] = $name;
            header("Location: index.php");
        }
        else{
            $_SESSION['error'] = "Username not entered";
            header("Location: index.php");
        }
    }
    elseif(isset($_POST['sendComment'])){
        if($_POST['comment'] !== ""){
            if(isset($_SESSION['user'])){
                $id = (isset($_POST['id'])) ? $_POST['id'] : 0;
                $username = $_SESSION['user'];
                $text = $_POST['comment'];
                $sql = "INSERT INTO comment (`comment`, `username`, `text`) VALUES ('$id', '$username', '$text')";
                if(mysqli_query($conn, $sql)){
                    header("Location: index.php");
                }
            }
            else{
                $_SESSION['error'] = "You must be logged in to post a comment.";
                header("Location: index.php");
            }
        }
        else{
            $_SESSION['error'] = "The comment cannot be empty";
            header("Location: index.php");
        }

    }

    else{
        $_SESSION['error'] = "Please log in to post a comment.";
        header("Location: index.php");
    }


?>