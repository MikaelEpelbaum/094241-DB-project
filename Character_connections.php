<html>
<head>
    <style>
        h1, h3, h5, a{
            text-align: center;
        }
        img {
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <style>
        table, th, td {
            border: 1px solid black;
        },
    </style>
</head>
<body style="text-align: center">
<h1>Show Character Connections</h1>
<h3 align="center">Select Character Name:</h3>

<form align="center" style="display: inline-block" name="magic" method="post">
    <table align="center">
        <tr>
            <td>Character Name:</td>
            <td>
                <select name="character" required>
                    <?php
                    include "sqlConnection.php";
                    $conn = conn();
                    $sql="SELECT cName FROM Character";
                    $result = sqlsrv_query($conn, $sql);
                    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC))
                    {
                        echo "<option value='";
                        echo $row['cName'];
                        echo "'>";
                        echo $row['cName'];
                        echo "</option>";
                    }
                    ?>
                </select></td>
        </tr>
    </table>
    <br/>
    <input name="submit" type="submit" value="Send">
    <br/><br/>
    <input type="reset" value="reset">
</form>

<table align='center'>
    <?php
    $selected = $_POST["character"];
    echo "<th>Friends of Character $selected</th>";
        $sql = "SELECT cName2 from Relationship where cName1= '$selected' and rType = 'Love' and cName2 in 
                    (SELECT cName1 FROM Relationship WHERE cName2='$selected' and rType='Love') order by cName2 asc";
        $result = sqlsrv_query($conn, $sql);
        while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
            echo "<tr><td>";
            echo $row['cName2'];
            echo "</td></tr>";
        }
        ?>
</table>
<br/>
<table align='center'>
    <?php
    $selected = $_POST["character"];
    echo "<th>Nemesis of Character $selected</th>";
    $sql = "SELECT cName2 from Relationship where cName1= '$selected' and rType = 'Hate' and cName2 in 
                    (SELECT cName1 FROM Relationship WHERE cName2='$selected' and rType='Hate') order by cName2 asc";
    $result = sqlsrv_query($conn, $sql);
    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['cName2'];
        echo "</td></tr>";
    }
    ?>
</table>
<br/>
<table align='center'>
    <?php
    $selected = $_POST["character"];
    echo "<th>BFF of Character $selected</th>";
    $sql = "select distinct lovedSpells.cName from
            (select cName, magicWord from Performed where cName = '$selected') as mSpells
            full outer join
            (select cName, magicWord from Performed where cName in(
            SELECT cName2 from Relationship where cName1= '$selected' and rType = 'Love' and cName2 in
                (SELECT cName1 FROM Relationship WHERE cName2='$selected' and rType='Love'))) as lovedSpells
            on mSpells.magicWord = lovedSpells.magicWord
            where mSpells.magicWord = lovedSpells.magicWord";
    $result = sqlsrv_query($conn, $sql);
    while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
        echo "<tr><td>";
        echo $row['cName'];
        echo "</td></tr>";
    }
    ?>
</table>

</body>
</html>