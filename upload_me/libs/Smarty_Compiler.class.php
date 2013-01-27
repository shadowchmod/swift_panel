<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function _smarty_sort_length( $a, $b )
{
    if ( $a == $b )
    {
        return 0;
    }
    if ( strlen( $a ) == strlen( $b ) )
    {
        return $b < $a ? 0 - 1 : 1;
    }
    return strlen( $b ) < strlen( $a ) ? 0 - 1 : 1;
}

class Smarty_Compiler
{

    public $_folded_blocks = array( );
    public $_current_file = NULL;
    public $_current_line_no = 1;
    public $_capture_stack = array( );
    public $_plugin_info = array( );
    public $_init_smarty_vars = FALSE;
    public $_permitted_tokens = array
    (
        0 => "true",
        1 => "false",
        2 => "yes",
        3 => "no",
        4 => "on",
        5 => "off",
        6 => "null"
    );
    public $_db_qstr_regexp = NULL;
    public $_si_qstr_regexp = NULL;
    public $_qstr_regexp = NULL;
    public $_func_regexp = NULL;
    public $_reg_obj_regexp = NULL;
    public $_var_bracket_regexp = NULL;
    public $_num_const_regexp = NULL;
    public $_dvar_guts_regexp = NULL;
    public $_dvar_regexp = NULL;
    public $_cvar_regexp = NULL;
    public $_svar_regexp = NULL;
    public $_avar_regexp = NULL;
    public $_mod_regexp = NULL;
    public $_var_regexp = NULL;
    public $_parenth_param_regexp = NULL;
    public $_func_call_regexp = NULL;
    public $_obj_ext_regexp = NULL;
    public $_obj_start_regexp = NULL;
    public $_obj_params_regexp = NULL;
    public $_obj_call_regexp = NULL;
    public $_cacheable_state = 0;
    public $_cache_attrs_count = 0;
    public $_nocache_count = 0;
    public $_cache_serial = NULL;
    public $_cache_include = NULL;
    public $_strip_depth = 0;
    public $_additional_newline = "\n";

    public function Smarty_Compiler( )
    {
        $this->_db_qstr_regexp = "\"[^\"\\\\]*(?:\\\\.[^\"\\\\]*)*\"";
        $this->_si_qstr_regexp = "'[^'\\\\]*(?:\\\\.[^'\\\\]*)*'";
        $this->_qstr_regexp = "(?:".$this->_db_qstr_regexp."|".$this->_si_qstr_regexp.")";
        $this->_var_bracket_regexp = "\\[\\\$?[\\w\\.]+\\]";
        $this->_num_const_regexp = "(?:\\-?\\d+(?:\\.\\d+)?)";
        $this->_dvar_math_regexp = "(?:[\\+\\*\\/\\%]|(?:-(?!>)))";
        $this->_dvar_math_var_regexp = "[\\\$\\w\\.\\+\\-\\*\\/\\%\\d\\>\\[\\]]";
        $this->_dvar_guts_regexp = "\\w+(?:".$this->_var_bracket_regexp.")*(?:\\.\\\$?\\w+(?:".$this->_var_bracket_regexp.")*)*(?:".$this->_dvar_math_regexp."(?:".$this->_num_const_regexp."|".$this->_dvar_math_var_regexp.")*)?";
        $this->_dvar_regexp = "\\\$".$this->_dvar_guts_regexp;
        $this->_cvar_regexp = "\\#\\w+\\#";
        $this->_svar_regexp = "\\%\\w+\\.\\w+\\%";
        $this->_avar_regexp = "(?:".$this->_dvar_regexp."|".$this->_cvar_regexp."|".$this->_svar_regexp.")";
        $this->_var_regexp = "(?:".$this->_avar_regexp."|".$this->_qstr_regexp.")";
        $this->_obj_ext_regexp = "\\->(?:\\\$?".$this->_dvar_guts_regexp.")";
        $this->_obj_restricted_param_regexp = "(?:"."(?:".$this->_var_regexp."|".$this->_num_const_regexp.")(?:".$this->_obj_ext_regexp."(?:\\((?:(?:".$this->_var_regexp."|".$this->_num_const_regexp.")"."(?:\\s*,\\s*(?:".$this->_var_regexp."|".$this->_num_const_regexp."))*)?\\))?)*)";
        $this->_obj_single_param_regexp = "(?:\\w+|".$this->_obj_restricted_param_regexp."(?:\\s*,\\s*(?:(?:\\w+|".$this->_var_regexp.$this->_obj_restricted_param_regexp.")))*)";
        $this->_obj_params_regexp = "\\((?:".$this->_obj_single_param_regexp."(?:\\s*,\\s*".$this->_obj_single_param_regexp.")*)?\\)";
        $this->_obj_start_regexp = "(?:".$this->_dvar_regexp."(?:".$this->_obj_ext_regexp.")+)";
        $this->_obj_call_regexp = "(?:".$this->_obj_start_regexp."(?:".$this->_obj_params_regexp.")?(?:".$this->_dvar_math_regexp."(?:".$this->_num_const_regexp."|".$this->_dvar_math_var_regexp.")*)?)";
        $this->_mod_regexp = "(?:\\|@?\\w+(?::(?:\\w+|".$this->_num_const_regexp."|".$this->_obj_call_regexp."|".$this->_avar_regexp."|".$this->_qstr_regexp."))*)";
        $this->_func_regexp = "[a-zA-Z_]\\w*";
        $this->_reg_obj_regexp = "[a-zA-Z_]\\w*->[a-zA-Z_]\\w*";
        $this->_param_regexp = "(?:\\s*(?:".$this->_obj_call_regexp."|".$this->_var_regexp."|".$this->_num_const_regexp."|\\w+)(?>".$this->_mod_regexp."*)\\s*)";
        $this->_parenth_param_regexp = "(?:\\((?:\\w+|".$this->_param_regexp."(?:\\s*,\\s*(?:(?:\\w+|".$this->_param_regexp.")))*)?\\))";
        $this->_func_call_regexp = "(?:".$this->_func_regexp."\\s*(?:".$this->_parenth_param_regexp."))";
    }

