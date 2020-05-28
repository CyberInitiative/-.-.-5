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
        <script type='text/javascript'>
        function validate(){
            var x=document.forms['form']['name'].value;
            var y=document.forms['form']['surname'].value;
            var z=document.forms['form']['age'].value;
            if (x.length==0){
                document.getElementById('namef').innerHTML='*this field is required';
                return false;
            }
            if (y.length==0){
                document.getElementById('surnamef').innerHTML='*this field is required';
                return false;
            }
            if (z.length==0){
                document.getElementById('agef').innerHTML='*this field is required';
                return false;
            }
        }
        </script>
    </head>
    <body class="bg-light">
        <?php
        if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['age']) && isset($_POST['sex'])){
            $link = mysqli_connect("kylin", "miroslav", "Stronghold666!", "BOOKSHOP") 
                or die("Ошибка " . mysqli_error($link)); 
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $age = $_POST['age'];
            $sex = $_POST['sex'];
            
            if( $sex == 'male'){
                $recomend = ($age / 2) + 7;
                round($recomend);
                echo '<span>Recommended partner age: '.round($recomend).'</span>';
                echo '<br>';

            }
            if( $sex == 'female'){
                $recomend = ($age * 2) - 14;
                round($recomend);
                echo '<span>Recommended partner age: '.round($recomend).'</span>';
                echo '<br>';
            }

            $query ="INSERT INTO Partners VALUES('$name','$surname','$age', '$sex', $recomend)";

            $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
            if($result)
            {
                echo "<span style='color:blue;'>Data added</span>";
            }
            mysqli_close($link);
        }
        ?>
        <div class="container mt-3">
            <form method="POST" name='form' onsubmit="return validate()">
                <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type='text' id="inputName" placeholder="Enter name" class="form-control" name='name'> <span style='color:red' id='namef'></span><br />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputSurname" class="col-sm-2 col-form-label">Surname</label>  
                    <div class="col-sm-10">              
                        <input type='text' id="inputSurname" placeholder="Enter surname" class="form-control" name='surname'> <span style='color:red' id='surnamef'></span><br />
                    </div>
                </div>  
                <div class="form-group row">
                    <label for="inputAge" class="col-sm-2 col-form-label">Age</label>
                    <div class="col-sm-10">
                        <input type='number' id="inputAge" placeholder="Enter age" min="16" class="form-control" name='age'> <span style='color:red' id='agef'></span><br />
                    </div>
                 </div>  
                 <fieldset class="form-group">
                    <div class="row">
                        <legend class="col-form-label col-sm-2 pt-0">Sex</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <p><input name="sex" type="radio" value="male" checked>Male</p>
                                <p><input name="sex" type="radio" value="female">Female</p>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="submit" class="btn btn-primary" value="Sumbit">
                    </div>
                </div>
            </form>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" onclick="changeText()">
                Open list
            </button>
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">The list</h4>
                            <button type="button" class="close" data-dismiss="modal">×</button>
                        </div>
                        <div class="modal-body">
                        <?php
                         $conn=mysqli_connect("kylin", "miroslav", "Stronghold666!", "BOOKSHOP");
                         if(!$conn){
                             die("Error".mysqli_connect_error());
                         }
                         $query = "SELECT * FROM `Partners`";
                        $result = $conn->query($query);
                        if (!$result) die($conn->error);
                        $rows = $result->num_rows;
                        for ($j = 0 ; $j < $rows ; ++$j)
                        {
                            $result->data_seek($j);
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            echo 'Name: ' . $row['nname'] . '<br>';
                            echo 'Surname: ' . $row['surname'] . '<br>';
                            echo 'Age: ' . $row['age'] . '<br>';
                            echo 'Sex: ' . $row['sex'] . '<br>';
                            echo 'Recommended partner age: ' . $row['recomend'] . '<br><br>';
                            }
                            $result->close();
                            $conn->close();
                           

                        ?>  
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>