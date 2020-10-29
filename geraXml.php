<?php

/* 
 * Autor: Weuller Marcos
 * Data: 29/10/2020
 */

function parseToXML($htmlStr){
    
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    
    return $xmlStr;
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;

$mysqli = new mysqli('localhost', 'root', '', 'google_maps');
$mysqli->set_charset("utf8");

if ($mysqli->connect_error) {

    echo "Erro ao conectar com o banco de dados: " . $mysqli->connect_error;
}
else{

    
    #Criando Query
   $sql = "SELECT * FROM markers WHERE 1";

    #executando Query
    if($sql = $mysqli->query($sql)){

        #se encontrou resultado
        if ($sql->num_rows > 0) {

            #Percorre resultados encontrados
            while($row = $sql->fetch_assoc()) {

                // Add to XML document node
                echo '<marker ';
                echo 'id="' . $row['id'] . '" ';
                echo 'name="' . parseToXML($row['name']) . '" ';
                echo 'address="' . parseToXML($row['address']) . '" ';
                echo 'lat="' . $row['lat'] . '" ';
                echo 'lng="' . $row['lng'] . '" ';
                echo 'type="' . $row['type'] . '" ';
                echo '/>';
                $ind = $ind + 1;

            }
            
            // End XML file
            echo '</markers>';
        }
    }
}

?>
