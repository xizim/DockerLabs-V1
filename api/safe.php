<?php
$a="A' and '' ='";
function filterWords($str)
{
    $farr = array(
            "/<(\\/?)(script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU",
            "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
            "/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile|dump/is"
    );
    $str = preg_replace($farr,'',$str);
    return $str;
}
/**
 *  防护提示页
 */
function webscan_pape(){
  $pape=<<<HTML
  <html>
  <body style="margin:0; padding:0">
  <center><iframe width="100%" align="center" height="100%" frameborder="0" scrolling="no" src="https://www.xiz.im"></iframe></center>
  </body>
  </html>
HTML;
  echo $pape;
}
function Ifrequest($key,$value)
{

	if (preg_match("/select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile|dump/is",$value)==1) {
      exit(webscan_pape());
	}
}

foreach($_GET as $key=>$value) {
	Ifrequest($key,$value);
}
