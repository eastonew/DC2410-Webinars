<html>
    <head>
        <title>
            Add a new Vehicle
        </title>
    </head>
    <body>
        <form method="POST" action="addvehicle.php">
            Registration Number: <input type="text" name="reg_no" />  <br/>
            Category: <select name="category">
                <option value="car" selected>Car</option>
                <option value="truck">Truck</option>
            </select><br/>
            <input type="submit" value="Save" />
        </form>

        <?php
            if(!empty($_POST))
            {
                require_once("connectdb.php");
                $regNo = $_POST["reg_no"];
                $category = $_REQUEST["category"];

                $stmt = $db->prepare("INSERT INTO vehicles(reg_no, category) Values(?,?)");
                $stmt -> execute(array($regNo, $category));
                echo("successful");
            }

            ?>
</body>
</html>