<?php
error_reporting(0);

function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
  $dt = date("Y-m-d H:i:s (T)");

  $errortype = array (
             E_ERROR              => 'Error',
             E_WARNING            => 'Warning',
             E_PARSE              => 'Parsing Error',
             E_NOTICE            => 'Notice',
             E_CORE_ERROR        => 'Core Error',
             E_CORE_WARNING      => 'Core Warning',
             E_COMPILE_ERROR      => 'Compile Error',
             E_COMPILE_WARNING    => 'Compile Warning',
             E_USER_ERROR        => 'User Error',
             E_USER_WARNING      => 'User Warning',
             E_USER_NOTICE        => 'User Notice',
             E_STRICT            => 'Runtime Notice',
             E_RECOVERABLE_ERROR  => 'Catchable Fatal Error'
             );

  $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

  $err = "<errorentry><br>\n";
  $err .= "\t<datetime>" . $dt . "</datetime><br>\n";
  $err .= "\t<errornum>" . $errno . "</errornum><br>";
  $err .= "\t<errortype>" . $errortype[$errno] . "</errortype><br>\n";
  $err .= "\t<errormsg>" . $errmsg . "</errormsg><br>\n";
  $err .= "\t<scriptname>" . $filename . "</scriptname><br>\n";
  $err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum><br>\n";

  if (in_array($errno, $user_errors)) {
      $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace><br>\n";
  }
  $err .= "</errorentry><br>\n";

  error_log($err, 3, "logs/error.log");
  if ($errno == E_USER_ERROR) {
    mail("johns08@myunitec.ac.nz", "Critical User Error", $err, "FROM: qualitybags@dochyper.unitec.ac.nz");
  }
}

?>
