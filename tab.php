<?php
$dsn = 'mysql:dbname=cms_kania;localhost';
$user = 'root';
$password="";

try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh -> query ('SET NAMES utf8');
    $dbh -> query ('SET CHARACTER_SET utf8_unicode_ci');
} 
catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}




    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);

if(isset($request -> a))
    switch($request -> a)
    {
        case 0:
            echo $postdata;
            break;
            
        case 1:         
            try {
                $sql = $dbh->prepare("INSERT INTO `tab` (`id`, `top`, `left`, `content`, `index`, `timeid`, `width`, `height`) VALUES (NULL,:top,:left, :content, :index, :timeid, :width, :height)");                
                $sql->bindParam(':top',$request->data->top); 
                $sql->bindParam(':left',$request->data->left); 
                $sql->bindParam(':content',$request->data->content); 
                $sql->bindParam(':index',$request->data->index); 
                $sql->bindParam(':timeid',$request->data->timeid); 
                $sql->bindParam(':width',$request->data->width);                
                $sql->bindParam(':height',$request->data->height);
                $sql->execute();    
                
                //SELECT `value` FROM `var` WHERE `name` = 'total'
                
                $sql = $dbh->prepare("SELECT `value` FROM `var` WHERE `name` = 'total'");  
                $sql->execute(); 
                $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                if(count($result)>0)
                { 
                    $total= $result[0]["value"]+1;
                    $sql = $dbh->prepare("UPDATE `var` SET `value` = :total WHERE `name` = 'total'"); 
                    $sql->bindParam(':total',$total);
                    $sql->execute(); 
                }
            } 
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
            
            echo "ADD - OK";
            break;
            
        case 2:
            try {
                $sql = $dbh->prepare("DELETE FROM `tab` WHERE `timeid` = :timeid");                

                $sql->bindParam(':timeid',$request->data->timeid); 

                $sql->execute();    
            } 
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
            
            echo "DEL - OK";
            break;
            
        case 3: 
            try {
                $sql = $dbh->prepare("UPDATE `tab` SET `top` = :top, `left` = :left WHERE `timeid` = :timeid");                

                $sql->bindParam(':timeid',$request->data->timeid); 
                $sql->bindParam(':top',$request->data->top); 
                $sql->bindParam(':left',$request->data->left); 
                $sql->execute();    
            } 
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
            
            echo "MOVE - OK";
            break;
            
        case 4: 
            try {
                $sql = $dbh->prepare("UPDATE `tab` SET `content` = :content  WHERE `timeid` = :timeid");                
                $sql->bindParam(':content',$request->data->content); 
                $sql->bindParam(':timeid',$request->data->timeid); 
                $sql->execute();    
            } 
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
            
            echo "EDIT - OK";
            break;
            
         case 5: 
            try {
                $sql = $dbh->prepare("UPDATE `tab` SET `height` = :height, `width` = :width WHERE `timeid` = :timeid");                

                $sql->bindParam(':timeid',$request->data->timeid); 
                $sql->bindParam(':width',$request->data->width);                
                $sql->bindParam(':height',$request->data->height);
                $sql->execute();    
            } 
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
            
            echo "RESIZE - OK";
            break;
            
         case 6: 
            try {
                $sql = $dbh->prepare("UPDATE `tab` SET `index` = :index  WHERE `timeid` = :timeid");                

                $sql->bindParam(':timeid',$request->data->timeid); 
                $sql->bindParam(':index',$request->data->index); 
                $sql->execute();    
            } 
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
            
            echo "INDEX - OK";
            break;
            
         case 7: 
            try {
                 $sql = $dbh->prepare("SELECT `value` FROM `var` WHERE `name` = 'total'");  
                $sql->execute(); 
                $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($result);
            } 
            catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }

            break;
            
    }
    
?>
