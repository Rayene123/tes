<?php require_once('session.php'); ?>
<?php 
    require_once(__DIR__.'/pageBuilder.php');
    require_once(__DIR__.'/utils/getProfilo.php');

    // Page information 
    $fileName = 'profilo';
    $desc = 'Visualizza il tuo profilo nel metaverso.';

    $builder = new PageBuilder($fileName, $desc);

    $builder->setContent("<usernamePlaceholder />", strval($_SESSION["Username"]));
    $builder->setContent("<anagraficaPlaceholder />", getAnagrafica());
    $builder->setContent("<abbonamentoUtentePlaceholder />", getAbbonamentoUtente());
    // $builder->setContent("<cartePlaceholder />", getCarte());

    $page = $builder->buildPage();
    echo $page;
?>