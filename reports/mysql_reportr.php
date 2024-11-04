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
function Header()
{
    	$this->AddFont('courierb','B','courierb.php');                
$this->AddFont('timesb','B','timesb.php');                
$this->AddFont('timesbi','B','timesbi.php');                
$this->AddFont('helveticab','B','helveticab.php');
$this->Image('dre.png',30,20,-220);                
$this->Image('insignia.jpg',770,20,-185);
$this->SetTextColor(90,90,90);
$this->SetFont('timesb','B',11);
$this->Cell(0,-130,'INSTITUTO DE EDUCACIÓN SUPERIOR PEDAGÓGICO PÚBLICO TUPAC AMARU',0,1,'C');
$this->SetFont('courierb','B',11);
$this->Cell(0,150,'OFICINA DE ADMINISTRACION - TESORERIA',0,1,'C');
$this->SetFont('timesb','B',10);
$this->Cell(0,-129,'RUC: 20527311510',0,1,'C');
$this->SetLineWidth(1);
$this->SetDrawColor(120,120,120);
//$this->Line(30,60,565,60);
$this->Line(30,61,810,61);
$this->SetLineWidth(1);
$this->SetTextColor(0,0,0);

}

function Footer() {
	// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Número de página
			$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
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

 function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }
    
     function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);
 
        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;
 
        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }
 
        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);
 
        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }
    
     function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
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
