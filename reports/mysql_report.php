<?php
require('fpdf.php');

class PDF extends FPDF {

var $tablewidths;
var $headerset;
var $footerset;

function _beginpage($orientation, $size) {
	$this->page++;
	if(!isset($this->pages[$this->page])) // solves the problem of overwriting a page if it already exists
		$this->pages[$this->page] = '';
	$this->state  =2;
	$this->x = $this->lMargin;
	$this->y = $this->tMargin;
	$this->FontFamily = '';
	// Check page size and orientation
	if($orientation=='')
		$orientation = $this->DefOrientation;
	else
		$orientation = strtoupper($orientation[0]);
	if($size=='')
		$size = $this->DefPageSize;
	else
		$size = $this->_getpagesize($size);
	if($orientation!=$this->CurOrientation || $size[0]!=$this->CurPageSize[0] || $size[1]!=$this->CurPageSize[1])
	{
		// New size or orientation
		if($orientation=='P')
		{
			$this->w = $size[0];
			$this->h = $size[1];
		}
		else
		{
			$this->w = $size[1];
			$this->h = $size[0];
		}
		$this->wPt = $this->w*$this->k;
		$this->hPt = $this->h*$this->k;
		$this->PageBreakTrigger = $this->h-$this->bMargin;
		$this->CurOrientation = $orientation;
		$this->CurPageSize = $size;
	}
	if($orientation!=$this->DefOrientation || $size[0]!=$this->DefPageSize[0] || $size[1]!=$this->DefPageSize[1])
		$this->PageSizes[$this->page] = array($this->wPt, $this->hPt);
}
   function IncludeJS($script) { 
        $this->javascript=$script; 
    } 
    function _putjavascript() { 
        $this->_newobj(); 
        $this->n_js=$this->n; 
        $this->_out('<<'); 
        $this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]'); 
        $this->_out('>>'); 
        $this->_out('endobj'); 
        $this->_newobj(); 
        $this->_out('<<'); 
        $this->_out('/S /JavaScript'); 
        $this->_out('/JS '.$this->_textstring($this->javascript)); 
        $this->_out('>>'); 
        $this->_out('endobj'); 
    } 
    function _putresources() { 
        parent::_putresources(); 
        if (!empty($this->javascript)) { 
            $this->_putjavascript(); 
        } 
    } 
    function _putcatalog() { 
        parent::_putcatalog(); 
        if (isset($this->javascript)) { 
            $this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>'); 
        } 
    }  
    
    function AutoPrint($dialog=false) 
    {     
        $param=($dialog ? 'true' : 'false'); 
        $script="print(".$param.");"; 
        $this->IncludeJS($script); 
    } 
