<?
	/* stolen lovingly from http://stackoverflow.com/questions/8071982/php-converting-xml-to-array?rq=1 */
	function xmlNameSpaceToArray(SimpleXmlIterator $xml, $nameSpaces=Null){
      $output = Null;
      $preparedArray = array();
      for($xml->rewind(); $xml->valid(); $xml->next()) {
        $key = $xml->key();
        if(!isset($preparedArray[$key])) { $preparedArray[$key] = array(); $i=0; }
        else $i = count($preparedArray[$key]);
        $simple = true;
        foreach($xml->current()->attributes() as $k=>$v) {
            $preparedArray[$key][$i][$k]=(string)$v;
            $simple = false;
        }
        if($nameSpaces) foreach($nameSpaces as $nid=>$name) {
          foreach($xml->current()->attributes($name) as $k=>$v) {
             $preparedArray[$key][$i][$nid.':'.$k]=(string)$v;
             $simple = false;
          }
        } 
        if($xml->hasChildren()) {
            if($simple) $preparedArray[$key][$i] = xmlNameSpaceToArray($xml->current(), $nameSpaces);
            else $preparedArray[$key][$i]['content'] = xmlNameSpaceToArray($xml->current(), $nameSpaces);
        } else {
            if($simple) $preparedArray[$key][$i] = strval($xml->current());
            else $preparedArray[$key][$i]['content'] = strval($xml->current());
        }
        $i++;
      }
      $output = $preparedArray;
      return $preparedArray;
    }

    function xmlToArray($xmlFilePath)
	{
        $xml = new SimpleXmlIterator($xmlFilePath , null, true);
        $nameSpaces = $xml->getNamespaces(true);
        $output = xmlNameSpaceToArray($xml,$nameSpaces);
        return $output;
    }
?>