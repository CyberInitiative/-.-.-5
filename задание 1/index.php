<?php
    $conn=mysqli_connect("kylin", "miroslav", "Stronghold666!", "BOOKSHOP");
    if(!$conn){
        die("Error".mysqli_connect_error());
    }
?>
<!DOCTYPE html>
<html>
    <head>      
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    </head>
    
    <body class="bg-light">       
        <?php  
            if(isset($_POST['submit'])){
                if(isset($_POST['author'])){
                    foreach($_POST['author'] as $author){
                        $query="INSERT INTO `Order` (`author`, `title`) SELECT `author`, `title` FROM `Books` WHERE author='$author'";
                        mysqli_query($conn,$query);
                    }
                }
            }

            $sql="SELECT `author`, `title`, `year`, `type`, `isbn` FROM `Books`";
            $result=mysqli_query($conn,$sql);
        ?>
        <form action="index.php" method="post">
            <div class="container">
                <div class = "row justify-content-center mt-2">
                    <div class="col-md-6 bg-light rounded p-3">
                        <h2 class="text-center">TEXT</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td colspan="6">
                                        <input type="submit" name="submit" value="Add to the cart" onclick="return confirm('Are you sure?')"
                                        class="btn btn-success">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Year</th>
                                    <th>ISBN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($row=mysqli_fetch_array($result)){
                                ?>
                                <tr>
                                    <td><?= $row['author'] ?></td>
                                    <td><?= $row['title'] ?></td>
                                    <td><?= $row['type'] ?></td>
                                    <td><?= $row['year'] ?></td>
                                    <td><?= $row['isbn'] ?></td>
                                    <td><input type="checkbox" class="checkItem" value="<?= $row['author']?>"name="author[]"></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="changeText()">
                            Open cart
                        </button>
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">The list</h4>
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                </div>
                                <div class="modal-body">
                                    <p id="mod"> Your shop list: </p>
                                    <?php
                                        $the_result = mysqli_query($conn, 'SELECT * FROM `Order`'); // запрос на выборку
                                        $row_cnt = mysqli_num_rows($the_result);
                                        if ($row_cnt != 0){
                                            while($row=mysqli_fetch_array($the_result))
                                            {
                                            echo '<p>Author: '.$row['author'].' ; Title: '.$row['title'].'</p>';// выводим данные
                                            }
                                        }
                                        if ($row_cnt == 0){
                                            echo "<script>";
                                            echo "let elem = document.getElementById('mod');";
                                            echo "function changeText(){elem.innerHTML = `<p>Your list is empty, load the main page again. </p>`;}";                                                       
                                            echo "</script>";
                                        }
                                    ?>
                                </div>                               
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>       
    </body>
</html>