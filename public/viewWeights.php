<?php include('../config/connect.php') ?>
<?php include('header.php') ?>
<br><br><br>
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h1>Body of View Weights Page</h1>

        <?php
        try {
            $sql = 'SELECT * FROM weights';
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $weights = $stmt->fetchAll(PDO::FETCH_ASSOC);
            /*
            echo '<pre>';
            print_r($weights);
            echo '</pre>';
            */
        } catch (PDOException $e) {
            var_dump($e);
            echo $e->getMessage();
        }
        ?>

        <table id="weights-table" style="width:100%">
            <tr>
                <th>Date</th>
                <th>Weight</th>
                <th>Actions</th>
            </tr>
            <?php foreach($weights as $weight) : ?>           
            </tr>
            
                <td><?php echo $weight["date"] ?></td>
                <td><?php echo $weight["weight"] ?></td>
                <td><a type="button" class="btn btn-info" href="">Edit</a>&nbsp;&nbsp;<a type="button" class="btn btn-danger" href="">Delete</a></td>
            </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>

<?php include('footer.php') ?>