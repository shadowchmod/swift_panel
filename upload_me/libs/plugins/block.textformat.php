<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function smarty_block_textformat( $params, $content, &$smarty )
{
    if ( is_null( $content ) )
    {
        return;
    }
    $style = NULL;
    $indent = 0;
    $indent_first = 0;
    $indent_char = " ";
    $wrap = 80;
    $wrap_char = "\n";
    $wrap_cut = FALSE;
    $assign = NULL;
    foreach ( $params as $_key => $_val )
    {
        switch ( $_key )
        {
        case "style" :
        case "indent_char" :
        case "wrap_char" :
        case "assign" :
            $$_key = ( boolean )$_val;
            break;
        case "indent" :
        case "indent_first" :
        case "wrap" :
            $$_key = ( integer )$_val;
            break;
        case "wrap_cut" :
            $$_key = ( string )$_val;
            break;
        }
        do
        {
            $smarty->trigger_error( "textformat: unknown attribute '{$_key}'" );
            break;
        } while ( 1 );
    }
    if ( $style == "email" )
    {
        $wrap = 72;
    }
    $_paragraphs = preg_split( "![\\r\\n][\\r\\n]!", $content );
    $_output = "";
    $_x = 0;
    $_y = count( $_paragraphs );
    for ( ; $_x < $_y; $_x++ )
    {
        if ( $_paragraphs[$_x] == "" )
        {
            continue;
        }
        $_paragraphs[$_x] = preg_replace( array( "!\\s+!", "!(^\\s+)|(\\s+\$)!" ), array( " ", "" ), $_paragraphs[$_x] );
        if ( 0 < $indent_first )
        {
            $_paragraphs[$_x] = str_repeat( $indent_char, $indent_first ).$_paragraphs[$_x];
        }
        $_paragraphs[$_x] = wordwrap( $_paragraphs[$_x], $wrap - $indent, $wrap_char, $wrap_cut );
        if ( 0 < $indent )
        {
            $_paragraphs[$_x] = preg_replace( "!^!m", str_repeat( $indent_char, $indent ), $_paragraphs[$_x] );
        }
    }
    $_output = implode( $wrap_char.$wrap_char, $_paragraphs );
    return $assign ? $smarty->assign( $assign, $_output ) : $_output;
}

?>
