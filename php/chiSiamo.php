<?php require_once('session.php'); ?>
<?php 
    require_once(__DIR__.'/pageBuilder.php');

    // Page information 
    $fileName = 'chi-siamo';
    $desc = 'blabalb';

    $builder = new PageBuilder($fileName, $desc);

    $page = $builder->buildPage();
    echo $page;
?>