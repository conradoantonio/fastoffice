<script type="text/php">
    if (isset($pdf)) {
	    $x = 470;
	    $y = 730;
	    $text = "Página {PAGE_NUM} | {PAGE_COUNT}";
	    $font = $fontMetrics->get_font("Roboto");
	    $size = 12;
	    $color = array(0.266,0.329,0.415);
	    $word_space = 0.0;  //  default
	    $char_space = 0.0;  //  default
	    $angle = 0.0;   //  default
	    $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
	}
</script>