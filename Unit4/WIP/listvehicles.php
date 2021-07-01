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
            $rows = $db->query("SELECT * from vehicles");

            foreach($rows as $row)
            {
                echo("<tr><td>".$row['reg_no']."</td><td>".$row["category"]."</td><td>".$row["brand"]."</td></tr>");
            }
        ?>
    </table>
    </body>

</html>