    public function _compile_file( $resource_name, $source_content, &$compiled_content )
    {
        if ( $this->security )
        {
            if ( $this->php_handling == SMARTY_PHP_ALLOW && !$this->security_settings['PHP_HANDLING'] )
            {
                $this->php_handling = SMARTY_PHP_PASSTHRU;
            }
        }
        $this->_load_filters( );
        $this->_current_file = $resource_name;
        $this->_current_line_no = 1;
        $ldq = preg_quote( $this->left_delimiter, "~" );
        $rdq = preg_quote( $this->right_delimiter, "~" );
        if ( 0 < count( $this->_plugins['prefilter'] ) )
        {
            foreach ( $this->_plugins['prefilter'] as $filter_name => $prefilter )
            {
                if ( $prefilter === FALSE )
                {
                    continue;
                }
                if ( $prefilter[3] || is_callable( $prefilter[0] ) )
                {
                    $source_content = call_user_func_array( $prefilter[0], array(
                        $source_content,
                        $this
                    ) );
                    $this->_plugins['prefilter'][$filter_name][3] = TRUE;
                }
                else
                {
                    $this->_trigger_fatal_error( "[plugin] prefilter '{$filter_name}' is not implemented" );
                }
            }
        }
        $search = "~{$ldq}\\*(.*?)\\*{$rdq}|{$ldq}\\s*literal\\s*{$rdq}(.*?){$ldq}\\s*/literal\\s*{$rdq}|{$ldq}\\s*php\\s*{$rdq}(.*?){$ldq}\\s*/php\\s*{$rdq}~s";
        preg_match_all( $search, $source_content, $match, PREG_SET_ORDER );
        $this->_folded_blocks = $match;
        reset( $this->_folded_blocks );
        $source_content = preg_replace( $search."e", "'".$this->_quote_replace( $this->left_delimiter )."php"."' . str_repeat(\"\n\", substr_count('\\0', \"\n\")) .'".$this->_quote_replace( $this->right_delimiter )."'", $source_content );
        preg_match_all( "~{$ldq}\\s*(.*?)\\s*{$rdq}~s", $source_content, $_match );
        $template_tags = $_match[1];
        $text_blocks = preg_split( "~{$ldq}.*?{$rdq}~s", $source_content );
        $curr_tb = 0;
        $for_max = count( $text_blocks );
        for ( ; $curr_tb < $for_max; $curr_tb++ )
        {
            if ( preg_match_all( "~(<\\?(?:\\w+|=)?|\\?>|language\\s*=\\s*[\\\"']?\\s*php\\s*[\\\"']?)~is", $text_blocks[$curr_tb], $sp_match ) )
            {
                $sp_match[1] = array_unique( $sp_match[1] );
                usort( $sp_match[1], "_smarty_sort_length" );
                $curr_sp = 0;
                $for_max2 = count( $sp_match[1] );
                for ( ; $curr_sp < $for_max2; $curr_sp++ )
                {
                    $text_blocks[$curr_tb] = str_replace( $sp_match[1][$curr_sp], "%%%SMARTYSP".$curr_sp."%%%", $text_blocks[$curr_tb] );
                }
                $curr_sp = 0;
                $for_max2 = count( $sp_match[1] );
                for ( ; $curr_sp < $for_max2; $curr_sp++ )
                {
                    if ( $this->php_handling == SMARTY_PHP_PASSTHRU )
                    {
                        $text_blocks[$curr_tb] = str_replace( "%%%SMARTYSP".$curr_sp."%%%", "<?php echo '".str_replace( "'", "\\'", $sp_match[1][$curr_sp] )."'; ?>"."\n", $text_blocks[$curr_tb] );
                    }
                    else if ( $this->php_handling == SMARTY_PHP_QUOTE )
                    {
                        $text_blocks[$curr_tb] = str_replace( "%%%SMARTYSP".$curr_sp."%%%", htmlspecialchars( $sp_match[1][$curr_sp] ), $text_blocks[$curr_tb] );
                    }
                    else if ( $this->php_handling == SMARTY_PHP_REMOVE )
                    {
                        $text_blocks[$curr_tb] = str_replace( "%%%SMARTYSP".$curr_sp."%%%", "", $text_blocks[$curr_tb] );
                    }
                    else
                    {
                        $sp_match[1][$curr_sp] = preg_replace( "~(<\\?(?!php|=|\$))~i", "<?php echo '\\1'?>"."\n", $sp_match[1][$curr_sp] );
                        $text_blocks[$curr_tb] = str_replace( "%%%SMARTYSP".$curr_sp."%%%", $sp_match[1][$curr_sp], $text_blocks[$curr_tb] );
                    }
                }
            }
        }
        $compiled_tags = array( );
        $i = 0;
        $for_max = count( $template_tags );
        for ( ; $i < $for_max; $i++ )
        {
            $this->_current_line_no += substr_count( $text_blocks[$i], "\n" );
            $compiled_tags[] = $this->_compile_tag( $template_tags[$i] );
            $this->_current_line_no += substr_count( $template_tags[$i], "\n" );
        }
        if ( 0 < count( $this->_tag_stack ) )
        {
            list( $_open_tag, $_line_no ) = end( $this->_tag_stack );
            $this->_syntax_error( "unclosed tag \\{{$_open_tag}} (opened line {$_line_no}).", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 317 );
            return;
        }
        $strip = FALSE;
        $i = 0;
        $for_max = count( $compiled_tags );
        for ( ; $i < $for_max; $i++ )
        {
            if ( $compiled_tags[$i] == "{strip}" )
            {
                $compiled_tags[$i] = "";
                $strip = TRUE;
                $text_blocks[$i + 1] = ltrim( $text_blocks[$i + 1] );
            }
            if ( $strip )
            {
                $j = $i + 1;
                for ( ; $j < $for_max; $j++ )
                {
                    $text_blocks[$j] = preg_replace( "![\\t ]*[\\r\\n]+[\\t ]*!", "", $text_blocks[$j] );
                    if ( $compiled_tags[$j] == "{/strip}" )
                    {
                        $text_blocks[$j] = rtrim( $text_blocks[$j] );
                    }
                    $text_blocks[$j] = "<?php echo '".strtr( $text_blocks[$j], array( "'" => "\\'", "\\" => "\\\\" ) )."'; ?>";
                    if ( $compiled_tags[$j] == "{/strip}" )
                    {
                        $compiled_tags[$j] = "\n";
                        $strip = FALSE;
                        $i = $j;
                        break;
                    }
                }
            }
        }
        $compiled_content = "";
        $tag_guard = "%%%SMARTYOTG".md5( uniqid( rand( ), TRUE ) )."%%%";
        $i = 0;
        $for_max = count( $compiled_tags );
        for ( ; $i < $for_max; $i++ )
        {
            if ( $compiled_tags[$i] == "" )
            {
                $text_blocks[$i + 1] = preg_replace( "~^(\\r\\n|\\r|\\n)~", "", $text_blocks[$i + 1] );
            }
            $text_blocks[$i] = str_replace( "<?", $tag_guard, $text_blocks[$i] );
            $compiled_tags[$i] = str_replace( "<?", $tag_guard, $compiled_tags[$i] );
            $compiled_content .= $text_blocks[$i].$compiled_tags[$i];
        }
        $compiled_content .= str_replace( "<?", $tag_guard, $text_blocks[$i] );
        $compiled_content = str_replace( "<?", "<?php echo '<?' ?>\n", $compiled_content );
        $compiled_content = preg_replace( "~(?<!')language\\s*=\\s*[\"\\']?\\s*php\\s*[\"\\']?~", "<?php echo 'language=php' ?>\n", $compiled_content );
        $compiled_content = str_replace( $tag_guard, "<?", $compiled_content );
        if ( strlen( $compiled_content ) && substr( $compiled_content, 0 - 1 ) == "\n" )
        {
            $compiled_content = substr( $compiled_content, 0, 0 - 1 );
        }
        if ( !empty( $this->_cache_serial ) )
        {
            $compiled_content = "<?php \$this->_cache_serials['".$this->_cache_include."'] = '".$this->_cache_serial."'; ?>".$compiled_content;
        }
        if ( 0 < count( $this->_plugins['postfilter'] ) )
        {
            foreach ( $this->_plugins['postfilter'] as $filter_name => $postfilter )
            {
                if ( $postfilter === FALSE )
                {
                    continue;
                }
                if ( $postfilter[3] || is_callable( $postfilter[0] ) )
                {
                    $compiled_content = call_user_func_array( $postfilter[0], array(
                        $compiled_content,
                        $this
                    ) );
                    $this->_plugins['postfilter'][$filter_name][3] = TRUE;
                }
                else
                {
                    $this->_trigger_fatal_error( "Smarty plugin error: postfilter '{$filter_name}' is not implemented" );
                }
            }
        }
        $template_header = "<?php /* Smarty version ".$this->_version.", created on ".strftime( "%Y-%m-%d %H:%M:%S" )."\n";
        $template_header .= "         compiled from ".strtr( urlencode( $resource_name ), array( "%2F" => "/", "%3A" => ":" ) )." */ ?>\n";
        $this->_plugins_code = "";
        if ( count( $this->_plugin_info ) )
        {
            $_plugins_params = "array('plugins' => array(";
            foreach ( $this->_plugin_info as $plugin_type => $plugins )
            {
                foreach ( $plugins as $plugin_name => $plugin_info )
                {
                    $_plugins_params .= "array('{$plugin_type}', '{$plugin_name}', '".strtr( $plugin_info[0], array( "'" => "\\'", "\\" => "\\\\" ) )."', {$plugin_info['1']}, ";
                    $_plugins_params .= $plugin_info[2] ? "true)," : "false),";
                }
            }
            $_plugins_params .= "))";
            $plugins_code = "<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');\nsmarty_core_load_plugins({$_plugins_params}, \$this); ?>\n";
            $template_header .= $plugins_code;
            $this->_plugin_info = array( );
            $this->_plugins_code = $plugins_code;
        }
        if ( $this->_init_smarty_vars )
        {
            $template_header .= "<?php require_once(SMARTY_CORE_DIR . 'core.assign_smarty_interface.php');\nsmarty_core_assign_smarty_interface(null, \$this); ?>\n";
            $this->_init_smarty_vars = FALSE;
        }
        $compiled_content = $template_header.$compiled_content;
        return TRUE;
    }

    public function _compile_tag( $template_tag )
    {
        if ( substr( $template_tag, 0, 1 ) == "*" && substr( $template_tag, 0 - 1 ) == "*" )
        {
            return "";
        }
        if ( !preg_match( "~^(?:(".$this->_num_const_regexp."|".$this->_obj_call_regexp."|".$this->_var_regexp."|\\/?".$this->_reg_obj_regexp."|\\/?".$this->_func_regexp.")(".$this->_mod_regexp."*))\n                      (?:\\s+(.*))?\$\n                    ~xs", $template_tag, $match ) )
        {
            $this->_syntax_error( "unrecognized tag: {$template_tag}", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 446 );
        }
        $tag_command = $match[1];
        $tag_modifier = isset( $match[2] ) ? $match[2] : NULL;
        $tag_args = isset( $match[3] ) ? $match[3] : NULL;
        if ( preg_match( "~^".$this->_num_const_regexp."|".$this->_obj_call_regexp."|".$this->_var_regexp."\$~", $tag_command ) )
        {
            $_return = $this->_parse_var_props( $tag_command.$tag_modifier );
            return "<?php echo {$_return}; ?>".$this->_additional_newline;
        }
        if ( preg_match( "~^\\/?".$this->_reg_obj_regexp."\$~", $tag_command ) )
        {
            return $this->_compile_registered_object_tag( $tag_command, $this->_parse_attrs( $tag_args ), $tag_modifier );
        }
        switch ( $tag_command )
        {
        case "include" :
            return $this->_compile_include_tag( $tag_args );
        case "include_php" :
            return $this->_compile_include_php_tag( $tag_args );
        case "if" :
            $this->_push_tag( "if" );
            return $this->_compile_if_tag( $tag_args );
        case "else" :
            list( $_open_tag ) = end( $this->_tag_stack );
            if ( $_open_tag != "if" && $_open_tag != "elseif" )
            {
                $this->_syntax_error( "unexpected {else}", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 478 );
            }
            else
            {
                $this->_push_tag( "else" );
            }
            return "<?php else: ?>";
        case "elseif" :
            list( $_open_tag ) = end( $this->_tag_stack );
            if ( $_open_tag != "if" && $_open_tag != "elseif" )
            {
                $this->_syntax_error( "unexpected {elseif}", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 486 );
            }
            if ( $_open_tag == "if" )
            {
                $this->_push_tag( "elseif" );
            }
            return $this->_compile_if_tag( $tag_args, TRUE );
        case "/if" :
            $this->_pop_tag( "if" );
            return "<?php endif; ?>";
        case "capture" :
            return $this->_compile_capture_tag( TRUE, $tag_args );
        case "/capture" :
            return $this->_compile_capture_tag( FALSE );
        case "ldelim" :
            return $this->left_delimiter;
        case "rdelim" :
            return $this->right_delimiter;
        case "section" :
            $this->_push_tag( "section" );
            return $this->_compile_section_start( $tag_args );
        case "sectionelse" :
            $this->_push_tag( "sectionelse" );
            return "<?php endfor; else: ?>";
            break;
        case "/section" :
            $_open_tag = $this->_pop_tag( "section" );
            if ( $_open_tag == "sectionelse" )
            {
                return "<?php endif; ?>";
            }
            else
            {
                return "<?php endfor; endif; ?>";
            }
        case "foreach" :
            $this->_push_tag( "foreach" );
            return $this->_compile_foreach_start( $tag_args );
            break;
        case "foreachelse" :
            $this->_push_tag( "foreachelse" );
            return "<?php endforeach; else: ?>";
        case "/foreach" :
            $_open_tag = $this->_pop_tag( "foreach" );
            if ( $_open_tag == "foreachelse" )
            {
                return "<?php endif; unset(\$_from); ?>";
            }
            else
            {
                return "<?php endforeach; endif; unset(\$_from); ?>";
            }
            break;
        case "strip" :
        case "/strip" :
            if ( substr( $tag_command, 0, 1 ) == "/" )
            {
                $this->_pop_tag( "strip" );
                if ( --$this->_strip_depth == 0 )
                {
                    $this->_additional_newline = "\n";
                    return "{".$tag_command."}";
                }
            }
            else
            {
                $this->_push_tag( "strip" );
                if ( $this->_strip_depth++ == 0 )
                {
                    $this->_additional_newline = "";
                    return "{".$tag_command."}";
                }
            }
            return "";
        case "php" :
            list( , $block ) = each( $this->_folded_blocks );
            $this->_current_line_no += substr_count( $block[0], "\n" );
            switch ( count( $block ) )
            {
            case 2 :
                return "";
            case 3 :
                return "<?php echo '".strtr( $block[2], array( "'" => "\\'", "\\" => "\\\\" ) )."'; ?>".$this->_additional_newline;
            case 4 :
                if ( $this->security && !$this->security_settings['PHP_TAGS'] )
                {
                    $this->_syntax_error( "(secure mode) php tags not permitted", E_USER_WARNING, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 572 );
                    return;
                }
                return "<?php ".$block[3]." ?>";
            }
            break;
        case "insert" :
            return $this->_compile_insert_tag( $tag_args );
        }
        do
        {
            if ( $this->_compile_compiler_tag( $tag_command, $tag_args, $output ) )
            {
                return $output;
            }
            else if ( $this->_compile_block_tag( $tag_command, $tag_args, $tag_modifier, $output ) )
            {
                return $output;
            }
            else if ( $this->_compile_custom_tag( $tag_command, $tag_args, $tag_modifier, $output ) )
            {
                return $output;
            }
            else
            {
                $this->_syntax_error( "unrecognized tag '{$tag_command}'", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 590 );
            }
            break;
        } while ( 1 );
    }

