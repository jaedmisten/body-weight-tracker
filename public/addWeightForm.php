<?php include('header.php') ?>
<br><br><br>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h1>Body of Add Weight Page</h1>
        <br>

        <form action="src/insertWeight.php" method="post">
            Date And Time: <input id="datetimepicker" type="text" id="dateTime" value="dateTime"><br>
            <input type="submit" id="submit" name="submit">
        </form>
    </div>
</div>



<?php include('footer.php') ?>