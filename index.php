<?php
session_start();
require "db.php";
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST Coments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/js/all.min.js" integrity="sha512-UwcC/iaz5ziHX7V6LjSKaXgCuRRqbTp1QHpbOJ4l1nw2/boCfZ2KlFIqBUA/uRVF0onbREnY9do8rM/uT/ilqw==" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <div><div class="container">
        <div class="bg-success p-3 col-12">
            <div class="row">
                <div class="col-6"><h2 class="text-white">My Post</h2></div>
                <?php
                    if(isset($_SESSION['user'])){
                        echo '<div class="col-6">
                                <div class="row pr-3">
                                    <h4 class="ml-auto text-white">'.$_SESSION['user'].' <a href="?logout=true" class="align-self-center">Logout</a></h4>
                                </div>
                            </div>';
                    }
                    else{
                        echo '<div class="col-6">
                                <form action="config.php" method="post">
                                    <div class="row justify-content-end pr-3">
                                        <input type="text" name="name" placeholder="Username" required class="form-control col-4">
                                        <input type="submit" name="createUser" value="Login" class="btn btn-primary col-2">
                                    </div>
                                </form>
                            </div>';
                    }
                
                ?>
                
                
            </div>
        </div>
        <div class="col-12 bg-light p-3">
            <?php
                if(isset($_SESSION['error'])){
                    echo '<div class="alert alert-danger w-100">'.$_SESSION['error'].'</div>';
                    unset($_SESSION['error']);
                }
                if(!isset($_SESSION['user'])){
                    echo '<div class="alert alert-info w-100">Please log in to post a comment.</div>';
                }
            
            ?>
            
            <div class="row justify-content-center">
                <img src="img/unnamed.jpg" alt="">
            </div>
            <div class="bg-white w-100 p-3">
                <h2>Comments</h2>
                <hr>
                <?php
                
                    $sql = "SELECT * FROM comment ORDER BY `date` ASC";
                    $query = mysqli_query($conn, $sql);
                    while($res = mysqli_fetch_assoc($query)){
                        $sql2 = "SELECT * FROM comment WHERE comment = '".$res['id']."'";
                        $query2 = mysqli_query($conn, $sql2);
                        if(mysqli_num_rows($query2) !== 0 ){
                            if($res['comment'] === "0"){
                                echo '<div class="row">
                                    <div class="col-1">
                                        <img width="50" height="50" src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d3/Microsoft_Account.svg/1024px-Microsoft_Account.svg.png" class="rounded-circle" alt="">
                                    </div>
                                    <div class="col-11">
                                        <div class="col-12">
                                            <h4>'.$res['username'].'</h4>
                                            <p>'.$res['text'].'</p>
                                            <small>'.$res['date'].'</small>
                                        </div>
                                        <div class="col-12">
                                            <a href="?answer='.$res['id'].'&cavab='.$res['id'].'" class="text-dark"><i class="fas fa-reply"></i> Reply</a>
                                        </div>';
                            }
                            while($response = mysqli_fetch_assoc($query2)){
                                echo '<div class="col-12 p-3">
                                <div class="row">
                                    <div class="col-1">
                                        <img width="50" height="50" src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d3/Microsoft_Account.svg/1024px-Microsoft_Account.svg.png" class="rounded-circle" alt="">
                                    </div>
                                    <div class="col-11">
                                        <div class="col-12">
                                            <h4>'.$response['username'].'</h4>
                                            <p>'.$response['text'].'</p>
                                            <small>'.$response['date'].'</small>
                                        </div>
                                        <div class="col-12">
                                            <a href="?answer='.$res['id'].'&cavab='.$response['id'].'" class="text-dark"><i class="fas fa-reply"></i> Reply</a>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                            }
                            echo '</div></div>';
                            
                        }
                        else{
                            if($res['comment'] === "0"){
                                echo '<div class="row">
                                    <div class="col-1">
                                        <img width="50" height="50" src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d3/Microsoft_Account.svg/1024px-Microsoft_Account.svg.png" class="rounded-circle" alt="">
                                    </div>
                                    <div class="col-11">
                                        <div class="col-12">
                                            <h4>'.$res['username'].'</h4>
                                            <p>'.$res['text'].'</p>
                                            <small>'.$res['date'].'</small>
                                        </div>
                                        <div class="col-12">
                                            <a href="?answer='.$res['id'].'&cavab='.$res['id'].'" class="text-dark"><i class="fas fa-reply"></i> Reply</a>
                                        </div></div></div>';
                                        
                            }
                            
                        }
                        
                    }
                
                ?>
                
            </div>
            <div class="row">
                <div class="col-12 bg-success px-4 py-2">
                    <?php
                        if(isset($_GET['answer'])){
                            $sql = "SELECT * FROM comment WHERE id='".$_GET['cavab']."'";
                            $res = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                            echo '<div class="bg-light row mb-1 position-relative">
                                    <div class="col-11">
                                        <h4>'.$res['username'].'</h4>
                                        <p>'.$res['text'].'</p>
                                    </div>
                                    <div class="col-1">
                                        <a href="index.php" class="close" style="cursor: pointer; font-size: 30px;">&times</a>
                                    </div>
                                </div>';
                        }
                    ?>
                    <form action="config.php" method="post">
                        <div class="row">
                            <?php
                                if(isset($_GET['answer'])){
                                    echo '<input type="hidden" name="id" value="'.$_GET['answer'].'" class="form-control col" placeholder="Write">';
                                }
                            ?>
                            <input type="text" name="comment" class="form-control col" placeholder="Write">
                            <input type="submit" name="sendComment" class="btn btn-primary col-1 ml-2" value="Send">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>