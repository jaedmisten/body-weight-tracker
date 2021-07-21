<?php include('header.php') ?>
<br><br><br>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h1>Body of Add Weight Page</h1>
        <br>

        <form action="insertWeight.php" method="post">
            Date And Time: <input id="datetimepicker" type="text" id="dateTime" name="dateTime" value=""><br>
            Weight (lbs): <input id="weight" type="number" step=".1" name="weight" value=""><br>
            <input type="submit" id="submit" name="submit">
        </form>
    </div>
</div>



<?php include('footer.php') ?>