    public function _compile_compiler_tag( $tag_command, $tag_args, &$output )
    {
        $found = FALSE;
        $have_function = TRUE;
        if ( isset( $this->_plugins['compiler'][$tag_command] ) )
        {
            $found = TRUE;
            $plugin_func = $this->_plugins['compiler'][$tag_command][0];
            if ( !is_callable( $plugin_func ) )
            {
                $message = "compiler function '{$tag_command}' is not implemented";
                $have_function = FALSE;
            }
        }
        else if ( $plugin_file = $this->_get_plugin_filepath( "compiler", $tag_command ) )
        {
            $found = TRUE;
            include_once( $plugin_file );
            $plugin_func = "smarty_compiler_".$tag_command;
            if ( !is_callable( $plugin_func ) )
            {
                $message = "plugin function {$plugin_func}() not found in {$plugin_file}\n";
                $have_function = FALSE;
            }
            else
            {
                $this->_plugins['compiler'][$tag_command] = array(
                    $plugin_func,
                    NULL,
                    NULL,
                    NULL,
                    TRUE
                );
            }
        }
        if ( $found )
        {
            if ( $have_function )
            {
                $output = call_user_func_array( $plugin_func, array(
                    $tag_args,
                    $this
                ) );
                if ( $output != "" )
                {
                    $output = "<?php ".$this->_push_cacheable_state( "compiler", $tag_command ).$output.$this->_pop_cacheable_state( "compiler", $tag_command )." ?>";
                }
            }
            else
            {
                $this->_syntax_error( $message, E_USER_WARNING, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 656 );
            }
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    public function _compile_block_tag( $tag_command, $tag_args, $tag_modifier, &$output )
    {
        if ( substr( $tag_command, 0, 1 ) == "/" )
        {
            $start_tag = FALSE;
            $tag_command = substr( $tag_command, 1 );
        }
        else
        {
            $start_tag = TRUE;
        }
        $found = FALSE;
        $have_function = TRUE;
        if ( isset( $this->_plugins['block'][$tag_command] ) )
        {
            $found = TRUE;
            $plugin_func = $this->_plugins['block'][$tag_command][0];
            if ( !is_callable( $plugin_func ) )
            {
                $message = "block function '{$tag_command}' is not implemented";
                $have_function = FALSE;
            }
        }
        else if ( $plugin_file = $this->_get_plugin_filepath( "block", $tag_command ) )
        {
            $found = TRUE;
            include_once( $plugin_file );
            $plugin_func = "smarty_block_".$tag_command;
            if ( !function_exists( $plugin_func ) )
            {
                $message = "plugin function {$plugin_func}() not found in {$plugin_file}\n";
                $have_function = FALSE;
            }
            else
            {
                $this->_plugins['block'][$tag_command] = array(
                    $plugin_func,
                    NULL,
                    NULL,
                    NULL,
                    TRUE
                );
            }
        }
        if ( !$found )
        {
            return FALSE;
        }
        else if ( !$have_function )
        {
            $this->_syntax_error( $message, E_USER_WARNING, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 720 );
            return TRUE;
        }
        $this->_add_plugin( "block", $tag_command );
        if ( $start_tag )
        {
            $this->_push_tag( $tag_command );
        }
        else
        {
            $this->_pop_tag( $tag_command );
        }
        if ( $start_tag )
        {
            $output = "<?php ".$this->_push_cacheable_state( "block", $tag_command );
            $attrs = $this->_parse_attrs( $tag_args );
            $_cache_attrs = "";
            $arg_list = $this->_compile_arg_list( "block", $tag_command, $attrs, $_cache_attrs );
            $output .= "{$_cache_attrs}\$this->_tag_stack[] = array('{$tag_command}', array(".implode( ",", $arg_list ).")); ";
            $output .= "\$_block_repeat=true;".$this->_compile_plugin_call( "block", $tag_command )."(\$this->_tag_stack[count(\$this->_tag_stack)-1][1], null, \$this, \$_block_repeat);";
            $output .= "while (\$_block_repeat) { ob_start(); ?>";
        }
        else
        {
            $output = "<?php \$_block_content = ob_get_contents(); ob_end_clean(); ";
            $_out_tag_text = $this->_compile_plugin_call( "block", $tag_command )."(\$this->_tag_stack[count(\$this->_tag_stack)-1][1], \$_block_content, \$this, \$_block_repeat)";
            if ( $tag_modifier != "" )
            {
                $this->_parse_modifiers( $_out_tag_text, $tag_modifier );
            }
            $output .= "\$_block_repeat=false;echo ".$_out_tag_text."; } ";
            $output .= " array_pop(\$this->_tag_stack); ".$this->_pop_cacheable_state( "block", $tag_command )."?>";
        }
        return TRUE;
    }

    public function _compile_custom_tag( $tag_command, $tag_args, $tag_modifier, &$output )
    {
        $found = FALSE;
        $have_function = TRUE;
        if ( isset( $this->_plugins['function'][$tag_command] ) )
        {
            $found = TRUE;
            $plugin_func = $this->_plugins['function'][$tag_command][0];
            if ( !is_callable( $plugin_func ) )
            {
                $message = "custom function '{$tag_command}' is not implemented";
                $have_function = FALSE;
            }
        }
        else if ( $plugin_file = $this->_get_plugin_filepath( "function", $tag_command ) )
        {
            $found = TRUE;
            include_once( $plugin_file );
            $plugin_func = "smarty_function_".$tag_command;
            if ( !function_exists( $plugin_func ) )
            {
                $message = "plugin function {$plugin_func}() not found in {$plugin_file}\n";
                $have_function = FALSE;
            }
            else
            {
                $this->_plugins['function'][$tag_command] = array(
                    $plugin_func,
                    NULL,
                    NULL,
                    NULL,
                    TRUE
                );
            }
        }
        if ( !$found )
        {
            return FALSE;
        }
        else if ( !$have_function )
        {
            $this->_syntax_error( $message, E_USER_WARNING, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 805 );
            return TRUE;
        }
        $this->_add_plugin( "function", $tag_command );
        $_cacheable_state = $this->_push_cacheable_state( "function", $tag_command );
        $attrs = $this->_parse_attrs( $tag_args );
        $_cache_attrs = "";
        $arg_list = $this->_compile_arg_list( "function", $tag_command, $attrs, $_cache_attrs );
        $output = $this->_compile_plugin_call( "function", $tag_command )."(array(".implode( ",", $arg_list )."), \$this)";
        if ( $tag_modifier != "" )
        {
            $this->_parse_modifiers( $output, $tag_modifier );
        }
        if ( $output != "" )
        {
            $output = "<?php ".$_cacheable_state.$_cache_attrs."echo ".$output.";".$this->_pop_cacheable_state( "function", $tag_command )."?>".$this->_additional_newline;
        }
        return TRUE;
    }

    public function _compile_registered_object_tag( $tag_command, $attrs, $tag_modifier )
    {
        if ( substr( $tag_command, 0, 1 ) == "/" )
        {
            $start_tag = FALSE;
            $tag_command = substr( $tag_command, 1 );
        }
        else
        {
            $start_tag = TRUE;
        }
        list( $object, $obj_comp ) = explode( "->", $tag_command );
        $arg_list = array( );
        if ( count( $attrs ) )
        {
            $_assign_var = FALSE;
            foreach ( $attrs as $arg_name => $arg_value )
            {
                if ( $arg_name == "assign" )
                {
                    $_assign_var = $arg_value;
                    unset( $attrs['assign'] );
                    continue;
                }
                if ( is_bool( $arg_value ) )
                {
                    $arg_value = $arg_value ? "true" : "false";
                }
                $arg_list[] = "'{$arg_name}' => {$arg_value}";
            }
        }
        if ( $this->_reg_objects[$object][2] )
        {
            $args = "array(".implode( ",", ( array )$arg_list )."), \$this";
        }
        else
        {
            $args = implode( ",", array_values( $attrs ) );
            if ( empty( $args ) )
            {
                $args = "";
            }
        }
        $prefix = "";
        $postfix = "";
        $newline = "";
        if ( !is_object( $this->_reg_objects[$object][0] ) )
        {
            $this->_trigger_fatal_error( "registered '{$object}' is not an object", $this->_current_file, $this->_current_line_no, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 880 );
        }
        else if ( !empty( $this->_reg_objects[$object][1] ) && !in_array( $obj_comp, $this->_reg_objects[$object][1] ) )
        {
            $this->_trigger_fatal_error( "'{$obj_comp}' is not a registered component of object '{$object}'", $this->_current_file, $this->_current_line_no, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 882 );
        }
        else if ( method_exists( $this->_reg_objects[$object][0], $obj_comp ) )
        {
            if ( in_array( $obj_comp, $this->_reg_objects[$object][3] ) )
            {
                if ( $start_tag )
                {
                    $prefix = "\$this->_tag_stack[] = array('{$obj_comp}', {$args}); ";
                    $prefix .= "\$_block_repeat=true; \$this->_reg_objects['{$object}'][0]->{$obj_comp}(\$this->_tag_stack[count(\$this->_tag_stack)-1][1], null, \$this, \$_block_repeat); ";
                    $prefix .= "while (\$_block_repeat) { ob_start();";
                    $return = NULL;
                    $postfix = "";
                }
                else
                {
                    $prefix = "\$_obj_block_content = ob_get_contents(); ob_end_clean(); \$_block_repeat=false;";
                    $return = "\$this->_reg_objects['{$object}'][0]->{$obj_comp}(\$this->_tag_stack[count(\$this->_tag_stack)-1][1], \$_obj_block_content, \$this, \$_block_repeat)";
                    $postfix = "} array_pop(\$this->_tag_stack);";
                }
            }
            else
            {
                $return = "\$this->_reg_objects['{$object}'][0]->{$obj_comp}({$args})";
            }
        }
        else
        {
            $return = "\$this->_reg_objects['{$object}'][0]->{$obj_comp}";
        }
        if ( $return != NULL )
        {
            if ( $tag_modifier != "" )
            {
                $this->_parse_modifiers( $return, $tag_modifier );
            }
            if ( !empty( $_assign_var ) )
            {
                $output = "\$this->assign('".$this->_dequote( $_assign_var )."',  {$return});";
            }
            else
            {
                $output = "echo ".$return.";";
                $newline = $this->_additional_newline;
            }
        }
        else
        {
            $output = "";
        }
        return "<?php ".$prefix.$output.$postfix."?>".$newline;
    }

    public function _compile_insert_tag( $tag_args )
    {
        $attrs = $this->_parse_attrs( $tag_args );
        $name = $this->_dequote( $attrs['name'] );
        if ( empty( $name ) )
        {
            return $this->_syntax_error( "missing insert name", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 937 );
        }
        if ( !preg_match( "~^\\w+\$~", $name ) )
        {
            return $this->_syntax_error( "'insert: 'name' must be an insert function name", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 941 );
        }
        if ( !empty( $attrs['script'] ) )
        {
            $delayed_loading = TRUE;
        }
        else
        {
            $delayed_loading = FALSE;
        }
        foreach ( $attrs as $arg_name => $arg_value )
        {
            if ( is_bool( $arg_value ) )
            {
                $arg_value = $arg_value ? "true" : "false";
            }
            $arg_list[] = "'{$arg_name}' => {$arg_value}";
        }
        $this->_add_plugin( "insert", $name, $delayed_loading );
        $_params = "array('args' => array(".implode( ", ", ( array )$arg_list )."))";
        return "<?php require_once(SMARTY_CORE_DIR . 'core.run_insert_handler.php');\necho smarty_core_run_insert_handler({$_params}, \$this); ?>".$this->_additional_newline;
    }

    public function _compile_include_tag( $tag_args )
    {
        $attrs = $this->_parse_attrs( $tag_args );
        $arg_list = array( );
        if ( empty( $attrs['file'] ) )
        {
            $this->_syntax_error( "missing 'file' attribute in include tag", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 975 );
        }
        foreach ( $attrs as $arg_name => $arg_value )
        {
            if ( $arg_name == "file" )
            {
                $include_file = $arg_value;
                continue;
            }
            else if ( $arg_name == "assign" )
            {
                $assign_var = $arg_value;
                continue;
            }
            if ( is_bool( $arg_value ) )
            {
                $arg_value = $arg_value ? "true" : "false";
            }
            $arg_list[] = "'{$arg_name}' => {$arg_value}";
        }
        $output = "<?php ";
        if ( isset( $assign_var ) )
        {
            $output .= "ob_start();\n";
        }
        $output .= "\$_smarty_tpl_vars = \$this->_tpl_vars;\n";
        $_params = "array('smarty_include_tpl_file' => ".$include_file.", 'smarty_include_vars' => array(".implode( ",", ( array )$arg_list )."))";
        $output .= "\$this->_smarty_include({$_params});\n"."\$this->_tpl_vars = \$_smarty_tpl_vars;\n"."unset(\$_smarty_tpl_vars);\n";
        if ( isset( $assign_var ) )
        {
            $output .= "\$this->assign(".$assign_var.", ob_get_contents()); ob_end_clean();\n";
        }
        $output .= " ?>";
        return $output;
    }

    public function _compile_include_php_tag( $tag_args )
    {
        $attrs = $this->_parse_attrs( $tag_args );
        if ( empty( $attrs['file'] ) )
        {
            $this->_syntax_error( "missing 'file' attribute in include_php tag", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1027 );
        }
        $assign_var = empty( $attrs['assign'] ) ? "" : $this->_dequote( $attrs['assign'] );
        $once_var = empty( $attrs['once'] ) || $attrs['once'] == "false" ? "false" : "true";
        $arg_list = array( );
        foreach ( $attrs as $arg_name => $arg_value )
        {
            if ( $arg_name != "file" && $arg_name != "once" && $arg_name != "assign" )
            {
                if ( is_bool( $arg_value ) )
                {
                    $arg_value = $arg_value ? "true" : "false";
                }
                $arg_list[] = "'{$arg_name}' => {$arg_value}";
            }
        }
        $_params = "array('smarty_file' => ".$attrs['file'].", 'smarty_assign' => '{$assign_var}', 'smarty_once' => {$once_var}, 'smarty_include_vars' => array(".implode( ",", $arg_list )."))";
        return "<?php require_once(SMARTY_CORE_DIR . 'core.smarty_include_php.php');\nsmarty_core_smarty_include_php({$_params}, \$this); ?>".$this->_additional_newline;
    }

    public function _compile_section_start( $tag_args )
    {
        $attrs = $this->_parse_attrs( $tag_args );
        $arg_list = array( );
        $output = "<?php ";
        $section_name = $attrs['name'];
        if ( empty( $section_name ) )
        {
            $this->_syntax_error( "missing section name", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1062 );
        }
        $output .= "unset(\$this->_sections[{$section_name}]);\n";
        $section_props = "\$this->_sections[{$section_name}]";
        foreach ( $attrs as $attr_name => $attr_value )
        {
            switch ( $attr_name )
            {
            case "loop" :
                $output .= "{$section_props}['loop'] = is_array(\$_loop={$attr_value}) ? count(\$_loop) : max(0, (int)\$_loop); unset(\$_loop);\n";
                break;
            case "show" :
                if ( is_bool( $attr_value ) )
                {
                    $show_attr_value = $attr_value ? "true" : "false";
                }
                else
                {
                    $show_attr_value = "(bool){$attr_value}";
                }
                $output .= "{$section_props}['show'] = {$show_attr_value};\n";
                break;
            case "name" :
                $output .= "{$section_props}['{$attr_name}'] = {$attr_value};\n";
                break;
            case "max" :
            case "start" :
                $output .= "{$section_props}['{$attr_name}'] = (int){$attr_value};\n";
                break;
            case "step" :
                $output .= "{$section_props}['{$attr_name}'] = ((int){$attr_value}) == 0 ? 1 : (int){$attr_value};\n";
                break;
            }
            do
            {
                $this->_syntax_error( "unknown section attribute - '{$attr_name}'", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1096 );
                break;
            } while ( 1 );
        }
        if ( !isset( $attrs['show'] ) )
        {
            $output .= "{$section_props}['show'] = true;\n";
        }
        if ( !isset( $attrs['loop'] ) )
        {
            $output .= "{$section_props}['loop'] = 1;\n";
        }
        if ( !isset( $attrs['max'] ) )
        {
            $output .= "{$section_props}['max'] = {$section_props}['loop'];\n";
        }
        else
        {
            $output .= "if ({$section_props}['max'] < 0)\n"."    {$section_props}['max'] = {$section_props}['loop'];\n";
        }
        if ( !isset( $attrs['step'] ) )
        {
            $output .= "{$section_props}['step'] = 1;\n";
        }
        if ( !isset( $attrs['start'] ) )
        {
            $output .= "{$section_props}['start'] = {$section_props}['step'] > 0 ? 0 : {$section_props}['loop']-1;\n";
        }
        else
        {
            $output .= "if ({$section_props}['start'] < 0)\n"."    {$section_props}['start'] = max({$section_props}['step'] > 0 ? 0 : -1, {$section_props}['loop'] + {$section_props}['start']);\n"."else\n"."    {$section_props}['start'] = min({$section_props}['start'], {$section_props}['step'] > 0 ? {$section_props}['loop'] : {$section_props}['loop']-1);\n";
        }
        $output .= "if ({$section_props}['show']) {\n";
        if ( !isset( $attrs['start'] ) && !isset( $attrs['step'] ) && !isset( $attrs['max'] ) )
        {
            $output .= "    {$section_props}['total'] = {$section_props}['loop'];\n";
        }
        else
        {
            $output .= "    {$section_props}['total'] = min(ceil(({$section_props}['step'] > 0 ? {$section_props}['loop'] - {$section_props}['start'] : {$section_props}['start']+1)/abs({$section_props}['step'])), {$section_props}['max']);\n";
        }
        $output .= "    if ({$section_props}['total'] == 0)\n"."        {$section_props}['show'] = false;\n"."} else\n"."    {$section_props}['total'] = 0;\n";
        $output .= "if ({$section_props}['show']):\n";
        $output .= "\n            for ({$section_props}['index'] = {$section_props}['start'], {$section_props}['iteration'] = 1;\n                 {$section_props}['iteration'] <= {$section_props}['total'];\n                 {$section_props}['index'] += {$section_props}['step'], {$section_props}['iteration']++):\n";
        $output .= "{$section_props}['rownum'] = {$section_props}['iteration'];\n";
        $output .= "{$section_props}['index_prev'] = {$section_props}['index'] - {$section_props}['step'];\n";
        $output .= "{$section_props}['index_next'] = {$section_props}['index'] + {$section_props}['step'];\n";
        $output .= "{$section_props}['first']      = ({$section_props}['iteration'] == 1);\n";
        $output .= "{$section_props}['last']       = ({$section_props}['iteration'] == {$section_props}['total']);\n";
        $output .= "?>";
        return $output;
    }

    public function _compile_foreach_start( $tag_args )
    {
        $attrs = $this->_parse_attrs( $tag_args );
        $arg_list = array( );
        if ( empty( $attrs['from'] ) )
        {
            return $this->_syntax_error( "foreach: missing 'from' attribute", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1165 );
        }
        $from = $attrs['from'];
        if ( empty( $attrs['item'] ) )
        {
            return $this->_syntax_error( "foreach: missing 'item' attribute", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1170 );
        }
        $item = $this->_dequote( $attrs['item'] );
        if ( !preg_match( "~^\\w+\$~", $item ) )
        {
            return $this->_syntax_error( "foreach: 'item' must be a variable name (literal string)", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1174 );
        }
        if ( isset( $attrs['key'] ) )
        {
            $key = $this->_dequote( $attrs['key'] );
            if ( !preg_match( "~^\\w+\$~", $key ) )
            {
                return $this->_syntax_error( "foreach: 'key' must to be a variable name (literal string)", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1180 );
            }
            $key_part = "\$this->_tpl_vars['{$key}'] => ";
        }
        else
        {
            $key = NULL;
            $key_part = "";
        }
        if ( isset( $attrs['name'] ) )
        {
            $name = $attrs['name'];
        }
        else
        {
            $name = NULL;
        }
        $output = "<?php ";
        $output .= "\$_from = {$from}; if (!is_array(\$_from) && !is_object(\$_from)) { settype(\$_from, 'array'); }";
        if ( isset( $name ) )
        {
            $foreach_props = "\$this->_foreach[{$name}]";
            $output .= "{$foreach_props} = array('total' => count(\$_from), 'iteration' => 0);\n";
            $output .= "if ({$foreach_props}['total'] > 0):\n";
            $output .= "    foreach (\$_from as {$key_part}\$this->_tpl_vars['{$item}']):\n";
            $output .= "        {$foreach_props}['iteration']++;\n";
        }
        else
        {
            $output .= "if (count(\$_from)):\n";
            $output .= "    foreach (\$_from as {$key_part}\$this->_tpl_vars['{$item}']):\n";
        }
        $output .= "?>";
        return $output;
    }

    public function _compile_capture_tag( $start, $tag_args = "" )
    {
        $attrs = $this->_parse_attrs( $tag_args );
        if ( $start )
        {
            $buffer = isset( $attrs['name'] ) ? $attrs['name'] : "'default'";
            $assign = isset( $attrs['assign'] ) ? $attrs['assign'] : NULL;
            $append = isset( $attrs['append'] ) ? $attrs['append'] : NULL;
            $output = "<?php ob_start(); ?>";
            $this->_capture_stack[] = array(
                $buffer,
                $assign,
                $append
            );
        }
        else
        {
            list( $buffer, $assign, $append ) = array_pop( $this->_capture_stack );
            $output = "<?php \$this->_smarty_vars['capture'][{$buffer}] = ob_get_contents(); ";
            if ( isset( $assign ) )
            {
                $output .= " \$this->assign({$assign}, ob_get_contents());";
            }
            if ( isset( $append ) )
            {
                $output .= " \$this->append({$append}, ob_get_contents());";
            }
            $output .= "ob_end_clean(); ?>";
        }
        return $output;
    }

    public function _compile_if_tag( $tag_args, $elseif = FALSE )
    {
        preg_match_all( "~(?>\n                ".$this->_obj_call_regexp."(?:".$this->_mod_regexp."*)? | # valid object call\n                ".$this->_var_regexp."(?:".$this->_mod_regexp."*)?    | # var or quoted string\n                \\-?0[xX][0-9a-fA-F]+|\\-?\\d+(?:\\.\\d+)?|\\.\\d+|!==|===|==|!=|<>|<<|>>|<=|>=|\\&\\&|\\|\\||\\(|\\)|,|\\!|\\^|=|\\&|\\~|<|>|\\||\\%|\\+|\\-|\\/|\\*|\\@    | # valid non-word token\n                \\b\\w+\\b                                                        | # valid word token\n                \\S+                                                           # anything else\n                )~x", $tag_args, $match );
        $tokens = $match[0];
        if ( empty( $tokens ) )
        {
            $_error_msg = $elseif ? "'elseif'" : "'if'";
            $_error_msg .= " statement requires arguments";
            $this->_syntax_error( $_error_msg, E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1270 );
        }
        $token_count = array_count_values( $tokens );
        if ( isset( $token_count['('] ) && $token_count['('] != $token_count[')'] )
        {
            $this->_syntax_error( "unbalanced parenthesis in if statement", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1277 );
        }
        $is_arg_stack = array( );
        $i = 0;
        for ( ; $i < count( $tokens ); $i++ )
        {
            $token =& $tokens[$i];
            switch ( strtolower( $token ) )
            {
            case "!" :
            case "%" :
            case "!==" :
            case "==" :
            case "===" :
            case ">" :
            case "<" :
            case "!=" :
            case "<>" :
            case "<<" :
            case ">>" :
            case "<=" :
            case ">=" :
            case "&&" :
            case "||" :
            case "|" :
            case "^" :
            case "&" :
            case "~" :
            case ")" :
            case "," :
            case "+" :
            case "-" :
            case "*" :
            case "/" :
            case "@" :
                break;
            case "eq" :
                $token = "==";
                break;
            case "ne" :
            case "neq" :
                $token = "!=";
                break;
            case "lt" :
                $token = "<";
                break;
            case "le" :
            case "lte" :
                $token = "<=";
                break;
            case "gt" :
                $token = ">";
                break;
            case "ge" :
            case "gte" :
                $token = ">=";
                break;
            case "and" :
                $token = "&&";
                break;
            case "or" :
                $token = "||";
                break;
            case "not" :
                $token = "!";
                break;
            case "mod" :
                $token = "%";
                break;
            case "(" :
                array_push( $is_arg_stack, $i );
                break;
            case "is" :
                if ( $tokens[$i - 1] == ")" )
                {
                    $is_arg_start = array_pop( $is_arg_stack );
                    if ( $is_arg_start != 0 )
                    {
                        if ( preg_match( "~^".$this->_func_regexp."\$~", $tokens[$is_arg_start - 1] ) )
                        {
                            $is_arg_start--;
                        }
                    }
                }
                else
                {
                    $is_arg_start = $i - 1;
                }
                $is_arg = implode( " ", array_slice( $tokens, $is_arg_start, $i - $is_arg_start ) );
                $new_tokens = $this->_parse_is_expr( $is_arg, array_slice( $tokens, $i + 1 ) );
                array_splice( $tokens, $is_arg_start, count( $tokens ), $new_tokens );
                $i = $is_arg_start;
                break;
            default :
                do
                {
                    if ( preg_match( "~^".$this->_func_regexp."\$~", $token ) )
                    {
                        if ( $this->security && !in_array( $token, $this->security_settings['IF_FUNCS'] ) )
                        {
                            $this->_syntax_error( "(secure mode) '{$token}' not allowed in if statement", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1399 );
                        }
                    }
                    else if ( preg_match( "~^".$this->_var_regexp."\$~", $token ) && strpos( "+-*/^%&|", substr( $token, 0 - 1 ) ) === FALSE && isset( $tokens[$i + 1] ) && $tokens[$i + 1] == "(" )
                    {
                        $this->_syntax_error( "variable function call '{$token}' not allowed in if statement", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1403 );
                    }
                    else if ( preg_match( "~^".$this->_obj_call_regexp."|".$this->_var_regexp."(?:".$this->_mod_regexp."*)\$~", $token ) )
                    {
                        $token = $this->_parse_var_props( $token );
                    }
                    else if ( is_numeric( $token ) )
                    {
                    }
                    else
                    {
                        $this->_syntax_error( "unidentified token '{$token}'", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1410 );
                    }
                    break;
                } while ( 1 );
            }
        }
        if ( $elseif )
        {
            return "<?php elseif (".implode( " ", $tokens )."): ?>";
        }
        else
        {
            return "<?php if (".implode( " ", $tokens )."): ?>";
        }
    }

    public function _compile_arg_list( $type, $name, $attrs, &$cache_code )
    {
        $arg_list = array( );
        if ( isset( $type, $name ) && isset( $this->_plugins[$type] ) && isset( $this->_plugins[$type][$name] ) && empty( $this->_plugins[$type][$name][4] ) && is_array( $this->_plugins[$type][$name][5] ) )
        {
            $_cache_attrs = $this->_plugins[$type][$name][5];
            $_count = $this->_cache_attrs_count++;
            $cache_code = "\$_cache_attrs =& \$this->_smarty_cache_attrs('{$this->_cache_serial}','{$_count}');";
        }
        else
        {
            $_cache_attrs = NULL;
        }
        foreach ( $attrs as $arg_name => $arg_value )
        {
            if ( is_bool( $arg_value ) )
            {
                $arg_value = $arg_value ? "true" : "false";
            }
            if ( is_null( $arg_value ) )
            {
                $arg_value = "null";
            }
            if ( $_cache_attrs && in_array( $arg_name, $_cache_attrs ) )
            {
                $arg_list[] = "'{$arg_name}' => (\$this->_cache_including) ? \$_cache_attrs['{$arg_name}'] : (\$_cache_attrs['{$arg_name}']={$arg_value})";
            }
            else
            {
                $arg_list[] = "'{$arg_name}' => {$arg_value}";
            }
        }
        return $arg_list;
    }

    public function _parse_is_expr( $is_arg, $tokens )
    {
        $expr_end = 0;
        $negate_expr = FALSE;
        if ( ( $first_token = array_shift( $tokens ) ) == "not" )
        {
            $negate_expr = TRUE;
            $expr_type = array_shift( $tokens );
        }
        else
        {
            $expr_type = $first_token;
        }
        switch ( $expr_type )
        {
        case "even" :
            if ( isset( $tokens[$expr_end] ) && $tokens[$expr_end] == "by" )
            {
                $expr_end++;
                $expr_arg = $tokens[$expr_end++];
                $expr = "!(1 & ({$is_arg} / ".$this->_parse_var_props( $expr_arg )."))";
            }
            else
            {
                $expr = "!(1 & {$is_arg})";
            }
            break;
        case "odd" :
            if ( isset( $tokens[$expr_end] ) && $tokens[$expr_end] == "by" )
            {
                $expr_end++;
                $expr_arg = $tokens[$expr_end++];
                $expr = "(1 & ({$is_arg} / ".$this->_parse_var_props( $expr_arg )."))";
            }
            else
            {
                $expr = "(1 & {$is_arg})";
            }
            break;
        case "div" :
            if ( $tokens[$expr_end] == "by" )
            {
                $expr_end++;
                $expr_arg = $tokens[$expr_end++];
                $expr = "!({$is_arg} % ".$this->_parse_var_props( $expr_arg ).")";
            }
            else
            {
                $this->_syntax_error( "expecting 'by' after 'div'", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1499 );
            }
            break;
        }
        do
        {
            $this->_syntax_error( "unknown 'is' expression - '{$expr_type}'", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1504 );
            break;
        } while ( 1 );
        if ( $negate_expr )
        {
            $expr = "!({$expr})";
        }
        array_splice( $tokens, 0, $expr_end, $expr );
        return $tokens;
    }

    public function _parse_attrs( $tag_args )
    {
        preg_match_all( "~(?:".$this->_obj_call_regexp."|".$this->_qstr_regexp." | (?>[^\"'=\\s]+)\n                         )+ |\n                         [=]\n                        ~x", $tag_args, $match );
        $tokens = $match[0];
        $attrs = array( );
        $state = 0;
        foreach ( $tokens as $token )
        {
            switch ( $state )
            {
            case 0 :
                if ( preg_match( "~^\\w+\$~", $token ) )
                {
                    $attr_name = $token;
                    $state = 1;
                }
                else
                {
                    $this->_syntax_error( "invalid attribute name: '{$token}'", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1550 );
                }
                break;
            case 1 :
                if ( $token == "=" )
                {
                    $state = 2;
                }
                else
                {
                    $this->_syntax_error( "expecting '=' after attribute name '{$last_token}'", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1558 );
                }
                break;
            case 2 :
                if ( $token != "=" )
                {
                    if ( preg_match( "~^(on|yes|true)\$~", $token ) )
                    {
                        $token = "true";
                    }
                    else if ( preg_match( "~^(off|no|false)\$~", $token ) )
                    {
                        $token = "false";
                    }
                    else if ( $token == "null" )
                    {
                        $token = "null";
                    }
                    else if ( preg_match( "~^".$this->_num_const_regexp."|0[xX][0-9a-fA-F]+\$~", $token ) )
                    {
                    }
                    else if ( !preg_match( "~^".$this->_obj_call_regexp."|".$this->_var_regexp."(?:".$this->_mod_regexp.")*\$~", $token ) )
                    {
                        $token = "\"".addslashes( $token )."\"";
                    }
                    $attrs[$attr_name] = $token;
                    $state = 0;
                }
                else
                {
                    $this->_syntax_error( "'=' cannot be an attribute value", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1583 );
                }
                break;
            }
            $last_token = $token;
        }
        if ( $state != 0 )
        {
            if ( $state == 1 )
            {
                $this->_syntax_error( "expecting '=' after attribute name '{$last_token}'", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1591 );
            }
            else
            {
                $this->_syntax_error( "missing attribute value", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1593 );
            }
        }
        $this->_parse_vars_props( $attrs );
        return $attrs;
    }

    public function _parse_vars_props( &$tokens )
    {
        foreach ( $tokens as $key => $val )
        {
            $tokens[$key] = $this->_parse_var_props( $val );
        }
    }

    public function _parse_var_props( $val )
    {
        $val = trim( $val );
        if ( preg_match( "~^(".$this->_obj_call_regexp."|".$this->_dvar_regexp.")(".$this->_mod_regexp."*)\$~", $val, $match ) )
        {
            $return = $this->_parse_var( $match[1] );
            $modifiers = $match[2];
            if ( !empty( $this->default_modifiers ) && !preg_match( "~(^|\\|)smarty:nodefaults(\$|\\|)~", $modifiers ) )
            {
                $_default_mod_string = implode( "|", ( array )$this->default_modifiers );
                $modifiers = empty( $modifiers ) ? $_default_mod_string : $_default_mod_string."|".$modifiers;
            }
            $this->_parse_modifiers( $return, $modifiers );
            return $return;
        }
        else if ( preg_match( "~^".$this->_db_qstr_regexp."(?:".$this->_mod_regexp."*)\$~", $val ) )
        {
            preg_match( "~^(".$this->_db_qstr_regexp.")(".$this->_mod_regexp."*)\$~", $val, $match );
            $return = $this->_expand_quoted_text( $match[1] );
            if ( $match[2] != "" )
            {
                $this->_parse_modifiers( $return, $match[2] );
            }
            return $return;
        }
        else if ( preg_match( "~^".$this->_num_const_regexp."(?:".$this->_mod_regexp."*)\$~", $val ) )
        {
            preg_match( "~^(".$this->_num_const_regexp.")(".$this->_mod_regexp."*)\$~", $val, $match );
            if ( $match[2] != "" )
            {
                $this->_parse_modifiers( $match[1], $match[2] );
                return $match[1];
            }
        }
        else if ( preg_match( "~^".$this->_si_qstr_regexp."(?:".$this->_mod_regexp."*)\$~", $val ) )
        {
            preg_match( "~^(".$this->_si_qstr_regexp.")(".$this->_mod_regexp."*)\$~", $val, $match );
            if ( $match[2] != "" )
            {
                $this->_parse_modifiers( $match[1], $match[2] );
                return $match[1];
            }
        }
        else if ( preg_match( "~^".$this->_cvar_regexp."(?:".$this->_mod_regexp."*)\$~", $val ) )
        {
            return $this->_parse_conf_var( $val );
        }
        else if ( preg_match( "~^".$this->_svar_regexp."(?:".$this->_mod_regexp."*)\$~", $val ) )
        {
            return $this->_parse_section_prop( $val );
        }
        else if ( !in_array( $val, $this->_permitted_tokens ) && !is_numeric( $val ) )
        {
            return $this->_expand_quoted_text( "\"".strtr( $val, array( "\\" => "\\\\", "\"" => "\\\"" ) )."\"" );
        }
        return $val;
    }

    public function _expand_quoted_text( $var_expr )
    {
        if ( preg_match_all( "~(?:\\`(?<!\\\\)\\\$".$this->_dvar_guts_regexp."(?:".$this->_obj_ext_regexp.")*\\`)|(?:(?<!\\\\)\\\$\\w+(\\[[a-zA-Z0-9]+\\])*)~", $var_expr, $_match ) )
        {
            $_match = $_match[0];
            $_replace = array( );
            foreach ( $_match as $_var )
            {
                $_replace[$_var] = "\".(".$this->_parse_var( str_replace( "`", "", $_var ) ).").\"";
            }
            $var_expr = strtr( $var_expr, $_replace );
            $_return = preg_replace( "~\\.\"\"|(?<!\\\\)\"\"\\.~", "", $var_expr );
        }
        else
        {
            $_return = $var_expr;
        }
        $_return = preg_replace( "~^\"([\\s\\w]+)\"\$~", "'\\1'", $_return );
        return $_return;
    }

    public function _parse_var( $var_expr )
    {
        $_has_math = FALSE;
        $_math_vars = preg_split( "~(".$this->_dvar_math_regexp."|".$this->_qstr_regexp.")~", $var_expr, 0 - 1, PREG_SPLIT_DELIM_CAPTURE );
        if ( 1 < count( $_math_vars ) )
        {
            $_first_var = "";
            $_complete_var = "";
            $_output = "";
            foreach ( $_math_vars as $_k => $_math_var )
            {
                $_math_var = $_math_vars[$_k];
                if ( !empty( $_math_var ) || is_numeric( $_math_var ) )
                {
                    if ( preg_match( "~^".$this->_dvar_math_regexp."\$~", $_math_var ) )
                    {
                        $_has_math = TRUE;
                        if ( !empty( $_complete_var ) || is_numeric( $_complete_var ) )
                        {
                            $_output .= $this->_parse_var( $_complete_var );
                        }
                        $_output .= $_math_var;
                        if ( empty( $_first_var ) )
                        {
                            $_first_var = $_complete_var;
                        }
                        $_complete_var = "";
                    }
                    else
                    {
                        $_complete_var .= $_math_var;
                    }
                }
            }
            if ( $_has_math )
            {
                if ( !empty( $_complete_var ) || is_numeric( $_complete_var ) )
                {
                    $_output .= $this->_parse_var( $_complete_var );
                }
                $var_expr = $_complete_var;
            }
        }
        if ( is_numeric( substr( $var_expr, 0, 1 ) ) )
        {
            $_var_ref = $var_expr;
        }
        else
        {
            $_var_ref = substr( $var_expr, 1 );
        }
        if ( !$_has_math )
        {
            preg_match_all( "~(?:^\\w+)|".$this->_obj_params_regexp."|(?:".$this->_var_bracket_regexp.")|->\\\$?\\w+|\\.\\\$?\\w+|\\S+~", $_var_ref, $match );
            $_indexes = $match[0];
            $_var_name = array_shift( $_indexes );
            if ( $_var_name == "smarty" )
            {
                if ( ( $smarty_ref = $this->_compile_smarty_ref( $_indexes ) ) !== NULL )
                {
                    $_output = $smarty_ref;
                }
                else
                {
                    $_var_name = substr( array_shift( $_indexes ), 1 );
                    $_output = "\$this->_smarty_vars['{$_var_name}']";
                }
            }
            else if ( is_numeric( $_var_name ) && is_numeric( substr( $var_expr, 0, 1 ) ) )
            {
                if ( 0 < count( $_indexes ) )
                {
                    $_var_name .= implode( "", $_indexes );
                    $_indexes = array( );
                }
                $_output = $_var_name;
            }
            else
            {
                $_output = "\$this->_tpl_vars['{$_var_name}']";
            }
            foreach ( $_indexes as $_index )
            {
                if ( substr( $_index, 0, 1 ) == "[" )
                {
                    $_index = substr( $_index, 1, 0 - 1 );
                    if ( is_numeric( $_index ) )
                    {
                        $_output .= "[{$_index}]";
                    }
                    else if ( substr( $_index, 0, 1 ) == "\$" )
                    {
                        if ( strpos( $_index, "." ) !== FALSE )
                        {
                            $_output .= "[".$this->_parse_var( $_index )."]";
                        }
                        else
                        {
                            $_output .= "[\$this->_tpl_vars['".substr( $_index, 1 )."']]";
                        }
                    }
                    else
                    {
                        $_var_parts = explode( ".", $_index );
                        $_var_section = $_var_parts[0];
                        $_var_section_prop = isset( $_var_parts[1] ) ? $_var_parts[1] : "index";
                        $_output .= "[\$this->_sections['{$_var_section}']['{$_var_section_prop}']]";
                    }
                }
                else if ( substr( $_index, 0, 1 ) == "." )
                {
                    if ( substr( $_index, 1, 1 ) == "\$" )
                    {
                        $_output .= "[\$this->_tpl_vars['".substr( $_index, 2 )."']]";
                    }
                    else
                    {
                        $_output .= "['".substr( $_index, 1 )."']";
                    }
                }
                else if ( substr( $_index, 0, 2 ) == "->" )
                {
                    if ( substr( $_index, 2, 2 ) == "__" )
                    {
                        $this->_syntax_error( "call to internal object members is not allowed", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1814 );
                    }
                    else if ( $this->security && substr( $_index, 2, 1 ) == "_" )
                    {
                        $this->_syntax_error( "(secure) call to private object member is not allowed", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1816 );
                    }
                    else if ( substr( $_index, 2, 1 ) == "\$" )
                    {
                        if ( $this->security )
                        {
                            $this->_syntax_error( "(secure) call to dynamic object member is not allowed", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1819 );
                        }
                        else
                        {
                            $_output .= "->{((\$_var=\$this->_tpl_vars['".substr( $_index, 3 )."']) && substr(\$_var,0,2)!='__') ? \$_var : \$this->trigger_error(\"cannot access property \\\"\$_var\\\"\")}";
                        }
                    }
                    else
                    {
                        $_output .= $_index;
                    }
                }
                else if ( substr( $_index, 0, 1 ) == "(" )
                {
                    $_index = $this->_parse_parenth_args( $_index );
                    $_output .= $_index;
                }
                else
                {
                    $_output .= $_index;
                }
            }
        }
        return $_output;
    }

    public function _parse_parenth_args( $parenth_args )
    {
        preg_match_all( "~".$this->_param_regexp."~", $parenth_args, $match );
        $orig_vals = $match = $match[0];
        $this->_parse_vars_props( $match );
        $replace = array( );
        $i = 0;
        $count = count( $match );
        for ( ; $i < $count; $i++ )
        {
            $replace[$orig_vals[$i]] = $match[$i];
        }
        return strtr( $parenth_args, $replace );
    }

    public function _parse_conf_var( $conf_var_expr )
    {
        $parts = explode( "|", $conf_var_expr, 2 );
        $var_ref = $parts[0];
        $modifiers = isset( $parts[1] ) ? $parts[1] : "";
        $var_name = substr( $var_ref, 1, 0 - 1 );
        $output = "\$this->_config[0]['vars']['{$var_name}']";
        $this->_parse_modifiers( $output, $modifiers );
        return $output;
    }

    public function _parse_section_prop( $section_prop_expr )
    {
        $parts = explode( "|", $section_prop_expr, 2 );
        $var_ref = $parts[0];
        $modifiers = isset( $parts[1] ) ? $parts[1] : "";
        preg_match( "!%(\\w+)\\.(\\w+)%!", $var_ref, $match );
        $section_name = $match[1];
        $prop_name = $match[2];
        $output = "\$this->_sections['{$section_name}']['{$prop_name}']";
        $this->_parse_modifiers( $output, $modifiers );
        return $output;
    }

    public function _parse_modifiers( &$output, $modifier_string )
    {
        preg_match_all( "~\\|(@?\\w+)((?>:(?:".$this->_qstr_regexp."|[^|]+))*)~", "|".$modifier_string, $_match );
        list( , $_modifiers, $modifier_arg_strings ) = $_match;
        $_i = 0;
        $_for_max = count( $_modifiers );
        for ( ; $_i < $_for_max; $_i++ )
        {
            $_modifier_name = $_modifiers[$_i];
            if ( $_modifier_name == "smarty" )
            {
                continue;
            }
            preg_match_all( "~:(".$this->_qstr_regexp."|[^:]+)~", $modifier_arg_strings[$_i], $_match );
            $_modifier_args = $_match[1];
            if ( substr( $_modifier_name, 0, 1 ) == "@" )
            {
                $_map_array = FALSE;
                $_modifier_name = substr( $_modifier_name, 1 );
            }
            else
            {
                $_map_array = TRUE;
            }
            if ( empty( $this->_plugins['modifier'][$_modifier_name] ) && !$this->_get_plugin_filepath( "modifier", $_modifier_name ) && function_exists( $_modifier_name ) )
            {
                if ( $this->security && !in_array( $_modifier_name, $this->security_settings['MODIFIER_FUNCS'] ) )
                {
                    $this->_trigger_fatal_error( "[plugin] (secure mode) modifier '{$_modifier_name}' is not allowed", $this->_current_file, $this->_current_line_no, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 1934 );
                }
                else
                {
                    $this->_plugins['modifier'][$_modifier_name] = array(
                        $_modifier_name,
                        NULL,
                        NULL,
                        FALSE
                    );
                }
            }
            $this->_add_plugin( "modifier", $_modifier_name );
            $this->_parse_vars_props( $_modifier_args );
            if ( $_modifier_name == "default" )
            {
                if ( substr( $output, 0, 1 ) == "\$" )
                {
                    $output = "@".$output;
                }
                if ( isset( $_modifier_args[0] ) && substr( $_modifier_args[0], 0, 1 ) == "\$" )
                {
                    $_modifier_args[0] = "@".$_modifier_args[0];
                }
            }
            if ( 0 < count( $_modifier_args ) )
            {
                $_modifier_args = ", ".implode( ", ", $_modifier_args );
            }
            else
            {
                $_modifier_args = "";
            }
            if ( $_map_array )
            {
                $output = "((is_array(\$_tmp={$output})) ? \$this->_run_mod_handler('{$_modifier_name}', true, \$_tmp{$_modifier_args}) : ".$this->_compile_plugin_call( "modifier", $_modifier_name )."(\$_tmp{$_modifier_args}))";
            }
            else
            {
                $output = $this->_compile_plugin_call( "modifier", $_modifier_name )."({$output}{$_modifier_args})";
            }
        }
    }

    public function _add_plugin( $type, $name, $delayed_loading = NULL )
    {
        if ( !isset( $this->_plugin_info[$type] ) )
        {
            $this->_plugin_info[$type] = array( );
        }
        if ( !isset( $this->_plugin_info[$type][$name] ) )
        {
            $this->_plugin_info[$type][$name] = array(
                $this->_current_file,
                $this->_current_line_no,
                $delayed_loading
            );
        }
    }

    public function _compile_smarty_ref( &$indexes )
    {
        $_ref = substr( $indexes[0], 1 );
        foreach ( $indexes as $_index_no => $_index )
        {
            if ( substr( $_index, 0, 1 ) != "." && $_index_no < 2 || !preg_match( "~^(\\.|\\[|->)~", $_index ) )
            {
                $this->_syntax_error( "\$smarty".implode( "", array_slice( $indexes, 0, 2 ) )." is an invalid reference", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 2001 );
            }
        }
        switch ( $_ref )
        {
        case "now" :
            $compiled_ref = "time()";
            $_max_index = 1;
            break;
        case "foreach" :
            array_shift( $indexes );
            $_var = $this->_parse_var_props( substr( $indexes[0], 1 ) );
            $_propname = substr( $indexes[1], 1 );
            $_max_index = 1;
            switch ( $_propname )
            {
            case "index" :
                array_shift( $indexes );
                $compiled_ref = "(\$this->_foreach[{$_var}]['iteration']-1)";
                break;
            case "first" :
                array_shift( $indexes );
                $compiled_ref = "(\$this->_foreach[{$_var}]['iteration'] <= 1)";
                break;
            case "last" :
                array_shift( $indexes );
                $compiled_ref = "(\$this->_foreach[{$_var}]['iteration'] == \$this->_foreach[{$_var}]['total'])";
                break;
            case "show" :
                array_shift( $indexes );
                $compiled_ref = "(\$this->_foreach[{$_var}]['total'] > 0)";
                break;
            }
            do
            {
                unset( $_max_index );
                $compiled_ref = "\$this->_foreach[{$_var}]";
                break;
            } while ( 1 );
            break;
        case "section" :
            array_shift( $indexes );
            $_var = $this->_parse_var_props( substr( $indexes[0], 1 ) );
            $compiled_ref = "\$this->_sections[{$_var}]";
            break;
        case "get" :
            $compiled_ref = $this->request_use_auto_globals ? "\$_GET" : "\$GLOBALS['HTTP_GET_VARS']";
            break;
        case "post" :
            $compiled_ref = $this->request_use_auto_globals ? "\$_POST" : "\$GLOBALS['HTTP_POST_VARS']";
            break;
        case "cookies" :
            $compiled_ref = $this->request_use_auto_globals ? "\$_COOKIE" : "\$GLOBALS['HTTP_COOKIE_VARS']";
            break;
        case "env" :
            $compiled_ref = $this->request_use_auto_globals ? "\$_ENV" : "\$GLOBALS['HTTP_ENV_VARS']";
            break;
        case "server" :
            $compiled_ref = $this->request_use_auto_globals ? "\$_SERVER" : "\$GLOBALS['HTTP_SERVER_VARS']";
            break;
        case "session" :
            $compiled_ref = $this->request_use_auto_globals ? "\$_SESSION" : "\$GLOBALS['HTTP_SESSION_VARS']";
            break;
        case "request" :
            if ( $this->request_use_auto_globals )
            {
                $compiled_ref = "\$_REQUEST";
                break;
            }
            else
            {
                $this->_init_smarty_vars = TRUE;
            }
            return;
        case "capture" :
            return;
        case "template" :
            $compiled_ref = "'{$this->_current_file}'";
            $_max_index = 1;
            break;
        case "version" :
            $compiled_ref = "'{$this->_version}'";
            $_max_index = 1;
            break;
        case "const" :
            if ( $this->security && !$this->security_settings['ALLOW_CONSTANTS'] )
            {
                $this->_syntax_error( "(secure mode) constants not permitted", E_USER_WARNING, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 2102 );
                return;
            }
            array_shift( $indexes );
            if ( preg_match( "!^\\.\\w+\$!", $indexes[0] ) )
            {
                $compiled_ref = "@".substr( $indexes[0], 1 );
            }
            else
            {
                $_val = $this->_parse_var_props( substr( $indexes[0], 1 ) );
                $compiled_ref = "@constant(".$_val.")";
            }
            $_max_index = 1;
            break;
        case "config" :
            $compiled_ref = "\$this->_config[0]['vars']";
            $_max_index = 3;
            break;
        case "ldelim" :
            $compiled_ref = "'{$this->left_delimiter}'";
            break;
        case "rdelim" :
            $compiled_ref = "'{$this->right_delimiter}'";
            break;
        }
        do
        {
            $this->_syntax_error( "\$smarty.".$_ref." is an unknown reference", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 2129 );
            break;
        } while ( 1 );
        if ( isset( $_max_index ) && $_max_index < count( $indexes ) )
        {
            $this->_syntax_error( "\$smarty".implode( "", $indexes )." is an invalid reference", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 2134 );
        }
        array_shift( $indexes );
        return $compiled_ref;
    }

    public function _compile_plugin_call( $type, $name )
    {
        if ( isset( $this->_plugins[$type][$name] ) )
        {
            if ( is_array( $this->_plugins[$type][$name][0] ) )
            {
                return ( is_object( $this->_plugins[$type][$name][0][0] ) ? "\$this->_plugins['{$type}']['{$name}'][0][0]->" : ( boolean )$this->_plugins[$type][$name][0][0]."::" ).$this->_plugins[$type][$name][0][1];
            }
            else
            {
                return $this->_plugins[$type][$name][0];
            }
        }
        else
        {
            return "smarty_".$type."_".$name;
        }
    }

    public function _load_filters( )
    {
        if ( 0 < count( $this->_plugins['prefilter'] ) )
        {
            foreach ( $this->_plugins['prefilter'] as $filter_name => $prefilter )
            {
                if ( $prefilter === FALSE )
                {
                    unset( $this->prefilter[$filter_name] );
                    $_params = array(
                        "plugins" => array(
                            array(
                                "prefilter",
                                $filter_name,
                                NULL,
                                NULL,
                                FALSE
                            )
                        )
                    );
                    require_once( SMARTY_CORE_DIR."core.load_plugins.php" );
                    smarty_core_load_plugins( $_params, $this );
                }
            }
        }
        if ( 0 < count( $this->_plugins['postfilter'] ) )
        {
            foreach ( $this->_plugins['postfilter'] as $filter_name => $postfilter )
            {
                if ( $postfilter === FALSE )
                {
                    unset( $this->postfilter[$filter_name] );
                    $_params = array(
                        "plugins" => array(
                            array(
                                "postfilter",
                                $filter_name,
                                NULL,
                                NULL,
                                FALSE
                            )
                        )
                    );
                    require_once( SMARTY_CORE_DIR."core.load_plugins.php" );
                    smarty_core_load_plugins( $_params, $this );
                }
            }
        }
    }

    public function _quote_replace( $string )
    {
        return strtr( $string, array( "\\" => "\\\\", "\$" => "\\\$" ) );
    }

    public function _syntax_error( $error_msg, $error_type = E_USER_ERROR, $file = NULL, $line = NULL )
    {
        $this->_trigger_fatal_error( "syntax error: {$error_msg}", $this->_current_file, $this->_current_line_no, $file, $line, $error_type );
    }

    public function _push_cacheable_state( $type, $name )
    {
        $_cacheable = !isset( $this->_plugins[$type][$name] ) || $this->_plugins[$type][$name][4];
        if ( $_cacheable || 0 < $this->_cacheable_state++ )
        {
            return "";
        }
        if ( !isset( $this->_cache_serial ) )
        {
            $this->_cache_serial = md5( uniqid( "Smarty" ) );
        }
        $_ret = "if (\$this->caching && !\$this->_cache_including): echo '{nocache:".$this->_cache_serial."#".$this->_nocache_count."}'; endif;";
        return $_ret;
    }

    public function _pop_cacheable_state( $type, $name )
    {
        $_cacheable = !isset( $this->_plugins[$type][$name] ) || $this->_plugins[$type][$name][4];
        if ( $_cacheable || 0 < --$this->_cacheable_state )
        {
            return "";
        }
        return "if (\$this->caching && !\$this->_cache_including): echo '{/nocache:".$this->_cache_serial."#".$this->_nocache_count++."}'; endif;";
    }

    public function _push_tag( $open_tag )
    {
        array_push( $this->_tag_stack, array(
            $open_tag,
            $this->_current_line_no
        ) );
    }

    public function _pop_tag( $close_tag )
    {
        $message = "";
        if ( 0 < count( $this->_tag_stack ) )
        {
            list( $_open_tag, $_line_no ) = array_pop( $this->_tag_stack );
            if ( $close_tag == $_open_tag )
            {
                return $_open_tag;
            }
            if ( $close_tag == "if" && ( $_open_tag == "else" || $_open_tag == "elseif" ) )
            {
                return $this->_pop_tag( $close_tag );
            }
            if ( $close_tag == "section" && $_open_tag == "sectionelse" )
            {
                $this->_pop_tag( $close_tag );
                return $_open_tag;
            }
            if ( $close_tag == "foreach" && $_open_tag == "foreachelse" )
            {
                $this->_pop_tag( $close_tag );
                return $_open_tag;
            }
            if ( $_open_tag == "else" || $_open_tag == "elseif" )
            {
                $_open_tag = "if";
            }
            else if ( $_open_tag == "sectionelse" )
            {
                $_open_tag = "section";
            }
            else if ( $_open_tag == "foreachelse" )
            {
                $_open_tag = "foreach";
            }
            $message = " expected {/{$_open_tag}} (opened line {$_line_no}).";
        }
        $this->_syntax_error( "mismatched tag {/{$close_tag}}.{$message}", E_USER_ERROR, "C:\\DeZender.DeIoncuber.29.11.2011\\DeIoncuber.29.11.2011\\bin\\rm\\file.php", 2303 );
    }

}

?>
