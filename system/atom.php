<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////
class AtomFeed
{
    protected $dom;
    protected $root;

    public function __construct($attributes=array()){
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $this->dom = $dom;
        $root = $dom->createElement('feed');
        $this->root = $root;
        $dom->appendChild($root);
        $root->setAttribute('xmlns', 'http://www.w3.org/2005/Atom');
        foreach($attributes as $key => $value){
            $root->setAttribute($key, $value);
        }
    }

    public function saveXML(){
        return $this->dom->saveXML();
    }

    public function title($value, $type='html'){
        $title = $this->root->appendChild($this->dom->createElement('title'));
        $title->appendChild($this->dom->createCDATASection($value));
        $title->setAttribute('type', $type);
    }

    public function link($href, $rel=null){
        $link = $this->root->appendChild($this->dom->createElement('link'));
        $link->setAttribute('href', $href);
        if($rel) $link->setAttribute('rel', $rel);
    }

    public function updated($value){
        $date = new DateTime($value);
        $this->root->appendChild(
            $this->dom->createElement('updated', $date->format(DateTime::RFC3339))
        );
    }

    public function id($value){
        $this->root->appendChild($this->dom->createElement('id', $value));
    }

    public function author($params){
        $author = $this->dom->createElement('author');
        foreach($params as $key => $value){
            $author->appendChild($this->dom->createElement($key, $value));
        }
        $this->root->appendChild($author);
    }

    public function addEntry($entry){
        $node = $this->dom->createElement('entry');
        $this->root->appendChild($node);

        $params = $entry->all();
        foreach($params as $param){
            $element = $this->dom->createElement($param['name']);
            $node->appendChild($element);

            if(isset($param['value']) && !is_null($param['value'])) {
                if(isset($param['cdata']) && $param['cdata'] === true){
                    $cdata = $this->dom->createCDATASection($param['value']);
                    $element->appendChild($cdata);
                } else {
                    $textNode = $this->dom->createTextNode($param['value']);
                    $element->appendChild($textNode);
                }
            }

            if(isset($param['attributes'])){
                foreach($param['attributes'] as $attrKey => $attrValue){
                    if(is_null($attrValue)) continue;
                    $element->setAttribute($attrKey, $attrValue);
                }
            }

            if(isset($param['values']) && is_array($param['values'])) {
                foreach($param['values'] as $key2 => $param2){
                    $child = $this->dom->createElement($key2);
                    $element->appendChild($child);

                    if(isset($param2['value']) && !is_null($param2['value'])) {
                        if(isset($param2['cdata']) && $param2['cdata'] === true){
                            $cdata = $this->dom->createCDATASection($param2['value']);
                            $child->appendChild($cdata);
                        } else {
                            $textNode = $this->dom->createTextNode($param2['value']);
                            $child->appendChild($textNode);
                        }
                    }

                    if(isset($param2['attributes'])){
                        foreach($param2['attributes'] as $attrKey => $attrValue){
                            if(is_null($attrValue)) continue;
                            $child->setAttribute($attrKey, $attrValue);
                        }
                    }
                }
            }
        }
    }

}
/////////////////////////////////////////////////////////////////////////////////////////////////////
class AtomEntry
{
    protected $params = array();

    public function all(){
        return $this->params;
    }

    public function title($value, $type='html'){
        $this->params[] = array('name' => 'title', 'value' => $value, 'attributes' => array('type' => $type), 'cdata' => true);
    }

    public function link($href, $rel='alternate', $type=null, $title=null, $length=null){
        $this->params[] = array('name'       => 'link',
                                'attributes' => array('href' => $href, 'rel' => $rel, 'type' => $type,
                                'title'      => $title, 'length' => $length)
        );
    }

    public function updated($value){
        $date = new DateTime($value);
        $this->params[] = array('name' => 'updated', 'value' => $date->format(DateTime::RFC3339));
    }

    public function author($params){
        $values = array();
        foreach($params as $key => $value){
            $values[$key] = array('value' => $value);
        }
        $this->params[] = array('name' => 'author', 'values' => $values);
    }

    public function id($value){
        $this->params[] = array('name' => 'id', 'value' => $value);
    }

    public function summary($value){
        $this->params[] = array('name' => 'summary', 'value' => $value, 'attributes' => array('type' => 'html'), 'cdata' => true);
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////
$contents2 = dbSortedContents(array());
extract($contents2[0]);
global $blog;
//
$atom = new AtomFeed(array('xml:lang' => 'ja'));
$atom->title($blog);
$atom->link("{$_SERVER['SCRIPT_NAME']}");
$atom->link("{$_SERVER['REQUEST_URI']}", 'self');
$atom->id("{$_SERVER['SCRIPT_NAME']}/feed");
$atom->updated($moddate);
$atom->author(array( 'name' => 'nyankoPress'));
 
$cnt = 0;
foreach( $contents2 as $value ){
    extract($value);
    $entry = new AtomEntry();
    $entry->title($title);
    $entry->link("{$_SERVER['SCRIPT_NAME']}?p={$page}");
    $entry->id("{$_SERVER['SCRIPT_NAME']}/p{$page}");
    $entry->summary(mb_strimwidth(strip_tags($contents),0, 80, '…', 'utf-8'));
    $entry->updated($moddate);
    $entry->author(array( 'name' => $author));
    $atom->addEntry($entry);
    $cnt++;
    if( $cnt >= 10 ){
        break;
    }
}

header('Content-Type: application/atom+xml');
echo $atom->saveXml();
