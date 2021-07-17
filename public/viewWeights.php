<?php include('views/header.php') ?>
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

            echo '<pre>';
            print_r($weights);
            echo '</pre>';

        } catch (PDOException $e) {
            var_dump($e);
            echo $e->getMessage();
        }
        ?>
    </div>
</div>

<?php include('views/footer.php') ?>