<?php 
    try 
    {
      $bdd = new PDO("mysql:host=localhost;dbname=ucszhsva_competence;charset=utf8", "ucszhsva_clement", "Thuillierclement=10");
    }
    catch(PDOException $e)
    {
      die('Erreur : '.$e->getMessage());
    }
