<html>
<style>
    h1, h3, h5, input{
        text-align: center;
    }
</style>
</head>
<body>
<h1>Add files</h1>
<div style="text-align: center">

    <h3>Chose Characters file:</h3>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
            <input name="csv" type="file" id="csv" />
            <br/> <br/>
            <input type="submit" name="submit_character" value="submit" />
        </form>
    <?php
    $result = '';
    include "sqlConnection.php";
    if (isset($_POST["submit_character"])) {
        //get the csv file
        $file = $_FILES[csv][tmp_name];
        $result = CVSUpload($file, 'Character');
    }?>
</div>
<div style="text-align: center">
    <h3>Chose Wizards file:</h3>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
            <input name="csv" type="file" id="csv" />
            <br/> <br/>
            <input type="submit" name="submit_wizard" value="submit" />
        </form>
    <?php
if (isset($_POST["submit_wizard"])) {
    //get the csv file
    $file = $_FILES[csv][tmp_name];
    $result = CVSUpload($file,'Wizard');
}
?>
</div>
<div style="text-align: center">
    <h3>Chose Relationships file:</h3>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
        <input name="csv" type="file" id="csv" />
        <br/> <br/>
        <input type="submit" name="submit_relationship" value="submit" />
    </form>
    <?php
    if (isset($_POST["submit_relationship"])) {
        //get the csv file
        $file = $_FILES[csv][tmp_name];
        $result = CVSUpload($file,'Relationship');
    }
    ?>
</div>
<div style="text-align: center">
    <h3>Chose Spells file:</h3>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
        <input name="csv" type="file" id="csv" />
        <br/> <br/>
        <input type="submit" name="submit_spell" value="submit" />
    </form>
    <?php
    if (isset($_POST["submit_spell"])) {
        //get the csv file
        $file = $_FILES[csv][tmp_name];
        $result = CVSUpload($file, 'Spell');
    }
    if ($result !='') {
        echo "<h5> Number of failed tuples uploads: ";
        echo $result['Failed'];
        echo "</h5><h5> Number of success uploads: ";
        echo $result['Success'];
        echo "</5>";
    }
    ?>

</div>
</body>
</html>