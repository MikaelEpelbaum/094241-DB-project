<html>
<head>
    <style>
        h1, h4, h5{
            text-align: center;
        },
    </style>
    <style>
        label{
            text-align: left;
        }
    </style>
</head>
<body style="text-align: center">
<h1>Add New Magic Acts</h1>
<h5>Fill Magic Acts Details:</h5>
<form style="display: inline-block" name="magic" method="post">
    <table align="center">
        <tr>
            <td>Wizard Name:</td>
            <td><input type="text" name="wizardName" size="100" required></td>
        </tr>
        <tr>
            <td><label>Magic Word:</label></td>
            <td><input type="text" name="magicWord" size="100" required></td>
        </tr>
    </table>
    <input name="submit" type="submit" value="Send">
    <br/><br/>
    <input type="reset" value="reset">
</form>
<?php
include "sqlConnection.php";
$conn = conn();
if (isset($_POST["submit"])) {
    $name = $_POST["wizardName"];
    $spell = $_POST["magicWord"];
    $wizard = sqlsrv_query($conn ,"Select * FROM Wizard where cName='$name'");
    $magic = sqlsrv_query($conn ,"Select * FROM Spell where magicWord='$spell'");
    $row1 = sqlsrv_fetch_array($wizard, SQLSRV_FETCH_ASSOC);
    if ($row1['cName']){
        $row2 = sqlsrv_fetch_array($magic, SQLSRV_FETCH_ASSOC);
        if ($row2['magicWord']){
            $datetime = date("Y-m-d h:i:s");
            uploadSingle(array($datetime), 'MDate');
            $result = uploadSingle(array($name, $spell, $datetime), 'Performed');
            echo "<h5>The magic Acts have been added to the DB Successfully</h5>";

            $randHatedWizard = sqlsrv_query($conn,"SELECT top 1 cName2 FROM Relationship WHERE cName1 ='$name' 
                                                and rType='Hate' and cName2 in (select cName from Wizard) order by NEWID()");
            $wRow = sqlsrv_fetch_array($randHatedWizard, SQLSRV_FETCH_ASSOC);
            $opponent = $wRow['cName2'];
            $randSpell = sqlsrv_query($conn, "SELECT top 1 * FROM spell order by NEWID()");
            $sRow = sqlsrv_fetch_array($randSpell, SQLSRV_FETCH_ASSOC);
            $opponentSpell = $sRow['magicWord'];
            uploadSingle(array($opponent, $opponentSpell, $datetime), 'Performed');

            echo "<h3>$name performed $spell</h3>";

            echo"</br><h3>$opponent performed $opponentSpell</h3></br>";
            $val1 = $row2['difLevel'];
            $val2 = $sRow['difLevel'];

            if ($val2>$val1)
                echo "<h3>$opponent won!</h3>";
            else
                echo "<h3>$name won!</h3>";
        }
        else {echo "<h5>Couldn't add the Magic Acts. <br/> Invalid Spell Submitted.</h5>";}
    }
    else {echo "<h5>Couldn't add the Magic Acts. <br/> Invalid Wizard Submitted.</h5>";
    }
}
?>
</body>
</html>