function NbLines($w, $txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r", '', $txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

function Header()
{
	global $maxY;
$fullwidth=0;
$this->AddFont('courierb','B','courierb.php');                
$this->AddFont('timesb','B','timesb.php');                
$this->AddFont('timesbi','B','timesbi.php');   
$this->SetTextColor(0,0,0);$this->SetFont('courier','',11);
if(!$this->headerset[$this->page]) {

		foreach($this->tablewidths as $width) {
			$fullwidth += $width;
		}

$this->tMargin+=102;
$num=$this->wPt;
		$this->SetY((($this->tMargin) - ($this->FontSizePt/$this->k)*2));
		$this->cellFontSize = $this->FontSizePt ;
$sey=210;  $this->SetXY(30,$sey);
		$this->Cell(385,0,'             '.$this->name,0,1,'L');
$sey=$sey+18;   $this->SetXY(30,$sey);
                $this->Cell(385,0,'             '.$this->dir,0,1,'L');
$sey=$sey+18;   $this->SetXY(30,$sey);
                $this->Cell(170,0,'             '.$this->ruc,0,1,'L');
                $this->SetXY(220,$sey);
                $this->Cell(200,0,'           '.$this->guide,0,1,'L');

                $this->SetXY(450,275);
		$this->Cell(95,0,  $this->date,0,1,'C');
		$l = ($this->lMargin);
                
$this->tMargin+=81;
		foreach($this->colTitles as $col => $txt) {
			//$this->SetXY($l,45);
			$this->SetXY($l,($this->tMargin)+4);
			//$this->MultiCell(($this->tablewidths[$col]), $this->FontSizePt,$txt);
			$l += $this->tablewidths[$col] ;
			$maxY = ($maxY < $this->getY()) ? $this->getY() : $maxY ;
		}
                
		$this->SetXY($this->lMargin,($this->tMargin));
		$this->setFillColor(200,200,200);
		$l = ($this->lMargin);
		foreach($this->colTitles as $col => $txt) {
			$this->SetXY($l,($this->tMargin)-4);
			//$this->cell($this->tablewidths[$col],($maxY-($this->tMargin))+4,'',1,0,'L',1);
			$this->SetXY($l,$this->tMargin);
			//$this->MultiCell($this->tablewidths[$col],($this->FontSizePt),$txt,0,'C');
			$l += $this->tablewidths[$col];
		}
		$this->setFillColor(255,255,255);
		// set headerset
		$this->headerset[$this->page] = 1;
	}
        //$maxY=$maxY+18;  
	$this->SetY($maxY);
}

function Footer() {
	
}

function morepagestable($lineheight=8) {
	// some things to set and 'remember'
    $fullwidth=0;$maxpage=0;
	$l = $this->lMargin+2;
	$startheight = $h = $this->GetY();
	$startpage = $currpage = $this->page;

	// calculate the whole width
	foreach($this->tablewidths as $width) {
		$fullwidth += $width;
	}

	// Now let's start to write the table
	$row = 0;
	while($data=mysql_fetch_row($this->results)) {
            $tmpheight=  array();
		$this->page = $currpage;
		// write the horizontal borders
		//$this->Line($l,$h,$fullwidth+$l,$h);
		// write the content and remember the height of the highest col
		foreach($data as $col => $txt) {

			$this->page = $currpage;
			$this->SetXY($l,$h);
			$this->MultiCell($this->tablewidths[$col],($lineheight)+4,$txt,0,$this->colAlign[$col]);//LINEAS DE RESGISTROS

			$l += $this->tablewidths[$col];

			if($tmpheight[$row.$this->page] < $this->GetY()) {
				$tmpheight[$row.$this->page] = $this->GetY();
			}
			if($this->page > $maxpage)
				$maxpage = $this->page;
			unset($data[$col]);
		}
		// get the height we were in the last used page
		$h = $tmpheight[$row.$maxpage]+6;
		// set the "pointer" to the left margin
		$l = $this->lMargin;
		// set the $currpage to the last page
		$currpage = $maxpage;
		unset($data[$row]);
		$row++ ;
	}
	// draw the borders
	// we start adding a horizontal line on the last page
	$this->page = $maxpage;
	//$this->Line($l,$h,$fullwidth+$l,$h);
	// now we start at the top of the document and walk down
	for($i = $startpage; $i <= $maxpage; $i++) {
		$this->page = $i;
		$l = $this->lMargin;
		$t = ($i == $startpage) ? $startheight : $this->tMargin;
		$lh = ($i == $maxpage) ? $h : $this->h-$this->bMargin;
		//$this->Line($l,$t,$l,$lh);
		foreach($this->tablewidths as $width) {
			$l += $width;
			//$this->Line($l,$t,$l,$lh);
		}
	}
	// set it to the last page, if not it'll cause some problems
	$this->page = $maxpage;
}

function connect($host='localhost',$username='',$password='',$db=''){
	$this->conn = mysql_connect($host,$username,$password) or die( mysql_error() );
	mysql_select_db($db,$this->conn) or die( mysql_error() );
	return true;
}

function query($query){
	$this->results = mysql_query($query,$this->conn);
	$this->numFields = mysql_num_fields($this->results);
}

function mysql_report($query,$dump=false,$attr=array()){

	foreach($attr as $key=>$val){
		$this->$key = $val ;
	}

	$this->query($query);

	// if column widths not set
	if(!isset($this->tablewidths)){

		// starting col width
		$this->sColWidth = (($this->w-$this->lMargin-$this->rMargin))/$this->numFields;

		// loop through results header and set initial col widths/ titles/ alignment
		// if a col title is less than the starting col width / reduce that column size
		for($i=0;$i<$this->numFields;$i++){
			$stringWidth = $this->getstringwidth(mysql_field_name($this->results,$i)) + 6 ;
			if( ($stringWidth) < $this->sColWidth){
				$colFits[$i] = $stringWidth ;
				// set any column titles less than the start width to the column title width
			}
			$this->colTitles[$i] = mysql_field_name($this->results,$i) ;
			switch (mysql_field_type($this->results,$i)){
				case 'int':
					$this->colAlign[$i] = 'R';
					break;
				default:
					$this->colAlign[$i] = 'L';
			}
		}

		// loop through the data, any column whose contents is bigger that the col size is
		// resized
		while($row=mysql_fetch_row($this->results)){
			foreach($colFits as $key=>$val){
				$stringWidth = $this->getstringwidth($row[$key]) + 6 ;
				if( ($stringWidth) > $this->sColWidth ){
					// any col where row is bigger than the start width is now discarded
					unset($colFits[$key]);
				}else{
					// if text is not bigger than the current column width setting enlarge the column
					if( ($stringWidth) > $val ){
						$colFits[$key] = ($stringWidth) ;
					}
				}
			}
		}
                $totAlreadyFitted=0;
		foreach($colFits as $key=>$val){
			// set fitted columns to smallest size
			$this->tablewidths[$key] = $val;
			// to work out how much (if any) space has been freed up
			$totAlreadyFitted += $val;
		}

		$surplus = (sizeof($colFits)*$this->sColWidth) - ($totAlreadyFitted);
		for($i=0;$i<$this->numFields;$i++){
			if(!in_array($i,array_keys($colFits))){
				$this->tablewidths[$i] = $this->sColWidth + ($surplus/(($this->numFields)-sizeof($colFits)));
			}
		}

		ksort($this->tablewidths);

		if($dump){
			Header('Content-type: text/plain');
			for($i=0;$i<$this->numFields;$i++){
				if(strlen(mysql_field_name($this->results,$i))>$flength){
					$flength = strlen(mysql_field_name($this->results,$i));
				}
			}
			switch($this->k){
				case 72/25.4:
					$unit = 'millimeters';
					break;
				case 72/2.54:
					$unit = 'centimeters';
					break;
				case 72:
					$unit = 'inches';
					break;
				default:
					$unit = 'points';
			}
			print "All measurements in $unit\n\n";
			for($i=0;$i<$this->numFields;$i++){
				printf("%-{$flength}s : %-10s : %10f\n",
					mysql_field_name($this->results,$i),
					mysql_field_type($this->results,$i),
					$this->tablewidths[$i] );
			}
			print "\n\n";
			print "\$pdf->tablewidths=\n\tarray(\n\t\t";
			for($i=0;$i<$this->numFields;$i++){
				($i<($this->numFields-1)) ?
				print $this->tablewidths[$i].", /* ".mysql_field_name($this->results,$i)." */\n\t\t":
				print $this->tablewidths[$i]." /* ".mysql_field_name($this->results,$i)." */\n\t\t";
			}
			print "\n\t);\n";
			exit;
		}

	} else { // end of if tablewidths not defined

		for($i=0;$i<$this->numFields;$i++){
			$this->colTitles[$i] = mysql_field_name($this->results,$i) ;
			switch (mysql_field_type($this->results,$i)){
				case 'int':
					$this->colAlign[$i] = 'R';
					break;
				default:
					$this->colAlign[$i] = 'L';
			}
		}
	}

	mysql_data_seek($this->results,0);
	$this->AliasNbPages();
	$this->SetY($this->tMargin);
	$this->AddPage();
	$this->morepagestable($this->FontSizePt);
}

}
?>
