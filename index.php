<html>
<head>
    <style>
        h1, h4, h5, a{
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
<body>
<h1>Welcome to Harry Potter Website</h1>

<img src="https://upload.wikimedia.org/wikipedia/en/thumb/a/a3/Lordvoldemort.jpg/330px-Lordvoldemort.jpg" width="308" height="217" align="center">
<h5>
    <br/>
    <a href="new_file.php", target="_self"> Add a new file</a>
    <br/>
    <a href="new_magic_acts.php", target="_self"> Add new Magic Acts</a>
    <br/>
    <a href="Character_connections.php" target="_self"> Show Character Connections</a>
</h5>

<h1>Harry Potter Statistics:</h1>

<table align='center'>
    <th>Not Only Student</th><th>Longest Magic Word</th><th>Most Beloved Non Wizard</th>
    <tr>
        <?php
        include 'sqlConnection.php';
        $conn = conn();
        $arr = array('notOnlyStudent', 'longestMagicWord', 'mostBelovedNonWizard');
        for ($i = 0; $i<count($arr); $i++){
            $sql = sprintf("SELECT * FROM %s", $arr[$i]);
            $result = sqlsrv_query($conn, $sql);
            $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
            echo "<td> ".$row['val']." </td>";
        }
        ?>
    </tr>
</table>

</body>
</html>