<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_function_custom_form( $params, &$smarty )
{
    $hiddens = "";
    $submit = "Submit";
    if ( !isset( $params['inputs'] ) )
    {
        $smarty->trigger_error( "custom_form: missing 'inputs' parameter" );
        return;
    }
    foreach ( $params as $_key => $_value )
    {
        switch ( $_key )
        {
        case "inputs" :
        case "hiddens" :
            $$_key = ( array )$_value;
            break;
        case "action" :
            $$_key = ( boolean )$_value;
            break;
        }
    }
    $output = "<form method=\"post\" action=\"".$action."\">\n";
    foreach ( $hiddens as $_key => $_value )
    {
        $output .= "<input type=\"hidden\" name=\"".$_key."\" value=\"".$_value."\" />\n";
    }
    $output .= "<fieldset>\n\r\n\t\t\t\t<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\">\n";
    foreach ( $inputs as $_key => $_value )
    {
        if ( isset( $_SESSION[$_key] ) )
        {
            $value = $_SESSION[$_key];
            unset( $_SESSION[$_key] );
        }
        switch ( $_value[0] )
        {
        case "text" :
            $output .= "<tr>\n\r\n      \t\t\t\t  \t\t  <td class=\"fieldname\" style=\"width:140px;\">".$_value[1]."</td>\n\r\n      \t\t\t\t  \t\t  <td class=\"fieldarea\">\r\n\t\t\t\t\t    \t    <input type=\"text\" name=\"".$_key."\" size=\"".$_value[2]."\" value=\"".$value."\">\r\n\t\t\t\t\t    \t\t<font color=\"#666666\" size=\"-2\">".$_value[3]."</font></td>\n\r\n    \t\t\t\t\t\t</tr>\n";
            break;
        case "radio" :
            $output .= "<tr>\n\r\n      \t\t\t\t  \t\t  <td class=\"fieldname\" style=\"width:140px;\">".$_value[1]."</td>\n\r\n      \t\t\t\t  \t\t  <td class=\"fieldarea\">";
            foreach ( $_value[2] as $_key2 => $_value2 )
            {
                $output .= "<label for=\"".$_key.$_key2."\"><input type=\"radio\" name=\"".$_key."\" id=\"".$_key.$_key2."\" value=\"".$_value2."\">".$_value2;
            }
            $output .= "</td>\n</tr>\n";
            break;
        case "textarea" :
            $output .= "<tr>\n\r\n      \t\t\t\t  \t\t  <td class=\"fieldname\" style=\"width:140px;\">".$_value[1]."</td>\n\r\n      \t\t\t\t  \t\t  <td class=\"fieldarea\">\r\n\t\t\t\t\t    \t    <textarea name=\"".$_key."\" cols=\"".$_value[2]."\" rows=\"".$_value[3]."\">".$value."</textarea></td>\n\r\n    \t\t\t\t\t\t</tr>\n";
            break;
        }
    }
    $output .= "</table>\n\r\n\t          </fieldset>\n\r\n\t          <img src=\"images/spacer.gif\" height=\"10\" width=\"1\"><br />\n\r\n              <div align=\"center\">\n\r\n                <input type=\"submit\" style=\"color:#006600;\" value=\"Add New Box\" class=\"button\">\n\r\n              </div>\n\r\n\t\t\t</form>\n";
    return $output;
}

?>
