<?php require_once "mod.marlin.php" ?>

<!DOCTYPE html>
<html>
<head>
    <title>Marlin Test</title>
</head>
<body>

<form action="" method="post">
    <select name="kota">
        <option value="">--Pilih Kota Tujuan--</option>
        <?php
            foreach ($dataKota as $value){
        ?>
                <option value="<?=$value['city_id']?>"><?=$value['city_name']?></option>
        <?php
            }
        ?>
    </select>
    <input name="berat" placeholder="berat (gram)">
    <input name="kurir" placeholder="kurir">
    <button type="submit" name="input">Submit</button>
</form>

</body>
</html>
